@extends('layouts.app')

@section('title', 'Analytics')
@section('page-title', 'Analytics')
@section('page-subtitle', 'Understand equipment distribution and current status at a glance.')

@section('content')
<div class="stats-grid">
    <section class="stat-card"><div class="stat-top"><span>Total units</span><span class="stat-icon icon-blue">▤</span></div><div class="stat-value">{{ number_format($totalQuantity) }}</div><div class="stat-note">Across all categories</div></section>
    <section class="stat-card"><div class="stat-top"><span>Available</span><span class="stat-icon icon-green">✓</span></div><div class="stat-value">{{ number_format($availableQuantity) }}</div><div class="stat-note">{{ $totalQuantity ? round($availableQuantity / $totalQuantity * 100) : 0 }}% of all units</div></section>
    <section class="stat-card"><div class="stat-top"><span>Borrowed</span><span class="stat-icon icon-amber">↗</span></div><div class="stat-value">{{ number_format($borrowedQuantity) }}</div><div class="stat-note">{{ $totalQuantity ? round($borrowedQuantity / $totalQuantity * 100) : 0 }}% of all units</div></section>
    <section class="stat-card"><div class="stat-top"><span>Maintenance</span><span class="stat-icon icon-red">⚒</span></div><div class="stat-value">{{ number_format($maintenanceQuantity) }}</div><div class="stat-note">{{ $totalQuantity ? round($maintenanceQuantity / $totalQuantity * 100) : 0 }}% of all units</div></section>
</div>
<div class="analytics-grid">
    <section class="panel">
        <div class="panel-head"><div><h2>Equipment by status</h2><p class="panel-desc">Share of total registered units.</p></div></div>
        @foreach($statusBreakdown as $label => $amount)
            @php($percent = $totalQuantity > 0 ? round(($amount / $totalQuantity) * 100) : 0)
            <div class="bar-row"><div class="bar-label"><span>{{ $label }}</span><span>{{ number_format($amount) }} · {{ $percent }}%</span></div><div class="bar-track"><div class="bar-fill" style="width:{{ $percent }}%"></div></div></div>
        @endforeach
    </section>
    <section class="panel">
        <div class="panel-head"><div><h2>Top categories</h2><p class="panel-desc">Quantity grouped by equipment category.</p></div></div>
        @forelse($categoryBreakdown as $category => $amount)
            @php($percent = $maxCategoryQuantity > 0 ? round(($amount / $maxCategoryQuantity) * 100) : 0)
            <div class="bar-row"><div class="bar-label"><span>{{ $category ?: 'Uncategorized' }}</span><span>{{ number_format($amount) }}</span></div><div class="bar-track"><div class="bar-fill" style="width:{{ $percent }}%"></div></div></div>
        @empty
            <div class="empty">No category data is available yet.</div>
        @endforelse
    </section>
</div>
<section class="panel">
    <div class="panel-head"><div><h2>Inventory summary</h2><p class="panel-desc">Number of distinct equipment records and total units.</p></div><a href="{{ route('equipment.index') }}" class="btn btn-light">Open inventory →</a></div>
    <div class="setting-row"><div><strong>Equipment records</strong><small>Distinct entries saved in the inventory</small></div><strong>{{ number_format($recordCount) }}</strong></div>
    <div class="setting-row"><div><strong>Total units</strong><small>Sum of all equipment quantities</small></div><strong>{{ number_format($totalQuantity) }}</strong></div>
</section>
@endsection
