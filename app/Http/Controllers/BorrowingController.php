<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Equipment;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    // CHECK USER ROLE
    private function requireAnyRole(array $roles): void
    {
        $role = strtolower(trim((string) auth()->user()?->role));

        abort_unless(
            in_array($role, $roles, true),
            403,
            'You are not authorized to access this feature.'
        );
    }

    // BORROWING HISTORY
    public function index()
    {
        $role = strtolower(trim((string) auth()->user()->role));

        $borrowings = Borrowing::all()
            ->filter(function ($borrowing) use ($role) {

                if (in_array($role, [
                    'admin',
                    'administrator',
                    'staff',
                    'teacher'
                ], true)) {
                    return true;
                }

                return (string) $borrowing->user_id
                    === (string) auth()->id();
            })
            ->sortByDesc('created_at')
            ->values();

        return view('borrowings.index', compact('borrowings'));
    }

    // SHOW BORROWING FORM
   
public function create(Request $request)
{
    $this->requireAnyRole(['student']);

    $equipments = Equipment::all()
        ->filter(function ($equipment) {
            return $equipment->status !== 'Under Maintenance'
                && $equipment->available_quantity > 0;
        })
        ->sortBy('name')
        ->values();

    // Get selected equipment from Borrow button
    $selectedEquipmentId = $request->query('equipment_id');

    // Verify that equipment is available
    $selectedEquipment = $equipments->first(function ($equipment) use ($selectedEquipmentId) {
        return (string) $equipment->getKey() === (string) $selectedEquipmentId;
    });

    $selectedEquipmentId = $selectedEquipment
        ? $selectedEquipment->getKey()
        : null;

    return view('borrowings.create', compact(
        'equipments',
        'selectedEquipmentId'
    ));
}


    // SUBMIT BORROWING REQUEST
    public function store(Request $request)
    {
        $this->requireAnyRole(['student']);

        $validated = $request->validate([
            'equipment_id' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'purpose' => ['required', 'string', 'max:1000'],
            'expected_return_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
        ]);

        $equipment = Equipment::findOrFail(
            $validated['equipment_id']
        );

        if ($equipment->status === 'Under Maintenance') {
            return back()
                ->withInput()
                ->with('error', 'This equipment is under maintenance.');
        }

        if ($validated['quantity'] > $equipment->available_quantity) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Not enough available equipment quantity.'
                );
        }

        Borrowing::create([
            'user_id' => (string) auth()->id(),
            'user_name' => auth()->user()->name,
            'user_email' => auth()->user()->email,

            'equipment_id' => (string) $equipment->getKey(),
            'equipment_name' => $equipment->name,
            'category' => $equipment->category,
            'quantity' => $validated['quantity'],

            'purpose' => $validated['purpose'],
            'request_date' => now(),
            'expected_return_date' =>
                $validated['expected_return_date'],

            'status' => 'Pending',
        ]);

        return redirect()
            ->route('borrowings.index')
            ->with(
                'success',
                'Borrowing request submitted successfully.'
            );
    }

    // APPROVE BORROWING REQUEST
    public function approve(string $id)
    {
        $this->requireAnyRole([
            'admin',
            'administrator',
            'teacher'
        ]);

        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'Pending') {
            return back()->with(
                'error',
                'Only pending requests can be approved.'
            );
        }

        $equipment = Equipment::findOrFail(
            $borrowing->equipment_id
        );

        $quantity = (int) $borrowing->quantity;

        if ($equipment->status === 'Under Maintenance') {
            return back()->with(
                'error',
                'Equipment is currently under maintenance.'
            );
        }

        if ($quantity > $equipment->available_quantity) {
            return back()->with(
                'error',
                'Insufficient available quantity.'
            );
        }

        // RESERVE THE APPROVED QUANTITY
        $equipment->borrowed_quantity =
            (int) ($equipment->borrowed_quantity ?? 0)
            + $quantity;

        $equipment->save();

        $borrowing->status = 'Approved';
        $borrowing->approved_by = (string) auth()->id();
        $borrowing->approved_at = now();

        $borrowing->save();

        return back()->with(
            'success',
            'Borrowing request approved successfully.'
        );
    }

    // REJECT BORROWING REQUEST
    public function reject(Request $request, string $id)
    {
        $this->requireAnyRole([
            'admin',
            'administrator',
            'teacher'
        ]);

        $validated = $request->validate([
            'rejection_reason' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'Pending') {
            return back()->with(
                'error',
                'Only pending requests can be rejected.'
            );
        }

        $borrowing->status = 'Rejected';
        $borrowing->approved_by = (string) auth()->id();
        $borrowing->approved_at = now();

        $borrowing->rejection_reason =
            $validated['rejection_reason'] ?? null;

        $borrowing->save();

        return back()->with(
            'success',
            'Borrowing request rejected.'
        );
    }

    // RELEASE EQUIPMENT TO STUDENT
    public function release(string $id)
    {
        $this->requireAnyRole([
            'admin',
            'administrator',
            'staff',
            'teacher'
        ]);

        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'Approved') {
            return back()->with(
                'error',
                'Only approved requests can be released.'
            );
        }

        $borrowing->status = 'Released';
        $borrowing->released_by = (string) auth()->id();
        $borrowing->released_at = now();

        $borrowing->save();

        return back()->with(
            'success',
            'Equipment released to student successfully.'
        );
    }

    // RETURN EQUIPMENT
    public function markReturned(Request $request, string $id)
    {
        $this->requireAnyRole([
            'admin',
            'administrator',
            'staff',
            'teacher'
        ]);

        $validated = $request->validate([
            'return_condition' => [
                'required',
                'in:Good,Damaged,Needs Repair',
            ],

            'return_notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'Released') {
            return back()->with(
                'error',
                'Only released equipment can be returned.'
            );
        }

        $equipment = Equipment::findOrFail(
            $borrowing->equipment_id
        );

        $quantity = (int) $borrowing->quantity;

        $borrowedQuantity = (int) (
            $equipment->borrowed_quantity ?? 0
        );

        if ($quantity > $borrowedQuantity) {
            return back()->with(
                'error',
                'Invalid borrowed quantity. Please check inventory.'
            );
        }

        // RESTORE AVAILABLE QUANTITY
        $equipment->borrowed_quantity =
            $borrowedQuantity - $quantity;

        // Mark damaged equipment for maintenance.
        if ($validated['return_condition'] !== 'Good') {
            $equipment->status = 'Under Maintenance';
        }

        $equipment->save();

        $borrowing->status = 'Returned';
        $borrowing->returned_by = (string) auth()->id();
        $borrowing->returned_at = now();

        $borrowing->return_condition =
            $validated['return_condition'];

        $borrowing->return_notes =
            $validated['return_notes'] ?? null;

        $borrowing->save();

        return back()->with(
            'success',
            'Equipment returned successfully.'
        );
    }
}
