<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <div class="text-center">
                <h2 class="text-3xl font-bold">Sign in to your account</h2>
                @if (session('error'))
                    <div class="mt-4 text-red-600">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="mt-8">
                <a href="{{ route('google.login') }}" 
                   class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Sign in with Google
                </a>
            </div>
        </div>
    </div>
</body>
</html> 