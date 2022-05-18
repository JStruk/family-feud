<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function games(){
        return $this->belongsToMany(Game::class, 'game_questions');
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }
}
