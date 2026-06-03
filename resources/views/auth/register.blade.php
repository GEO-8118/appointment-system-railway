<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-slate-100">
        <h2 class="text-2xl font-bold text-slate-900 mb-6 text-center">Create Account</h2>
        
        <form action="/register" method="POST" class="space-y-4">
            @csrf
            <div>
                <input type="text" name="name" placeholder="Full Name" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div>
                <input type="email" name="email" placeholder="Email Address" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div>
                <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-xl font-semibold hover:bg-blue-700 transition">Register</button>
        </form>
        
        <p class="mt-6 text-center text-sm text-slate-500">
            Already have an account? <a href="/login" class="text-blue-600 font-semibold hover:underline">Login</a>
        </p>
    </div>
</body>
</html>