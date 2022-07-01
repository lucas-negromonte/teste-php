<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CardMovement;
use App\Models\Course;
use App\Models\Status;
use App\Support\Kanban;
use Illuminate\Http\Request;

class KanbanController extends Controller
{


    public function getApp($data = null)
    {
        $statuses = (new Status)->getWithTheTotal();
        $cards = (new Kanban)->getAllCards();
        $html = Kanban::cards($cards, $statuses);
        $json['html']['#app'] =  $html;
        echo json_encode($json);
        return;
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = (new Status)->getWithTheTotal();
        return view(
            'admin.kanban.index',
            [
                // 'cards' => $cards,
                'statuses' => $statuses,
                'courses' => Course::get(),
                'num_classes' =>  Card::select('num_aula')->groupBy('num_aula')->orderBy('num_aula')->get(),
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

    /**
     * Update the specified resource in storage.
     *
     */
    public function update()
    {
        $id = (!empty($_POST['id']) ? filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT) : null);
        $action = (!empty($_POST['action']) && in_array($_POST['action'], ['back', 'next']) ? $_POST['action'] : null);
        if (empty($id) || empty($action)) {
            $json['html']['.msg'] = '<div class="alert alert-warning" role="alert">Faltam dados</div>';
            echo json_encode($json);
            return;
        }

        $card = Card::where('id_card', '=', $id)->first();
        if (empty($card)) {
            $json['html']['.msg'] = '<div class="alert alert-warning" role="alert">Card não encontrado</div>';
            echo json_encode($json);
            return;
        }

        $new_status = Status::where('id_status', ($action == 'back' ? '<' : '>'), $card->id_status)->first();
        if (empty($new_status)) {
            $json['html']['.msg'] = '<div class="alert alert-warning" role="alert">Status não encontrado</div>';
            echo json_encode($json);
            return;
        }

        $card->id_status = $new_status->id_status;
        $card->save();

        (new CardMovement())->create([
            'id_card' => $card->id_card,
            'id_status' => $card->id_status,
        ]);
        
        return $this->getApp();
    }

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
