<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    /**
     * Get all of the comment's uploaded files.
     */
    public function uploads()
    {
        return $this->morphMany('App\Models\Fileuploads', 'fileuploadable');
    }

    /**
     * Get the Comment that owns the task.
     */
    public function task()
    {
        return $this->belongsTo('App\Models\Tasks', 'task_id', 'id');
    }

    public function children(){
        return $this->hasMany( 'App\Models\Comments', 'parent_comment_id', 'id' );
      }

      public function parent(){
        return $this->hasOne( 'App\Models\Comments', 'id', 'parent_comment_id' );
      }
}
