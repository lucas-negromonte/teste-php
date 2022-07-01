<div class="row card-colunas">

    @if (!empty($statuses))
        @foreach ($statuses as $status)
            <div class="col-sm-6 col-md-3">

                <div class="panel panel-primary coluna">
                    <div class="panel-heading">
                        <p class="panel-title">
                            {{ $status->status }}
                            <span class="badge badge-num-cards">{{ $status->total_cards }}</span>
                        </p>
                    </div>
                    <div id="cards-{{ $status->id_status }}" class="panel-body">
                        @if (!empty($cards))
                            @foreach ($cards as $card)
                                @if ($status->id_status == $card->id_status)
                                    <div class="panel panel-default card {{ $card->id_tipo == 2 ? 'aulao' : '' }}"
                                        data-id="{{ $card->id_card }}">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-xs-9">
                                                    <h5> {{ $card->id_tipo == 2 ? 'AULÃO' : $card->curso }} </h5>
                                                    @if (!empty($card->professores))
                                                        <div class="wrapper-professores">
                                                            @foreach ($card->professores as $professor)
                                                                <span class="label">{{ $professor->nome }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="col-xs-3 text-right">
                                                    <span
                                                        class="label label-primary label-num-aula">A{{ $card->num_aula }}</span>
                                                    <span
                                                        class="label label-success label-ano">{{ $card->ano }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-footer">

                                            @if (!empty($card->materiais))
                                                @foreach ($card->materiais as $material)
                                                    <span class="glyphicon {{ $material->icone }}"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="{{ $material->material }}"
                                                        style="margin-right: 6px"></span>
                                                @endforeach
                                            @endif

                                            <div class="dropdown pull-right">
                                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                                    <span class="glyphicon glyphicon-move"></span>
                                                    Mover <span class="caret"></span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li class="dropdown-header">Ações</li>
                                                    <li role="separator" class="divider"></li>
                                                    <li><a href="#">&raquo; Prosseguir</a></li>
                                                    <li role="separator" class="divider"></li>
                                                    <li><a href="#">&laquo; Voltar</a></li>
                                                </ul>
                                            </div>

                                            <a href="javascript:;" class="pull-right" data-toggle="modal"
                                                data-target="#form-card" style="margin-right: 10px">
                                                <span class="glyphicon glyphicon-eye-open"></span> Visualizar
                                            </a>

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif

                    </div>
                </div>

            </div>
        @endforeach
    @endif

</div>
