<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected $fillable = [
        'name',
        'email',
        'google_id',
        'avatar',
        'role_id',
    ];

    protected $casts = [
        'role' => UserRole::class
    ];

    // Relationships
    public function createdCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    // Helper methods
    public function isOrganizer(): bool
    {
        return $this->role_id === UserRole::ORGANIZER;
    }

    public function isStudent(): bool
    {
        return $this->role_id === UserRole::STUDENT;
    }
}
