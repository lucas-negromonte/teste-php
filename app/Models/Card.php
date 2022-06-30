<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $table = 'card';



    public function course()
    {
        return $this->hasOne(Course::class, 'id_curso','id_curso');
    }

    public function searchAllCards()
    {
        # code...
    }
}
