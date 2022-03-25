<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = "statuses";

    public function users()
    {
        return $this->belongsToMany('\App\Models\User', "user_statuses");
    }

}
