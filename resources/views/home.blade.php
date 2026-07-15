@extends('layouts.app')

@section('title', 'Főoldal')

@section('content')
    <h1>Üdvözöllek a Kuktában!</h1>
    @auth
        <p>Üdv újra, <strong>{{ Auth::user()->username }}</strong>!</p>
    @else
        <p>Kérlek, <a href="{{ route('login') }}">jelentkezz be</a>, hogy recepteket tölthess fel.</p>
    @endauth
@endsection    