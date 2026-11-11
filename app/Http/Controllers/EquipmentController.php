<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipmentController extends Controller
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

    // INVENTORY SUMMARY
    private function inventorySummary()
    {
        $equipments = Equipment::all();

        $quantityFor = fn (string $status) => (int) $equipments
            ->where('status', $status)
            ->sum(fn ($equipment) => (int) ($equipment->quantity ?? 0));

        return [
            'equipments' => $equipments,
            'totalQuantity' => (int) $equipments->sum(
                fn ($equipment) => (int) ($equipment->quantity ?? 0)
            ),
            'availableQuantity' => $quantityFor('Available'),
            'borrowedQuantity' => $quantityFor('Borrowed'),
            'maintenanceQuantity' => $quantityFor('Under Maintenance'),
        ];
    }

    // DASHBOARD - ALL AUTHENTICATED USERS
    public function index()
    {
        $summary = $this->inventorySummary();

        $summary['recentEquipments'] = $summary['equipments']
            ->sortByDesc('created_at')
            ->take(6)
            ->values();

        return view('dashboard', $summary);
    }

    // VIEW INVENTORY - ALL AUTHENTICATED USERS
    public function inventory()
    {
        $equipments = Equipment::all()
            ->sortBy('name')
            ->values();

        return view('equipments.index', compact('equipments'));
    }

    // CREATE EQUIPMENT - ADMIN AND STAFF
    public function create()
    {
        $this->requireAnyRole([
            'admin',
            'administrator',
            'staff'
        ]);

        return view('equipments.create');
    }

    // EDIT EQUIPMENT - ADMIN AND STAFF
    public function edit(string $id)
    {
        $this->requireAnyRole([
            'admin',
            'administrator',
            'staff'
        ]);

        $equipment = Equipment::findOrFail($id);

        return view('equipments.edit', compact('equipment'));
    }

    // ANALYTICS - ADMIN ONLY
    public function analytics()
    {
        $this->requireAnyRole([
            'admin',
            'administrator'
        ]);

        $summary = $this->inventorySummary();

        $statusBreakdown = [
            'Available' => $summary['availableQuantity'],
            'Borrowed' => $summary['borrowedQuantity'],
            'Under Maintenance' => $summary['maintenanceQuantity'],
        ];

        $categoryBreakdown = $summary['equipments']
            ->groupBy(fn ($equipment) => $equipment->category ?: 'Uncategorized')
            ->map(fn ($items) => (int) $items->sum(
                fn ($equipment) => (int) ($equipment->quantity ?? 0)
            ))
            ->sortDesc()
            ->take(6);

        return view('analytics', array_merge($summary, [
            'statusBreakdown' => $statusBreakdown,
            'categoryBreakdown' => $categoryBreakdown,
            'maxCategoryQuantity' => (int) ($categoryBreakdown->max() ?? 0),
            'recordCount' => $summary['equipments']->count(),
        ]));
    }

    // SETTINGS - ADMIN ONLY
    public function settings()
    {
        $this->requireAnyRole([
            'admin',
            'administrator'
        ]);

        return view('settings', [
            'recordCount' => Equipment::count(),
        ]);
    }

    // SAVE EQUIPMENT - ADMIN AND STAFF
    public function store(Request $request)
    {
        $this->requireAnyRole([
            'admin',
            'administrator',
            'staff'
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => [
                'required',
                Rule::in([
                    'Available',
                    'Borrowed',
                    'Under Maintenance'
                ])
            ],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        Equipment::create($validated);

        return redirect()
            ->route('equipment.index')
            ->with('success', 'Equipment added successfully.');
    }

    // UPDATE EQUIPMENT - ADMIN AND STAFF
    public function update(Request $request, string $id)
    {
        $this->requireAnyRole([
            'admin',
            'administrator',
            'staff'
        ]);

        $equipment = Equipment::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => [
                'required',
                Rule::in([
                    'Available',
                    'Borrowed',
                    'Under Maintenance'
                ])
            ],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $equipment->update($validated);

        return redirect()
            ->route('equipment.index')
            ->with('success', 'Equipment updated successfully.');
    }

    // DELETE EQUIPMENT - ADMIN ONLY
    public function destroy(string $id)
    {
        $this->requireAnyRole([
            'admin',
            'administrator'
        ]);

        $equipment = Equipment::findOrFail($id);

        $equipment->delete();

        return redirect()
            ->route('equipment.index')
            ->with('success', 'Equipment deleted successfully.');
    }
}
