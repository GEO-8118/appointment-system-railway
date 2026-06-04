<x-layout>
    <x-slot:nav>
        <x-nav-link href="/dashboard" active="true">Admin Dashboard Control</x-nav-link>
    </x-slot:nav>

    <div class="md:flex md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Admin Controls</h1>
            <p class="text-slate-500 mt-1">
                Review user appointments and manage system catalog metadata configurations.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm mb-8">
        <h2 class="text-xl font-bold mb-4">Add New Service</h2>

        <form action="{{ route('services.add') }}" method="POST">
            @csrf

            <div class="grid gap-4">

                <input
                    type="text"
                    name="name"
                    placeholder="Service Name"
                    required
                    class="border border-slate-300 rounded-lg px-4 py-2 w-full">

                <textarea
                    name="description"
                    placeholder="Description"
                    required
                    class="border border-slate-300 rounded-lg px-4 py-2 w-full"></textarea>

                <input
                    type="number"
                    name="duration_minutes"
                    placeholder="Duration (Minutes)"
                    required
                    class="border border-slate-300 rounded-lg px-4 py-2 w-full">

                <input
                    type="number"
                    step="0.01"
                    name="price"
                    placeholder="Price"
                    required
                    class="border border-slate-300 rounded-lg px-4 py-2 w-full">

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg">
                    Add Service
                </button>

            </div>
        </form>
    </div>

    <div class="bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-bold text-slate-500">
                    <th class="p-4">Customer Info</th>
                    <th class="p-4">Requested Service</th>
                    <th class="p-4">Scheduled Window</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Administrative Actions</th>
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
                                        Approve
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
                                        Reject
                                    </button>
                                </form>

                            @endif

                            <form action="{{ route('appointments.destroy', $app->id) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')

                                <button class="text-rose-600 text-xs font-bold px-2 py-1.5">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">
                            No system records available.
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>