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
    public function getAllCards(?string $order = null, ?string $order_type = null, ?int  $num_aula = null, ?int $id_curso = null, ?string $teacher = null,?int $id_card = null): ?Collection
    {
        $order = (!empty($order) && in_array($order, ['ano', 'curso', 'professor.nome', 'num_aula']) ? $order : 'card.id_card');
        $order_type = (!empty($order_type) && in_array($order_type, ['asc', 'desc']) ? $order_type : 'asc');

        $results =  DB::table('teste_php.card')
            ->selectRaw('card.* ,curso.curso,card_professor.id_professor, status.status,status.cor')
            ->leftJoin('teste_php.curso', 'card.id_curso', '=', 'curso.id_curso')
            ->leftJoin('teste_php.status', 'card.id_status', '=', 'status.id_status')
            ->leftJoin('teste_php.card_professor', 'card.id_card', '=', 'card_professor.id_card')
            ->leftJoin('teste_php.professor', 'card_professor.id_professor', '=', 'professor.id_professor');

        if (!empty($num_aula)) {
            $results = $results->where('card.num_aula', '=', $num_aula);
        }

        if (!empty($id_curso)) {
            $results = $results->where('card.id_curso', '=', $id_curso);
        }

        if (!empty($teacher)) {
            $results = $results->where('professor.nome', 'like', "%{$teacher}%");
        }

        if (!empty($id_card)) {
            $results = $results->where('card.id_card', '=', $id_card);
        }

        $results =  $results->groupBy('card.id_card')->orderBy($order, $order_type)->get();

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
