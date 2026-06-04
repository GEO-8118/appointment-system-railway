<x-layout>
    <x-slot:nav>
        <x-nav-link href="/dashboard" active="true">
            Librarian Dashboard
        </x-nav-link>
    </x-slot:nav>

```
<div class="md:flex md:items-center md:justify-between mb-8 space-y-4 md:space-y-0">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900">
            Library Management System
        </h1>

        <p class="text-slate-500 mt-1">
            Manage books, borrowing records, and student transactions.
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <a href="{{ route('reports.exportJson') }}"
           class="inline-flex items-center bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 font-medium px-4 py-2 rounded-xl text-sm shadow-sm transition">
            📥 Export Borrow Records
        </a>

        <form action="{{ route('services.importCsv') }}"
              method="POST"
              enctype="multipart/form-data"
              class="flex items-center bg-white border border-slate-300 p-1.5 rounded-xl shadow-sm">

            @csrf

            <input type="file"
                   name="csv_file"
                   required
                   class="text-xs text-slate-500 file:mr-3 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 cursor-pointer w-44">

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-2.5 py-1 rounded-lg transition">
                Import Books
            </button>
        </form>
    </div>
</div>

<div class="bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-bold text-slate-500">
                <th class="p-4">Student Information</th>
                <th class="p-4">Borrowed Book</th>
                <th class="p-4">Borrow Date</th>
                <th class="p-4">Borrow Status</th>
                <th class="p-4 text-right">Library Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-100 text-sm">
            @forelse($appointments as $app)

                <tr class="hover:bg-slate-50 transition">

                    <td class="p-4 font-semibold text-slate-900">
                        {{ $app->user->name }}

                        <span class="block text-xs text-slate-400 font-normal">
                            {{ $app->user->email }}
                        </span>
                    </td>

                    <td class="p-4 text-slate-700">
                        {{ $app->services->isNotEmpty()
                            ? $app->services->pluck('name')->join(', ')
                            : $app->service->name }}
                    </td>

                    <td class="p-4 text-slate-600 font-medium">
                        {{ $app->schedule->available_date }}

                        <span class="block text-xs text-slate-400 font-normal">
                            {{ $app->schedule->start_time }}
                            -
                            {{ $app->schedule->end_time }}
                        </span>
                    </td>

                    <td class="p-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                            {{ $app->status === 'approved'
                                ? 'bg-emerald-50 text-emerald-700'
                                : ($app->status === 'rejected'
                                    ? 'bg-rose-50 text-rose-700'
                                    : 'bg-amber-50 text-amber-700') }}">

                            {{ ucfirst($app->status) }}
                        </span>
                    </td>

                    <td class="p-4 text-right space-x-2 whitespace-nowrap">

                        @if($app->status === 'pending')

                            <form action="{{ route('appointments.status', $app->id) }}"
                                  method="POST"
                                  class="inline">

                                @csrf
                                @method('PATCH')

                                <input type="hidden"
                                       name="status"
                                       value="approved">

                                <button class="bg-emerald-600 text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg">
                                    Approve Borrow
                                </button>
                            </form>

                            <form action="{{ route('appointments.status', $app->id) }}"
                                  method="POST"
                                  class="inline">

                                @csrf
                                @method('PATCH')

                                <input type="hidden"
                                       name="status"
                                       value="rejected">

                                <button class="bg-slate-600 text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg">
                                    Return Book
                                </button>
                            </form>

                        @endif

                        <form action="{{ route('appointments.destroy', $app->id) }}"
                              method="POST"
                              class="inline">

                            @csrf
                            @method('DELETE')

                            <button class="text-rose-600 text-xs font-bold px-2 py-1.5">
                                Delete Record
                            </button>
                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-400">
                        No borrowing records available.
                    </td>
                </tr>

            @endforelse
        </tbody>
    </table>
</div>
```

</x-layout>
