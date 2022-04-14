@extends('layouts.header')

@section('title')
    <title>Public files</title>
@endsection

@section('description')
    <meta name="description" content="Homepage with shared public files">
@endsection

@section('content')
    @if(auth()->user()->is_admin)
        <p> Admin</p>
    @else
        <p> Student</p>
    @endif

@endsection


