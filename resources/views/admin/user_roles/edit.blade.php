@extends('base')

@section('title', 'Gebruiker-rol bewerken')

@section('content')

    <h1 class="mb-4">Gebruiker-rol bewerken</h1>

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
        action="{{ route('admin.user-roles.update', [
            $link->role_id,
            $link->model_id
        ]) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

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
                @foreach($users as $user)
                    <option
                        value="{{ $user->id }}"
                        @selected(
                            old('user_id', $link->model_id) == $user->id
                        )
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
                @foreach($roles as $role)
                    <option
                        value="{{ $role->id }}"
                        @selected(
                            old('role_id', $link->role_id) == $role->id
                        )
                    >
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">
                Modeltype
            </label>

            <input
                type="text"
                class="form-control"
                value="App\Models\User"
                disabled
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Wijzigingen opslaan
        </button>

        <a
            href="{{ route('admin.user-roles.index') }}"
            class="btn btn-secondary"
        >
            Annuleren
        </a>
    </form>

@endsection