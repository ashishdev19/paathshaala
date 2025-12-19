<?php

namespace App\Policies;

use App\Models\OnlineClass;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OnlineClassPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'teacher', 'instructor', 'student']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OnlineClass $onlineClass): bool
    {
        // Admins can view all classes
        if ($user->hasRole('admin')) {
            return true;
        }

        // Teachers/Instructors can view classes for their courses
        if ($user->hasRole(['teacher', 'instructor'])) {
            return $onlineClass->course->teacher_id === $user->id;
        }

        // Students can view classes for courses they're enrolled in
        if ($user->hasRole('student')) {
            return $onlineClass->course->enrollments()
                ->where('student_id', $user->id)
                ->where('status', 'active')
                ->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'teacher', 'instructor']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OnlineClass $onlineClass): bool
    {
        // Admins can update all classes
        if ($user->hasRole('admin')) {
            return true;
        }

        // Teachers/Instructors can only update classes for their courses
        if ($user->hasRole(['teacher', 'instructor'])) {
            return $onlineClass->course->teacher_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OnlineClass $onlineClass): bool
    {
        // Admins can delete all classes
        if ($user->hasRole('admin')) {
            return true;
        }

        // Teachers/Instructors can only delete classes for their courses
        if ($user->hasRole(['teacher', 'instructor'])) {
            return $onlineClass->course->teacher_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OnlineClass $onlineClass): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OnlineClass $onlineClass): bool
    {
        return false;
    }
}
