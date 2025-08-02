@extends('layouts.master')

@section('title', 'FBR Settings for ' . $selectedShop->name)

@section('content')
<div class="container">
    <h4>FBR Settings for {{ $selectedShop->name }}</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('settings.general.update', $selectedShop->id) }}">
        @csrf

        <div class="mb-3">
            <label for="pos_id" class="form-label">POS ID</label>
            <input type="text" id="pos_id" name="pos_id" class="form-control" value="{{ old('pos_id', $settings->pos_id ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="integration_key" class="form-label">Integration Key</label>
            <input type="text" id="integration_key" name="integration_key" class="form-control" value="{{ old('integration_key', $settings->integration_key ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="client_id" class="form-label">Client ID (Optional)</label>
            <input type="text" id="client_id" name="client_id" class="form-control" value="{{ old('client_id', $settings->client_id ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="client_secret" class="form-label">Client Secret (Optional)</label>
            <input type="text" id="client_secret" name="client_secret" class="form-control" value="{{ old('client_secret', $settings->client_secret ?? '') }}">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="enabled" name="enabled" value="1" {{ old('enabled', $settings->enabled ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="enabled">Enable FBR Integration</label>
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
        <a href="{{ route('shops.cards') }}" class="btn btn-secondary">Back to Manage Shops</a>
    </form>
</div>
@endsection
