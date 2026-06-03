<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function calendar(): View
    {
        $appointments = Appointment::with(['user', 'service', 'schedule'])
            ->whereHas('schedule', function($query) {
                // Using the correct column: available_date
                $query->where('available_date', '>=', now()->format('Y-m-d'))
                      ->where('available_date', '<=', now()->addDays(6)->format('Y-m-d'));
            })
            ->get()
            ->groupBy(function($appt) {
                // Also using the correct column: available_date
                return Carbon::parse($appt->schedule->available_date)->format('Y-m-d');
            });

        return view('admin.calendar', compact('appointments'));
    }
}