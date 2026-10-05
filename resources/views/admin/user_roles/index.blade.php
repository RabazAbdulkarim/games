@extends('base')

@section('title', 'Rollen per gebruiker')

@section('content')

    <h1 class="mb-4">Rollen per gebruiker</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.user-roles.create') }}"
       class="btn btn-success mb-3">
        Nieuwe koppeling
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>Gebruiker</th>
                <th>E-mail</th>
                <th>Rol</th>
                <th>Acties</th>
            </tr>
        </thead>

        <tbody>
            @foreach($links as $link)
                <tr>
                    <td>{{ $link->user_name }}</td>
                    <td>{{ $link->user_email }}</td>
                    <td>{{ $link->role_name }}</td>

                    <td>
                        <a
                            href="{{ route('admin.user-roles.edit', [
                                $link->role_id,
                                $link->model_id
                            ]) }}"
                            class="btn btn-primary btn-sm"
                        >
                            Bewerken
                        </a>

                        <form
                            action="{{ route('admin.user-roles.destroy', [
                                $link->role_id,
                                $link->model_id
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