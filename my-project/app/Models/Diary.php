<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    public function posts()
    {
        return $this->hasMany('\App\Models\Post');
    }

    public function usersWhiteList()
    {
        return $this->belongsToMany('\App\Models\User', "users_diarys");
    }

}
