<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\Enums\AttendanceStatus;

class Attendance extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'lesson_id',
        'user_id',
        'entry_time',
        'exit_time',
        'total_duration',
        'status'
    ];

    protected $casts = [
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
        'status' => AttendanceStatus::class
    ];

    // Relationships
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 