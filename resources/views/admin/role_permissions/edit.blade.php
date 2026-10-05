@extends('base')

@section('title', 'Koppeling bewerken')

@section('content')

    <h1 class="mb-4">Koppeling bewerken</h1>

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
        action="{{ route('admin.role-permissions.update', [
            $link->role_id,
            $link->permission_id
        ]) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

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
            <label for="permission_id" class="form-label">
                Permissie
            </label>

            <select
                id="permission_id"
                name="permission_id"
                class="form-control"
                required
            >
                @foreach($permissions as $permission)
                    <option
                        value="{{ $permission->id }}"
                        @selected(
                            old(
                                'permission_id',
                                $link->permission_id
                            ) == $permission->id
                        )
                    >
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Wijzigingen opslaan
        </button>

        <a
            href="{{ route('admin.role-permissions.index') }}"
            class="btn btn-secondary"
        >
            Annuleren
        </a>
    </form>

@endsection