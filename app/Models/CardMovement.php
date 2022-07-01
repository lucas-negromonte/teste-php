<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardMovement extends Model
{
    use HasFactory;

    protected $table = 'card_movimentacao';

    public $timestamps = false;

    protected $primaryKey = 'id_card_movimentacao';

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_card',
        'id_status'
    ];
}
