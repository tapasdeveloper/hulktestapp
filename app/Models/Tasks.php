<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projects;

class Tasks extends Model
{
    use HasFactory;

    /**
     * Get all of the task's uploaded files.
     */
    public function uploads()
    {
        return $this->morphMany('App\Models\Fileuploads', 'fileuploadable');
    }

    /**
     * Get the project that owns the task.
     */
    public function project()
    {
        return $this->belongsTo(Projects::class);
    }


    /**
     * Get the comments for the task.
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comments', 'task_id', 'id');
    }
}
