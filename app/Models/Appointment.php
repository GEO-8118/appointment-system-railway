<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = ['user_id', 'service_id', 'schedule_id', 'status', 'notes'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function service(): BelongsTo { return $this->belongsTo(Service::class); }
    public function schedule(): BelongsTo { return $this->belongsTo(Schedule::class); }

    public function services(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'appointment_service');
    }
}