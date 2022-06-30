<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Course;
use App\Models\Status;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KanbanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $statuses = DB::table('teste_php.status')
            ->selectRaw('status.* , COUNT(DISTINCT card.id_card) AS total_cards ')
            ->leftJoin('teste_php.card', 'card.id_status', '=', 'status.id_status')
            ->groupByRaw('status.id_status')
            ->get();

        $cards = DB::table('teste_php.card')
            ->selectRaw('card.* ,curso.curso')
            ->leftJoin('teste_php.curso', 'card.id_curso', '=', 'curso.id_curso')
            ->leftJoin('teste_php.card_professor', 'card.id_card', '=', 'card_professor.id_card')
            ->leftJoin('teste_php.professor', 'card_professor.id_professor', '=', 'professor.id_professor')
            ->groupBy('card.id_card')
            ->get();

        $teachers = DB::table('teste_php.professor')
            ->selectRaw('professor.* , card_professor.id_card ')
            ->join('teste_php.card_professor', 'professor.id_professor', '=', 'card_professor.id_professor')
            ->get();

        $materials =  DB::table('teste_php.material')
            ->selectRaw('material.* , card_material.id_card ')
            ->join('teste_php.card_material', 'material.id_material', '=', 'card_material.id_material')
            ->get();

        if ($cards) {
            foreach ($cards as $card) {
                $card->professores = [];
                $card->materiais = [];

                // adicionar professores ao objeto card
                if (!empty($teachers)) {
                    foreach ($teachers as $teacher) {
                        if (stristr($teacher->nome, ' ')) {
                            $teacher->nome =  explode(' ',  $teacher->nome);
                            $teacher->nome =  array_shift($teacher->nome) . ' ' . array_pop($teacher->nome);
                        }

                        $card->professores[] =  $teacher;
                    }
                }

                // adicionar materials ao objeto card
                if (!empty($materials)) {
                    foreach ($materials as $material) {
                        $card->materiais[] =  $material;
                    }
                }
            }
        }

        $num_classes = Course::get();

        $num_classes =  DB::table('teste_php.card')
            ->selectRaw('count(card.num_aula) as total ')
            ->groupBy('card.num_aula')
            ->orderByRaw('count(card.num_aula)')
            ->get();

      

        return view(
            'admin.kanban.index',
            [
                'cards' => $cards,
                'statuses' => $statuses,
                'courses' => Course::get(),
                'num_classes' => $num_classes,
            ]
        );
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
