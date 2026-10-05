@extends('base')

@section('title', 'Permissie bewerken')

@section('content')

    <h1 class="mb-4">Permissie bewerken</h1>

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
        action="{{ route('admin.permissions.update', $permission) }}"
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
                value="{{ old('name', $permission->name) }}"
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

        <a href="{{ route('admin.permissions.index') }}"
           class="btn btn-secondary">
            Annuleren
        </a>
    </form>

@endsection