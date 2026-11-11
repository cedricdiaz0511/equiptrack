
@extends('layouts.app')

@section('title', 'Borrow Equipment')
@section('page-title', 'Borrow Equipment')
@section('page-subtitle', 'Submit an equipment borrowing request.')

@section('content')

<section class="panel">

    <div class="panel-head">
        <div>
            <h2>Borrowing Request Form</h2>
            <p class="panel-desc">
                Complete the information below to request equipment.
            </p>
        </div>
    </div>

    @if(session('error'))
        <div class="flash error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="flash error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('borrowings.store') }}" method="POST">
        @csrf

        <div class="form-grid">

            <div class="form-group full">
                <label for="equipment_id">Select Equipment *</label>

                <select name="equipment_id" id="equipment_id" required>
                    <option value="">Choose equipment</option>

                    @foreach($equipments as $equipment)
                        <option
                            value="{{ $equipment->getKey() }}"
                            data-available="{{ $equipment->available_quantity }}"
                            @selected((string) old('equipment_id', $selectedEquipmentId) === (string) $equipment->getKey())
                        >
                            {{ $equipment->name }}
                            ({{ $equipment->available_quantity }} available)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity *</label>

                <input
                    type="number"
                    name="quantity"
                    id="quantity"
                    min="1"
                    value="{{ old('quantity', 1) }}"
                    required
                >

                <small id="availableText"></small>
            </div>

            <div class="form-group">
                <label for="expected_return_date">
                    Expected Return Date *
                </label>

                <input
                    type="date"
                    name="expected_return_date"
                    id="expected_return_date"
                    min="{{ now()->toDateString() }}"
                    value="{{ old('expected_return_date') }}"
                    required
                >
            </div>

            <div class="form-group full">
                <label for="purpose">Purpose of Borrowing *</label>

                <textarea
                    name="purpose"
                    id="purpose"
                    rows="4"
                    maxlength="1000"
                    placeholder="Explain why you need this equipment..."
                    required
                >{{ old('purpose') }}</textarea>
            </div>

        </div>

        <div class="actions">

            <a href="{{ route('equipment.index') }}"
               class="btn btn-light">
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
                Submit Borrowing Request
            </button>

        </div>

    </form>

</section>

@endsection

@push('scripts')
<script>
const equipmentSelect = document.getElementById('equipment_id');
const quantityInput = document.getElementById('quantity');
const availableText = document.getElementById('availableText');

function updateAvailableQuantity() {
    const selected = equipmentSelect.options[equipmentSelect.selectedIndex];

    const available = selected.dataset.available;

    if (available !== undefined) {
        quantityInput.max = available;
        availableText.textContent =
            'Available quantity: ' + available;

        if (parseInt(quantityInput.value) > parseInt(available)) {
            quantityInput.value = available;
        }
    } else {
        quantityInput.removeAttribute('max');
        availableText.textContent = '';
    }
}

equipmentSelect.addEventListener('change', updateAvailableQuantity);

quantityInput.addEventListener('input', updateAvailableQuantity);

updateAvailableQuantity();
</script>
@endpush

