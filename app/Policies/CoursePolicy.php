<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use App\Models\UserRole;

class CoursePolicy
{
    public function update(User $user, Course $course)
    {
        return $user->isOrganizer() && $user->id === $course->created_by;
    }

    public function delete(User $user, Course $course)
    {
        return $user->isOrganizer() && $user->id === $course->created_by;
    }
} 