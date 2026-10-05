@extends('base')

@section('title', 'Nieuwe rol')

@section('content')

    <h1 class="mb-4">Nieuwe rol</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">
                Naam
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">
                Guard
            </label>

            <input
                type="text"
                class="form-control"
                value="web"
                disabled
            >
        </div>

        <button type="submit" class="btn btn-success">
            Opslaan
        </button>

        <a href="{{ route('admin.roles.index') }}"
           class="btn btn-secondary">
            Annuleren
        </a>
    </form>

@endsection