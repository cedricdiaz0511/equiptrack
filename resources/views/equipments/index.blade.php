
@extends('layouts.app')

@section('title', 'Equipment Inventory')
@section('page-title', 'Equipment Inventory')
@section('page-subtitle', 'Search, review, and borrow available equipment.')

@section('content')

@php
    $role = strtolower(trim(auth()->user()->role ?? ''));
    $isStudent = $role === 'student';
@endphp

<style>
    .borrow-btn {
        background: #16a36a;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        display: inline-block;
    }

    .borrow-btn:hover {
        background: #128253;
        color: white;
    }

    .borrow-disabled {
        background: #e5e7eb;
        color: #64748b;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .equipment-actions {
        display: flex;
        gap: 7px;
        align-items: center;
    }
</style>

<section class="panel">

    <div class="panel-head">
        <div>
            <h2>{{ $isStudent ? 'Available Equipment' : 'All Equipment' }}</h2>

            <p class="panel-desc">
                {{ $equipments->count() }} equipment records found.
            </p>
        </div>

        @unless($isStudent)
            <a href="{{ route('equipment.create') }}" class="btn btn-primary">
                + Add equipment
            </a>
        @endunless
    </div>

    <div style="margin-bottom:16px">
        <input
            class="search"
            type="search"
            id="inventorySearch"
            placeholder="Search by name, category, or status..."
        >
    </div>

    <div class="table-wrap">

        <table id="inventoryTable">

            <thead>
                <tr>
                    <th>Equipment</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>
                        {{ $isStudent ? 'Available Quantity' : 'Total Quantity' }}
                    </th>
                    <th>Description</th>
                    <th>{{ $isStudent ? 'Borrow' : 'Actions' }}</th>
                </tr>
            </thead>

            <tbody>

            @forelse($equipments as $equipment)

                @php
                    $available = (int) $equipment->available_quantity;
                    $total = (int) $equipment->quantity;

                    // AUTOMATIC EQUIPMENT STATUS
                    if ($equipment->status === 'Under Maintenance') {
                        $displayStatus = 'Under Maintenance';
                    } elseif ($available > 0) {
                        $displayStatus = 'Available';
                    } else {
                        $displayStatus = 'Borrowed';
                    }
                @endphp

                <tr>

                    <td class="equipment-name">
                        {{ $equipment->name }}
                    </td>

                    <td>
                        {{ $equipment->category }}
                    </td>

                    {{-- AUTOMATIC STATUS DISPLAY --}}
                    <td>
                        <span class="status
                            {{ $displayStatus === 'Available'
                                ? 'status-available'
                                : ($displayStatus === 'Borrowed'
                                    ? 'status-borrowed'
                                    : 'status-maintenance') }}">

                            {{ $displayStatus }}

                        </span>
                    </td>

                    {{-- QUANTITY --}}
                    <td>
                        {{ number_format($isStudent ? $available : $total) }}
                    </td>

                    {{-- DESCRIPTION --}}
                    <td class="muted">
                        {{ \Illuminate\Support\Str::limit($equipment->description ?? '—', 55) }}
                    </td>

                    {{-- ACTIONS --}}
                    <td>

                        @if($isStudent)

                            @if(
                                $equipment->status !== 'Under Maintenance'
                                && $available > 0
                            )

                                <a
                                    href="{{ route('borrowings.create', [
                                        'equipment_id' => $equipment->getKey()
                                    ]) }}"
                                    class="borrow-btn">

                                    Borrow

                                </a>

                            @else

                                <span class="borrow-disabled">
                                    Not Available
                                </span>

                            @endif

                        @else

                            <div class="equipment-actions">

                                <a
                                    class="btn btn-light"
                                    href="{{ route('equipment.edit', $equipment->getKey()) }}">

                                    Edit

                                </a>

                                <form
                                    action="{{ route('equipment.destroy', $equipment->getKey()) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this equipment record?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger"
                                        type="submit">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="empty">
                        No equipment records found.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</section>

@endsection

@push('scripts')

<script>
document.getElementById('inventorySearch')?.addEventListener('input', function () {

    const query = this.value.toLowerCase().trim();

    document.querySelectorAll('#inventoryTable tbody tr').forEach(row => {

        row.hidden = !row.innerText.toLowerCase().includes(query);

    });

});
</script>

@endpush
