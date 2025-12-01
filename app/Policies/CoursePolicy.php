<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy
{
    /**
     * Determine if the user can view the model.
     */
    public function view(?User $user, Course $course)
    {
        // Anyone can view published courses
        if ($course->status === 'published') {
            return true;
        }

        // Instructor can view their own courses
        if ($user && $user->id === $course->teacher_id) {
            return true;
        }

        // Admin can view any course
        if ($user && $user->hasRole('admin')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasRole('teacher');
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, Course $course)
    {
        return $user->id === $course->teacher_id && $course->status !== 'published';
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, Course $course)
    {
        return $user->id === $course->teacher_id && $course->status !== 'published';
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, Course $course)
    {
        return false;
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, Course $course)
    {
        return false;
    }

    /**
     * Determine if the user can approve the course.
     */
    public function approve(User $user, Course $course)
    {
        return $user->hasRole('admin') && $course->status === 'under_review';
    }

    /**
     * Determine if the user can reject the course.
     */
    public function reject(User $user, Course $course)
    {
        return $user->hasRole('admin') && $course->status === 'under_review';
    }
}
