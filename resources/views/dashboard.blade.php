<x-layout>
    <x-slot:nav>
        <a href="/dashboard" class="text-slate-900 font-semibold px-3 py-2 rounded-lg bg-slate-100">Dashboard</a>
        <a href="/appointments/book" class="text-slate-500 hover:text-slate-900 px-3 py-2 rounded-lg transition">Borrow Book</a>
    </x-slot:nav>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h1 class="text-2xl font-bold text-slate-900">Student Library Dashboard</h1>
            <p class="text-slate-500 mt-2">
                View your borrowed books and borrowing history.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-slate-900">My Borrowed Books</h3>
                <p class="text-sm text-slate-500 mt-2">
                    View all books currently borrowed from the library.
                </p>
            </div>

            <div class="bg-blue-600 p-6 rounded-2xl shadow-lg border border-blue-700">
                <h3 class="font-bold text-white">Library Information</h3>
                <p class="text-sm text-blue-100 mt-2">
                    Contact the librarian for book availability and assistance.
                </p>
            </div>
        </div>
    </div>
</x-layout>