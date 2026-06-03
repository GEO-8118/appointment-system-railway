<x-layout>
    <x-slot:nav>
        <a href="/dashboard" class="text-slate-900 font-semibold px-3 py-2 rounded-lg bg-slate-100">Dashboard</a>
        <a href="/appointments/book" class="text-slate-500 hover:text-slate-900 px-3 py-2 rounded-lg transition">Book Session</a>
    </x-slot:nav>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h1 class="text-2xl font-bold text-slate-900">Portal Dashboard</h1>
            <p class="text-slate-500 mt-2">Welcome back! Manage your sessions and appointments below.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-slate-900">Upcoming Appointments</h3>
                <p class="text-sm text-slate-500 mt-2">You have no pending sessions at the moment.</p>
            </div>
            <div class="bg-blue-600 p-6 rounded-2xl shadow-lg border border-blue-700">
                <h3 class="font-bold text-white">Need help?</h3>
                <p class="text-sm text-blue-100 mt-2">Contact the administrator for support.</p>
            </div>
        </div>
    </div>
</x-layout>