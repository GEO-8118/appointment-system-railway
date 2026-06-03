<x-layout>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">My Appointments</h1>
            <p class="text-slate-400 mt-1">Track and manage your requested schedule slots.</p>
        </div>
        <a href="/appointments/book" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2.5 rounded-xl text-sm shadow-md transition-all">
            + Book Appointment
        </a>
    </div>

    <div class="bg-[#1a1a1e] border border-slate-800/80 rounded-2xl overflow-hidden shadow-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-800/30 border-b border-slate-800/80 text-xs uppercase font-bold text-slate-400 tracking-wider">
                    <th class="p-4">Service Class</th>
                    <th class="p-4">Target Date</th>
                    <th class="p-4">Time Window</th>
                    <th class="p-4">Workflow Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60 text-sm text-slate-300">
                @forelse($appointments as $item)
                    <tr class="hover:bg-slate-800/20 transition-colors">
                        <td class="p-4 font-semibold text-white">{{ $item->services->isNotEmpty() ? $item->services->pluck('name')->join(', ') : $item->service->name }}</td>
                        <td class="p-4 text-slate-300">{{ $item->schedule->available_date }}</td>
                        <td class="p-4 text-slate-400">{{ $item->schedule->start_time }} - {{ $item->schedule->end_time }}</td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->status === 'approved' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : ($item->status === 'rejected' ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-slate-500 font-medium">
                            <div class="text-3xl mb-2">📅</div>
                            No appointments scheduled yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>