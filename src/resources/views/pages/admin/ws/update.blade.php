@extends('wine-supervisor::default')

@section('page-title') Editer un WineSupervisor < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="ws-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Editer un WineSupervisor</h1>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-content">

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

                <form action="{{ route('admin_ws_update_handler') }}" method="POST">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input type="text" name="id" id="id" value="{{ $ws->id }}" disabled />
                    </div>

                    <div class="form-group">
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

                    <div class="submit-container">
                        <input type="submit" value="Valider" />
                    </div>

                    <input type="hidden" name="ws_id" value="{{ $ws->id }}" />
                    {{ csrf_field() }}
                </form>

                <a class="button red-button back-button" href="{{ route('admin_ws_list') }}">Retour</a>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop