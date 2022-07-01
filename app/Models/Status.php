<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class Status extends Model
{
    use HasFactory;
    protected $table = 'status';

    /**
     * Buscar status com o total de cards
     *
     * @return Collection|null
     */
    public function getWithTheTotal(): ?Collection
    {
        $results = DB::table('teste_php.status')->selectRaw('status.*')->groupByRaw('status.id_status')->get();
        return (!empty($results->count()) ? $results : null);
    }
}
