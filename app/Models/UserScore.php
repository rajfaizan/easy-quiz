<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserScore extends Model
{
    protected $table = 'useer_scores';
    protected $guarded = [];


    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function quiz() {
        return $this->belongsTo(Quiz::class);
    }
}

