<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReserveIt Authentication Gateway</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full border border-slate-200">
        <h2 class="text-3xl font-bold text-center text-slate-900 mb-2 tracking-tight">Welcome Back</h2>
        <p class="text-slate-500 text-center mb-8 text-sm">Sign in to manage active appointment tasks.</p>
        
        <form action="/login" method="POST" class="space-y-5">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-slate-800 bg-slate-50 transition" placeholder="you@booking.com">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-slate-800 bg-slate-50 transition" placeholder="••••••••">
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg transition">
                Sign In
            </button>
        </form>

        <p class="mt-8 text-center text-sm text-slate-500">
            Don't have an account? 
            <a href="/register" class="text-blue-600 font-semibold hover:underline">Sign up here</a>
        </p>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\appointment-system\resources\views/auth/login.blade.php ENDPATH**/ ?>