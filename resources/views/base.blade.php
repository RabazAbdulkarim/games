<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    >

    <title>@yield('title', 'Game Collection')</title>
</head>

<body>

    {{-- Navigatiemenu voor de beheeromgeving --}}
    @auth
        @role('admin')
            @if(request()->routeIs('admin.*'))
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <a class="navbar-brand" href="{{ url('/games') }}">
                        Game Collection
                    </a>

                    <span class="navbar-text text-light mr-4">
                        Beheer
                    </span>

                    <div class="navbar-nav">
                        <a
                            class="nav-item nav-link
                            {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}"
                            href="{{ route('admin.permissions.index') }}"
                        >
                            Permissies
                        </a>

                        <a
                            class="nav-item nav-link
                            {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                            href="{{ route('admin.roles.index') }}"
                        >
                            Rollen
                        </a>

                        <a
                            class="nav-item nav-link
                            {{ request()->routeIs('admin.role-permissions.*') ? 'active' : '' }}"
                            href="{{ route('admin.role-permissions.index') }}"
                        >
                            Rol-permissies
                        </a>

                        <a
                            class="nav-item nav-link
                            {{ request()->routeIs('admin.user-roles.*') ? 'active' : '' }}"
                            href="{{ route('admin.user-roles.index') }}"
                        >
                            Gebruiker-rollen
                        </a>
                    </div>
                </nav>
            @endif
        @endrole
    @endauth

    <div class="container" style="margin-top:40px; margin-bottom:40px;">

        {{-- Op gewone pagina's tonen we de grote titel uit @section('title') --}}
        @unless(request()->routeIs('admin.*'))
            <h1 class="display-4">
                @yield('title')
            </h1>
        @endunless

        @yield('content')

    </div>

</body>
</html>