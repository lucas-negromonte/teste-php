<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'professor';


    /**
     * Buscar Todos os professores
     *
     * @return Collection|null
     */
    public function getAllTeachers(?int $id_card = null): ?Collection
    {
        $results = DB::table('teste_php.professor')
        ->selectRaw('professor.* , card_professor.id_card ')
        ->join('teste_php.card_professor', 'professor.id_professor', '=', 'card_professor.id_professor');

        if (!empty($id_card)) {
            $results = $results->where('card_professor.id_card', '=', $id_card);
        }

        $results = $results->get();


        return (!empty($results->count()) ? $results : null);
    }
}
