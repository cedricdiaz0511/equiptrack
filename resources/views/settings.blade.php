@extends('layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')
@section('page-subtitle', 'View the current application setup and system information.')

@section('content')
<section class="panel">
    <div class="panel-head"><div><h2>System information</h2><p class="panel-desc">Basic information about this EquipTrack installation.</p></div></div>
    <div class="setting-row"><div><strong>Application name</strong><small>Name displayed throughout the system</small></div><strong>{{ config('app.name', 'EquipTrack') }}</strong></div>
    <div class="setting-row"><div><strong>Application environment</strong><small>Current Laravel environment</small></div><strong>{{ app()->environment() }}</strong></div>
    <div class="setting-row"><div><strong>Application version</strong><small>Laravel framework version</small></div><strong>{{ app()->version() }}</strong></div>
    <div class="setting-row"><div><strong>Inventory records</strong><small>Number of equipment records currently stored</small></div><strong>{{ number_format($recordCount) }}</strong></div>
</section>
<section class="panel">
    <div class="panel-head"><div><h2>Data management</h2><p class="panel-desc">Use the inventory page to maintain equipment records.</p></div></div>
    <p class="muted" style="font-size:13px;line-height:1.7;margin:0 0 16px">Equipment details are stored using the database connection configured for this application. Database credentials and environment secrets are intentionally not displayed here.</p>
    <a href="{{ route('equipment.index') }}" class="btn btn-primary">Manage equipment →</a>
</section>
@endsection
