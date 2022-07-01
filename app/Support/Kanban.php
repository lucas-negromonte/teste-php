<?php

namespace App\Support;

use App\Models\Card;
use App\Models\Material;
use App\Models\Teacher;
use Illuminate\Support\Collection;


class Kanban
{
    /**
     * Buscar todos os cards e outros objetos vinculados
     *
     * @return Collection|null
     */
    public function getAllCards(): ?Collection
    {
        $cards = (new Card())->getAllCards();
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
                $html .= '<div class="col-sm-6 col-md-3">
                            <div class="panel panel-primary coluna">
                                <div class="panel-heading">
                                    <p class="panel-title">
                                        ' . $status->status . '
                                        <span class="badge badge-num-cards">' . $status->total_cards . '</span>
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
}