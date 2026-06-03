<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentApiController extends Controller
{
    public function index()
    {
        return response()->json(Appointment::with(['user', 'service', 'services', 'schedule'])->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id',
            'schedule_id' => 'required|exists:schedules,id'
        ]);

        $serviceIds = $request->input('service_ids');

        $appointment = Appointment::create([
            'user_id' => $request->user_id,
            'service_id' => $serviceIds[0],
            'schedule_id' => $request->schedule_id,
            'status' => 'pending',
            'notes' => $request->input('notes')
        ]);

        $appointment->services()->sync($serviceIds);
        return response()->json(['status' => 'Created via REST Engine', 'data' => $appointment], 201);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) return response()->json(['error' => 'Data missing'], 404);

        $appointment->update($request->all());
        return response()->json(['status' => 'Modified via REST Engine', 'data' => $appointment], 200);
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) return response()->json(['error' => 'Data missing'], 404);

        $appointment->delete();
        return response()->json(['status' => 'Purged via REST Engine'], 200);
    }
}