@extends('base')

@section('title', 'Nieuwe gebruiker-rol koppeling')

@section('content')

    <h1 class="mb-4">Nieuwe gebruiker-rol koppeling</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.user-roles.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">
                Gebruiker
            </label>

            <select
                id="user_id"
                name="user_id"
                class="form-control"
                required
            >
                <option value="">Kies een gebruiker</option>

                @foreach($users as $user)
                    <option
                        value="{{ $user->id }}"
                        @selected(old('user_id') == $user->id)
                    >
                        {{ $user->name }} - {{ $user->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label">
                Rol
            </label>

            <select
                id="role_id"
                name="role_id"
                class="form-control"
                required
            >
                <option value="">Kies een rol</option>

                @foreach($roles as $role)
                    <option
                        value="{{ $role->id }}"
                        @selected(old('role_id') == $role->id)
                    >
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            Koppeling opslaan
        </button>

        <a
            href="{{ route('admin.user-roles.index') }}"
            class="btn btn-secondary"
        >
            Annuleren
        </a>
    </form>

@endsection