@extends('base')

@section('title', 'Permissies beheren')

@section('content')

    <h1 class="mb-4">Permissies</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.permissions.create') }}"
       class="btn btn-success mb-3">
        Nieuwe permissie
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Guard</th>
                <th>Acties</th>
            </tr>
        </thead>

        <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->guard_name }}</td>

                    <td>
                        <a href="{{ route('admin.permissions.edit', $permission) }}"
                           class="btn btn-primary btn-sm">
                            Bewerken
                        </a>

                        <form
                            action="{{ route('admin.permissions.destroy', $permission) }}"
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