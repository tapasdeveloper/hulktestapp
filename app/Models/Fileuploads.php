<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fileuploads extends Model
{
    use HasFactory;

    /**
     * Get all of the models that own uploads.
     */
    public function uploadable()
    {
        return $this->morphTo();
    }
}
