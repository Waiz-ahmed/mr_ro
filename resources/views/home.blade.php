@extends('layouts.master')

@section('title', 'POS Dashboard')

@section('content')
    <div class="container">
        <h2>Welcome, {{ Auth::user()->name }}</h2>
        <p>Select a menu option to begin managing sales, customers, and more.</p>
    </div>
@endsection
