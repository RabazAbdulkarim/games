@extends('base')

@section('title', 'Permissies per rol')

@section('content')

    <h1 class="mb-4">Permissies per rol</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.role-permissions.create') }}"
       class="btn btn-success mb-3">
        Nieuwe koppeling
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>Rol</th>
                <th>Permissie</th>
                <th>Acties</th>
            </tr>
        </thead>

        <tbody>
            @foreach($links as $link)
                <tr>
                    <td>{{ $link->role_name }}</td>
                    <td>{{ $link->permission_name }}</td>

                    <td>
                        <a
                            href="{{ route('admin.role-permissions.edit', [
                                $link->role_id,
                                $link->permission_id
                            ]) }}"
                            class="btn btn-primary btn-sm"
                        >
                            Bewerken
                        </a>

                        <form
                            action="{{ route('admin.role-permissions.destroy', [
                                $link->role_id,
                                $link->permission_id
                            ]) }}"
                            method="POST"
                            style="display:inline;"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Koppeling verwijderen?')"
                            >
                                Ontkoppelen
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection