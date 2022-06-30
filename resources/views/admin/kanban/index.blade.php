@extends('admin.template')

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Curso</label>
                <select id="select-filtro-curso" class="form-control">
                    <option value="" readonly>Todos</option>
                    @if (!empty($courses))
                        @foreach ($courses as $course)
                            <option value="{{ $course->id_curso }}">{{ $course->curso }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-sm-2 col-md-1">
            <div class="form-group">
                <label class="control-label">Nº Aula</label>
                <select id="select-filtro-num-aula" class="form-control">
                    <option value="" readonly>Todos</option>
                    @if (!empty($num_classes))
                        @foreach ($num_classes as $num_classe)
                            <option value="{{ $num_classe->total }}">A{{ $num_classe->total }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Professor</label>
                <div class="input-group">
                    <input id="input-filtro-professor" type="text" class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-search"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control-label">Ordenar por</label>
                <select id="select-filtro-ordenar-por" class="form-control">
                    <option value="ano">Ano</option>
                    <option value="curso">Curso</option>
                    <option value="professor">Professor</option>
                    <option value="num-aula">Nº Aula</option>
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="control-label">&nbsp;</label>
                <select id="select-filtro-ordenar-por" class="form-control">
                    <option value="asc">Crescente</option>
                    <option value="desc">Decrescente</option>
                </select>
            </div>
        </div>
    </div>

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
                            @include('admin.kanban.includes.card')
                        </div>
                    </div>

                </div>
            @endforeach
        @endif
        
        {{-- <div class="col-sm-6 col-md-3">

            <!-- MATERIAL RECEBIDO -->
            <!-- *************************************************** -->

            <div class="panel panel-info coluna">
                <div class="panel-heading">
                    <p class="panel-title">
                        Material Recebido
                        <span class="badge badge-num-cards">3</span>
                    </p>
                </div>
                <div id="cards-material-recebido" class="panel-body">

                    @include('admin.kanban.includes.card')

                </div>
            </div>

        </div>
        <div class="col-sm-6 col-md-3">

            <!-- EM CONFERÊNCIA -->
            <!-- *************************************************** -->

            <div class="panel panel-danger coluna">
                <div class="panel-heading">
                    <p class="panel-title">
                        Em Conferência
                        <span class="badge badge-num-cards">3</span>
                    </p>
                </div>
                <div id="cards-em-conferencia" class="panel-body">

                    @include('admin.kanban.includes.card')

                </div>
            </div>

        </div>
        <div class="col-sm-6 col-md-3">

            <!-- CONFERIDO -->
            <!-- *************************************************** -->

            <div class="panel panel-success coluna">
                <div class="panel-heading">
                    <p class="panel-title">
                        Conferido
                        <span class="badge badge-num-cards">3</span>
                    </p>
                </div>
                <div id="cards-conferido" class="panel-body">

                    @include('admin.kanban.includes.card')

                </div>
            </div> 

        </div> --}}
    </div>
@endsection
