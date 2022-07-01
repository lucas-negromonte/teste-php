@extends('admin.template')

@section('js')
    <script src="./assets/js/admin/kaban/app.js?{{ date('YmdHis') }}"></script>
@endsection

@section('content')

    <form action="data-url="{{ route('web.index.post') }}" method="POST" enctype="multipart/form-data" class="quick_filter" >
        @csrf
        @method('POST')

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Curso</label>
                    <select id="select-filtro-curso" name="id_curso" class="form-control">
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
                    <select id="select-filtro-num-aula" name="num_aula"  class="form-control">
                        <option value="" readonly>Todos</option>
                        @if (!empty($num_classes))
                            @foreach ($num_classes as $num_classe)
                                <option value="{{ $num_classe->num_aula }}">A{{ $num_classe->num_aula }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Professor</label>
                    <div class="input-group">
                        <input id="input-filtro-professor" name="professor" type="text" class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-search"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Ordenar por</label>
                    <select id="select-filtro-ordenar-por" name="order"   class="form-control">
                        <option value="ano">Ano</option>
                        <option value="curso">Curso</option>
                        <option value="professor.nome">Professor</option>
                        <option value="num_aula">Nº Aula</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">&nbsp;</label>
                    <select id="select-filtro-ordenar-por" name="order_type"  class="form-control">
                        <option value="asc">Crescente</option>
                        <option value="desc">Decrescente</option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <div class="msg"></div>
    <div id="app" data-url="{{ route('web.index.post') }}"></div>


@endsection
