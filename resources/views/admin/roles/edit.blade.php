@extends('base')

@section('title', 'Rol bewerken')

@section('content')

    <h1 class="mb-4">Rol bewerken</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('admin.roles.update', $role) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">
                Naam
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name', $role->name) }}"
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

        <button type="submit" class="btn btn-primary">
            Wijzigingen opslaan
        </button>

        <a href="{{ route('admin.roles.index') }}"
           class="btn btn-secondary">
            Annuleren
        </a>
    </form>

@endsection