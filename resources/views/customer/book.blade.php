<x-layout>
    <div class="max-w-2xl mx-auto bg-[#1a1a1e] rounded-2xl shadow-xl border border-slate-800/80 p-6 sm:p-8 mt-4">
        <div class="mb-6 border-b border-slate-800 pb-4">
            <h1 class="text-2xl font-bold text-white tracking-tight">Request an Appointment</h1>
            <p class="text-slate-400 text-sm mt-1">Select your service parameters and an available timing window below.</p>
        </div>

        <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
            @csrf
            @if ($errors->any())
                <div class="rounded-2xl border border-rose-500/30 bg-rose-950/30 p-4 text-sm text-rose-100">
                    <div class="font-semibold mb-2">Please fix the following issues:</div>
                    <ul class="list-disc list-inside space-y-1 text-rose-100">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Select Target Service(s)</label>
                <select name="service_ids[]" multiple required size="5" class="w-full border border-slate-800 rounded-xl px-4 py-3 bg-[#121214] text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm transition-all">
                    @foreach($services as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} — (${{ number_format($s->price, 2) }})</option>
                    @endforeach
                </select>
                <p class="mt-2 text-xs text-slate-500">Hold Ctrl (Windows) or Command (Mac) to select multiple services.</p>
            </div>

            <div x-data='{
                    schedules: @json($schedulesByDate),
                    selectedDate: "{{ old('schedule_date', now()->format('Y-m-d')) }}",
                    selectedScheduleId: "",
                    customStartTime: "{{ old('schedule_start_time', '') }}",
                    customEndTime: "{{ old('schedule_end_time', '') }}",
                    get dates() {
                        return Object.keys(this.schedules).sort();
                    },
                    get selectedSlots() {
                        return this.schedules[this.selectedDate] || [];
                    },
                    get canSubmit() {
                        return this.selectedScheduleId || (this.selectedDate && this.customStartTime && this.customEndTime);
                    },
                    init() {
                        if (this.dates.length && !this.dates.includes(this.selectedDate)) {
                            this.selectedDate = this.dates[0];
                        }

                        this.updateSelection();
                    },
                    updateSelection() {
                        if (this.selectedSlots.length) {
                            this.selectedScheduleId = this.selectedSlots[0].id;
                        } else {
                            this.selectedScheduleId = "";
                        }
                    }
                }' x-init="init()" x-effect="updateSelection()" class="space-y-4">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Select Available Schedule Window</label>
                <div class="grid gap-4">
                    <div>
                        <input
                            type="date"
                            name="schedule_date"
                            x-model="selectedDate"
                            @change="updateSelection()"
                            class="w-full border border-slate-800 rounded-xl px-4 py-3 bg-[#121214] text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm transition-all"
                        />
                    </div>

                    <div class="rounded-2xl border border-slate-800 bg-[#121214] p-4">
                        <div class="mb-3 text-slate-300 text-sm">
                            <span class="mr-2">⏰</span>
                            Available time slots for <span class="font-semibold text-white" x-text="selectedDate"></span>
                        </div>
                        <template x-if="selectedSlots.length">
                            <div class="grid gap-3">
                                <template x-for="slot in selectedSlots" :key="slot.id">
                                    <button
                                        type="button"
                                        @click="selectedScheduleId = slot.id"
                                        :class="selectedScheduleId === slot.id ? 'bg-blue-600 text-white' : 'bg-slate-800 text-slate-200 hover:bg-slate-700'"
                                        class="w-full text-left rounded-xl px-4 py-3 transition-colors"
                                    >
                                        <span class="inline-flex items-center gap-2">
                                            <span>🕒</span>
                                            <span x-text="slot.start_time + ' - ' + slot.end_time"></span>
                                        </span>
                                    </button>
                                </template>
                            </div>
                        </template>
                        <template x-if="!selectedSlots.length">
                            <div class="rounded-xl border border-slate-700 bg-slate-900/50 p-4 text-slate-400">
                                No available slots for this date.
                            </div>
                        </template>
                    </div>

                    <div class="rounded-2xl border border-slate-800 bg-[#121214] p-4">
                        <div class="mb-3 text-slate-300 text-sm">
                            <span class="mr-2">🛠️</span>
                            Or create a custom time slot for <span class="font-semibold text-white" x-text="selectedDate"></span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Start Time</label>
                                <input type="time" name="schedule_start_time" x-model="customStartTime" class="w-full border border-slate-800 rounded-xl px-4 py-3 bg-[#121214] text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm transition-all" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">End Time</label>
                                <input type="time" name="schedule_end_time" x-model="customEndTime" class="w-full border border-slate-800 rounded-xl px-4 py-3 bg-[#121214] text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm transition-all" />
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-3">If you select an available slot above, those custom times will be ignored.</p>
                    </div>
                </div>

                <input type="hidden" name="schedule_id" x-bind:value="selectedScheduleId" />
            </div>

            @if(isset($userAppointments) && $userAppointments->isNotEmpty())
                <div class="rounded-2xl border border-slate-800 bg-[#121214] p-4">
                    <h2 class="text-sm font-semibold text-white mb-3">Your existing appointments</h2>
                    <div class="space-y-3 text-slate-300 text-sm">
                        @foreach($userAppointments as $appt)
                            <div class="rounded-xl border border-slate-700 bg-slate-900/60 p-3">
                                <div class="font-semibold text-white">{{ $appt->services->isNotEmpty() ? $appt->services->pluck('name')->join(', ') : $appt->service->name }}</div>
                                <div class="text-slate-400 text-xs">{{ $appt->schedule->available_date }} @ {{ $appt->schedule->start_time }} - {{ $appt->schedule->end_time }}</div>
                                <div class="text-slate-400 text-xs">Status: {{ ucfirst($appt->status) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Additional Notes (Optional)</label>
                <textarea name="notes" rows="4" placeholder="Provide any additional details..." class="w-full border border-slate-800 rounded-xl px-4 py-3 bg-[#121214] text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm transition-all"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-800">
                <a href="/dashboard" class="px-4 py-2.5 text-sm font-medium text-slate-400 hover:text-white bg-slate-800/40 hover:bg-slate-800 rounded-xl transition-colors">
                    Cancel
                </a>
                <button type="submit" :disabled="!canSubmit" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition-all disabled:cursor-not-allowed disabled:bg-slate-600 disabled:text-slate-300">
                    Submit Booking Request
                </button>
            </div>
        </form>
    </div>
</x-layout>