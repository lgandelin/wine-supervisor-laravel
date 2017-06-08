@extends('wine-supervisor::default')

@section('page-content')
    <div class="ws-template">

        @if (isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif

        @if (isset($confirmation))
            <div class="alert alert-success">
                {{ $confirmation }}
            </div>
        @endif

        <h1>Editer un WineSupervisor</h1>

        <form action="{{ route('admin_ws_update_handler') }}" method="POST">

            <div>
                <label for="id">ID</label>
                <input type="text" name="id" id="id" value="{{ $ws->id }}" disabled />
            </div>

            <div>
                <label for="board_type">Type de carte</label>
                <select name="board_type" id="board_type">
                    @foreach ([
                        Webaccess\WineSupervisorLaravel\Models\WS::PRIMO_BOARD,
                        Webaccess\WineSupervisorLaravel\Models\WS::SAV_BOARD,
                        Webaccess\WineSupervisorLaravel\Models\WS::OUT_OF_ORDER_BOARD,
                        Webaccess\WineSupervisorLaravel\Models\WS::OTHER_BOARD,
                    ] as $board_type)
                        <option value="{{ $board_type }}" @if ($ws->board_type == $board_type) selected="selected" @endif>
                            {{ Webaccess\WineSupervisorLaravel\Services\WSService::getBoardTypeLabel($board_type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <a href="{{ route('admin_ws_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="ws_id" value="{{ $ws->id }}" />
            {{ csrf_field() }}
        </form>

    </div>
@stop