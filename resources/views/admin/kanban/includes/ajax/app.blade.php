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

</div>
