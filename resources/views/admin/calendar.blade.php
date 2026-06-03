<x-layout>
    <div class="space-y-6">
        <h2 class="text-2xl font-bold text-slate-900">Weekly Schedule</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
            @foreach(range(0, 6) as $i)
                @php $date = now()->addDays($i)->format('Y-m-d'); @endphp
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm min-h-[200px]">
                    <h3 class="font-bold text-xs text-slate-500 mb-4 uppercase text-center">
                        {{ now()->addDays($i)->format('D, M d') }}
                    </h3>
                    
                    <div class="space-y-2">
                        @forelse($appointments->get($date, []) as $appt)
                            <div class="p-2 bg-blue-50 border border-blue-100 rounded-lg">
                                <p class="text-[10px] font-bold text-blue-900 truncate">{{ $appt->user->name }}</p>
                                <p class="text-[9px] text-blue-600">{{ $appt->services->isNotEmpty() ? $appt->services->pluck('name')->join(', ') : $appt->service->name }}</p>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-[10px] text-slate-300 italic">No sessions</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>