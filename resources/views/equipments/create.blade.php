@extends('layouts.app')

@section('title', 'Add Equipment')
@section('page-title', 'Add Equipment')
@section('page-subtitle', 'Register a new item and make it available in your inventory.')

@section('content')
<section class="panel">
    <div class="panel-head"><div><h2>Equipment information</h2><p class="panel-desc">Enter the details below. Fields marked required must be completed.</p></div></div>
    @if($errors->any())
        <div class="flash error"><strong>Please correct the following:</strong><ul style="margin:8px 0 0 18px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form action="{{ route('equipment.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group"><label for="name">Equipment name *</label><input id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Laptop" maxlength="255" required></div>
            <div class="form-group"><label for="category">Category *</label><input id="category" name="category" value="{{ old('category') }}" placeholder="e.g. Computer equipment" maxlength="255" required></div>
            <div class="form-group"><label for="status">Status *</label><select id="status" name="status" required><option value="">Select status</option>@foreach(['Available','Borrowed','Under Maintenance'] as $status)<option value="{{ $status }}" @selected(old('status') === $status)>{{ $status }}</option>@endforeach</select></div>
            <div class="form-group"><label for="quantity">Quantity *</label><input id="quantity" type="number" name="quantity" min="1" step="1" value="{{ old('quantity', 1) }}" required></div>
            <div class="form-group full"><label for="description">Description</label><textarea id="description" name="description" placeholder="Add specifications or other useful details...">{{ old('description') }}</textarea></div>
        </div>
        <div class="actions"><a href="{{ route('equipment.index') }}" class="btn btn-light">Cancel</a><button type="submit" class="btn btn-primary">Save equipment</button></div>
    </form>
</section>
@endsection
