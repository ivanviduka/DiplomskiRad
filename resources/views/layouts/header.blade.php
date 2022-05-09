<!DOCTYPE html>
<html lang="en">
<head>
    @yield('title')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    @yield('description')
</head>

<body>

<header class="p-3 bg-dark text-white mb-5">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            @auth
                <h2 class="me-4">
                    <a href="{{ route('homepage') }}" style="font-size: 25px"
                       class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                        FERIT Share
                    </a>
                </h2>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li>
                        <a class="nav-link px-2 text-white" href="{{ route('user.files') }}">My files</a>
                    </li>
                    <li>
                        <a class="nav-link px-2 text-white" href="{{ route('search') }}">Search</a>
                    </li>
                    <li>
                        <a class="nav-link px-2 text-white" href="{{ route('create-file.form') }}">Add new file</a>
                    </li>
                    @if(auth()->user()->is_admin)

                        <li>
                            <a class="nav-link px-2 text-white" href="{{ route('admin') }}">Admin</a>
                        </li>

                        <li>
                            <a class="nav-link px-2 text-white" href="{{ route('statistics') }}">Statistics</a>
                        </li>
                    @endif

                    <li>
                        <a class="nav-link px-2 text-white" href="{{ route('signout') }}">Logout</a>
                    </li>
                </ul>
            @endauth

            @guest
                    <div class="text-end">
                        <a href="{{route('login')}}" style="font-size: 20px">
                            <button type="button" class="btn btn-outline-light me-2">Login</button>
                        </a>

                        <a href="{{route('register')}}" style="font-size: 20px">
                            <button type="button" class="btn btn-warning">Register</button>
                        </a>
                    </div>

            @endguest
        </div>
    </div>
</header>
@yield('content')

</body>

</html>

