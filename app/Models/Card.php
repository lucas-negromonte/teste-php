<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class Card extends Model
{
    use HasFactory;

    protected $table = 'card';

    public $timestamps = false;

    protected $primaryKey = 'id_card';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_status'
    ];

    /**
     * Buscar Todos os cards da View
     *
     * @return Collection|null
     */
    public function getAllCards(): ?Collection
    {
        $results =  DB::table('teste_php.card')
            ->selectRaw('card.* ,curso.curso')
            ->leftJoin('teste_php.curso', 'card.id_curso', '=', 'curso.id_curso')
            ->leftJoin('teste_php.card_professor', 'card.id_card', '=', 'card_professor.id_card')
            ->leftJoin('teste_php.professor', 'card_professor.id_professor', '=', 'professor.id_professor')
            ->groupBy('card.id_card')
            ->get();

        return (!empty($results->count()) ? $results : null);
    }


    /**
     * Buscar Total de cards
     *
     * @return Collection|null
     */
    public function getNumClasses(): ?Collection
    {
        $results =  DB::table('teste_php.card')
            ->selectRaw('count(card.num_aula) as total ')
            ->groupBy('card.num_aula')
            ->orderByRaw('count(card.num_aula)')
            ->get();

        return (!empty($results->count()) ? $results : null);
    }
}
