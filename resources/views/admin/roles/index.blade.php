@extends('base')

@section('title', 'Rollen beheren')

@section('content')

    <h1 class="mb-4">Rollen beheren</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.roles.create') }}"
       class="btn btn-success mb-3">
        Nieuwe rol
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Rol</th>
                <th>Guard</th>
                <th>Acties</th>
            </tr>
        </thead>

        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->guard_name }}</td>

                    <td>
                        <a href="{{ route('admin.roles.edit', $role) }}"
                           class="btn btn-primary btn-sm">
                            Bewerken
                        </a>

                        <form
                            action="{{ route('admin.roles.destroy', $role) }}"
                            method="POST"
                            style="display:inline;"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Weet je het zeker?')"
                            >
                                Verwijderen
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection