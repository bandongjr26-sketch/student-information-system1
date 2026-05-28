<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="d-flex flex-column min-vh-100">

  
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">My Website</a>

            <ul class="navbar-nav">
                @if(session('user'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('students.index') }}">Student List</a>
                    </li>

                    @if(session('logged_role') === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('degrees.index') }}">Degrees</a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="/aboutUs">About Us</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="nav-link" style="background:none; border:0; color:#fff;">Logout</button>
                        </form>
                    </li>
                @endif


            </ul>
        </div>
    </nav>

    
    <main class="flex-fill container mt-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center text-white mt-auto" style="background-color: #363b42; padding: 15px 0;">
        <h5>Copyright &copy; 2026 My Website</h5>
    </footer>

    @stack('scripts')
</body>
</html>
