<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;


class Material extends Model
{
    use HasFactory;
    protected $table = 'status';


    /**
     * Buscar Todos os materiais
     *
     * @return Collection|null
     */
    public function getAllMaterials(): ?Collection
    {
        $results = DB::table('teste_php.material')
            ->selectRaw('material.* , card_material.id_card ')
            ->join('teste_php.card_material', 'material.id_material', '=', 'card_material.id_material')
            ->get();

        return (!empty($results->count()) ? $results : null);
    }
}
