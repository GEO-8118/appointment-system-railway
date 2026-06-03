<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $appointments = Appointment::with(['user', 'service', 'services', 'schedule'])->latest()->get();
            return view('admin.dashboard', compact('appointments'));
        }
        
        $appointments = Appointment::where('user_id', $user->id)->with(['service', 'services', 'schedule'])->latest()->get();
        return view('customer.dashboard', compact('appointments'));
    }

    public function create()
    {
        $services = Service::all();
        $schedules = Schedule::where('is_booked', false)->get();
        $schedulesByDate = $schedules->groupBy('available_date')->map(function ($group) {
            return $group->map(function ($item) {
                return [
                    'id' => $item->id,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                ];
            })->values();
        });

        $userAppointments = auth()->check()
            ? Appointment::where('user_id', auth()->id())->with(['services', 'service', 'schedule'])->latest()->get()
            : collect();

        return view('customer.book', compact('services', 'schedules', 'schedulesByDate', 'userAppointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id',
            'schedule_id' => 'nullable|exists:schedules,id',
            'schedule_date' => 'required_without:schedule_id|date',
            'schedule_start_time' => 'required_without:schedule_id|date_format:H:i',
            'schedule_end_time' => 'required_without:schedule_id|date_format:H:i|after:schedule_start_time',
            'notes' => 'nullable|string'
        ]);

        $serviceIds = $request->input('service_ids');

        $scheduleId = $request->input('schedule_id');
        if (! $scheduleId) {
            $schedule = Schedule::create([
                'available_date' => $request->input('schedule_date'),
                'start_time' => $request->input('schedule_start_time'),
                'end_time' => $request->input('schedule_end_time'),
                'is_booked' => true,
            ]);
            $scheduleId = $schedule->id;
        }

        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'service_id' => $serviceIds[0],
            'schedule_id' => $scheduleId,
            'status' => 'pending',
            'notes' => $request->notes
        ]);

        $appointment->services()->sync($serviceIds);
        if ($request->filled('schedule_id')) {
            Schedule::where('id', $request->schedule_id)->update(['is_booked' => true]);
        }

        return redirect('/dashboard')->with('success', 'Appointment registration submitted successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);
        $appointment->update(['status' => $request->status]);

        if ($request->status === 'rejected') {
            $appointment->schedule->update(['is_booked' => false]);
        }

        return redirect('/dashboard')->with('success', 'Appointment tracking baseline modified.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->schedule->update(['is_booked' => false]);
        $appointment->delete();
        return redirect('/dashboard')->with('success', 'Appointment clean structural purge complete.');
    }

    public function exportJson()
    {
        $data = Appointment::with(['user', 'service', 'schedule'])->get();
        return response()->json($data, 200, [
            'Content-Disposition' => 'attachment; filename="appointment_report.json"'
        ]);
    }

    public function importCsv(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt']);
        $file = fopen($request->file('csv_file')->getRealPath(), 'r');
        
        fgetcsv($file); // Skip headers row column indexes
        while (($row = fgetcsv($file)) !== FALSE) {
            Service::create([
                'name' => $row[0],
                'description' => $row[1] ?? '',
                'duration_minutes' => intval($row[2]),
                'price' => floatval($row[3])
            ]);
        }
        fclose($file);
        return back()->with('success', 'Bulk catalog values parsed and appended.');
    }
}