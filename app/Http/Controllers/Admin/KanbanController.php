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

    /**
     * Mostrar aplicação - cards Ajax
     *
     * @return void
     */
    public function getApp()
    {
        $data = $_POST;
        $order = ($data['order'] ?? null);
        $order_type = ($data['order_type'] ?? null);
        $num_aula = (int)($data['num_aula'] ?? null);
        $id_curso = (int)($data['id_curso'] ?? null);
        $teacher = ($data['professor'] ?? null);


        $statuses = (new Status)->getWithTheTotal();
        $cards = (new Kanban)->getAllCards($order, $order_type, $num_aula, $id_curso, $teacher);
        $html = Kanban::cards($cards, $statuses);
        $json['html']['#app'] =  $html;
        echo json_encode($json);
        return;
    }




    /**
     * View Cards
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

    /**
     * Faz a movimentação dos cards
     *
     */
    public function update()
    {
        $id = (!empty($_POST['id']) ? filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT) : null);
        $action = (!empty($_POST['action']) && in_array($_POST['action'], ['back', 'next']) ? $_POST['action'] : null);

        $obj = new Kanban;
        if (!$obj->movement($id, $action)) {
            $json['html']['.msg'] = '<div class="alert alert-danger" role="alert">' . $obj->message . '</div>';
            echo json_encode($json);
            return;
        }

        return $this->getApp();
    }
}
