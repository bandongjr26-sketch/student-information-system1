<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .glass { backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.25); }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    <div class="glass rounded-2xl shadow-2xl p-8 w-full max-w-md border border-white/20">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Welcome Back</h1>
            <p class="text-white/80">Sign in to your student account</p>
        </div>

@if ($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 text-red-200 p-4 rounded-xl mb-6 text-center">
                <ul class="list-none mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-white/90 font-medium mb-2">Username</label>
                <input type="text" name="username" required 
                       class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent transition-all duration-300" 
                       placeholder="Enter your username">
            </div>
            <div>
                <label class="block text-white/90 font-medium mb-2">Password</label>
                <input type="password" name="password" required 
                       class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent transition-all duration-300" 
                       placeholder="Enter your password">
            </div>
            <button type="submit" 
                    class="w-full bg-white/90 hover:bg-white text-gray-800 font-semibold py-3 px-4 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-0.5 transition-all duration-300 text-lg">
                Sign In
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-white/60">Student and teacher accounts are created by the admin.</p>
        </div>
    </div>
</body>
</html>
