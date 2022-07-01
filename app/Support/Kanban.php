<?php

namespace App\Support;

use App\Models\Card;
use App\Models\CardMovement;
use App\Models\Material;
use App\Models\Status;
use App\Models\Teacher;
use Illuminate\Support\Collection;


class Kanban
{

    public $message;

    /**
     * Buscar todos os cards e outros objetos vinculados
     *
     * @return Collection|null
     */
    public function getAllCards(?string $order = null, ?string $order_type = null, ?int  $num_aula = null, ?int $id_curso = null, ?string  $teacher = null): ?Collection
    {
        $cards = (new Card())->getAllCards($order, $order_type, $num_aula, $id_curso, $teacher);
        if ($cards) {
            $teachers = (new Teacher())->getAllTeachers();
            $materials = (new Material())->getAllMaterials();

            foreach ($cards as $card) {
                $card->professores = [];
                $card->materiais = [];

                // $card->professores[] = $this->addInCards($card, $teachers, 'id_card');
                // $card->materiais[] = $this->addInCards($card, $materials, 'id_card');

                // adicionar professores ao objeto card
                if (!empty($teachers)) {
                    foreach ($teachers as $teacher) {
                        if ($teacher->id_card == $card->id_card) {
                            $teacher->nome = $this->shortName($teacher->nome);
                            $card->professores[] =  $teacher;
                        }
                    }
                }


                // adicionar materials ao objeto card
                if (!empty($materials)) {
                    foreach ($materials as $material) {
                        if ($material->id_card == $card->id_card) {
                            $card->materiais[] =  $material;
                        }
                    }
                }
            }
        }
        return $cards;
    }

    // public function addInCards(?object $data, ?Collection $data_add, string $key): array
    // {
    //     $values = [];
    //     if (!empty($data_add)) {
    //         foreach ($data_add as $data_item) {
    //             if (isset($data->$key) && isset($data_item->$key) && $data->$key == $data_item->$key) {
    //                 $values[] =  $data_item;
    //             }
    //         }
    //     }
    //     return $values;
    // }

    /**
     * Retorna primeiro e ultimo nome
     *
     * @param string $name
     * @return string
     */
    public function shortName(string $name): string
    {
        if (stristr($name, ' ')) {
            $name_explode =  explode(' ',  $name);
            $name =  array_shift($name_explode) . ' ' . array_pop($name_explode);
        }
        return $name;
    }


    public static function cards($cards, $statuses): string
    {
        $html = '<div class="row card-colunas">';

        if ($statuses) {
            // $last_status = $statuses
            foreach ($statuses as $status) {
                if (empty($first_status)) {
                    $first_status = $status->id_status;
                }
                $last_status = $status->id_status;
            }

            foreach ($statuses as $status) {

                $total_cards = 0;
                if ($cards) {
                    foreach ($cards as $card) {
                        if ($card->id_status == $status->id_status) {
                            $total_cards++;
                        }
                    }
                }

                $html .= '<div class="col-sm-6 col-md-3">
                            <div class="panel panel-primary coluna">
                                <div class="panel-heading">
                                    <p class="panel-title">
                                        ' . $status->status . '
                                        <span class="badge badge-num-cards">' . $total_cards . '</span>
                                    </p>
                                </div>
                                <div id="cards-' . $status->id_status . '" class="panel-body">';

                $html .= view('admin.kanban.includes.card', ['cards' => $cards, 'status' => $status, 'first_status' => ($first_status ?? null), 'last_status' => ($last_status ?? null)]);
                // $html .= Kanban::cards($cards, $status);
                $html .= '</div>
                        </div>
                </div>';
            }
        }

        $html .= '</div>';
        return $html;
    }


    /**
     * faz a movimentação dos cards
     *
     * @param integer $id
     * @param string $action
     * @return boolean
     */
    public function movement(int $id, string $action): bool
    {
        $action = (in_array($action, ['back', 'next']) ? $action : null);
        if (empty($id) || empty($action)) {
            $this->message = 'Faltam dados';
            return false;
        }

        $card = Card::where('id_card', '=', $id)->first();
        if (empty($card)) {
            $this->message = 'Card não encontrado';
            return false;
        }


        if ($card->id_status == 1 && $action == 'next') {
            $id_status = 2; // Material Recebido
        }


        if ($card->id_status == 2 && $action == 'next') {
            $teachers = (new Teacher)->getAllTeachers($card->id_card);
            $id_status = 3; // Em Conferência
            if (!empty($teachers->count()) && $teachers->count() == 1) {
                $id_status = 4; // Conferido
            }
        }

        if ($card->id_status == 3 && $action == 'next') {
            $id_status = 4; // Conferido
            $card_movement = (new CardMovement())->where('id_card', '=', $card->id_card)->orderBy('id_card_movimentacao', 'desc')->first();
            if (!empty($card_movement->dt_registro) && strtotime(date('Y-m-d H:i:s', strtotime($card_movement->dt_registro))) > strtotime(date('Y-m-d H:i:s', strtotime('-1 minute')))) {
                $this->message = 'O card foi atualizado á menos de 1 minuto';
                return false;
            }
        }

        // voltar para ultimo status da movimentação
        if ($action == 'back') {
            $card_movement = (new CardMovement())->where('id_card', '=', $card->id_card)->orderBy('id_card_movimentacao', 'desc')->offset(1)->first();
            if (!empty($card_movement->id_status)) {
                $id_status = $card_movement->id_status;
            }
        }

        // if (empty($id_status)) {
        //     $new_status = Status::where('id_status', ($action == 'back' ? '<' : '>'), $card->id_status)->orderByRaw(($action == 'back' ? 'id_status DESC' : 'id_status ASC'))->first();
        //     $id_status = $new_status->id_status;
        // }

        if (empty($id_status)) {
            $this->message = 'Status não encontrado';
            return false;
        }

        $card->id_status = $id_status;
        $card->save();

        (new CardMovement())->create([
            'id_card' => $card->id_card,
            'id_status' => $card->id_status,
            'dt_registro' => date('Y-m-d H:i:s')
        ]);

        return true;
    }
}
