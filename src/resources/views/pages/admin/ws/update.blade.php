@extends('wine-supervisor::default')

@section('page-title') Editer un WineSupervisor < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="ws-template admin-template">

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
                        <input type="text" name="id" id="id" value="{{ $ws->cd_ws_id }}" disabled />
                    </div>

                    <div class="form-group">
                        <label for="board_type">Type de carte</label>
                        <select name="board_type" id="board_type">
                            @foreach ([
                                Webaccess\WineSupervisorLaravel\Models\WS::PRIMO_BOARD,
                                Webaccess\WineSupervisorLaravel\Models\WS::DEUXIO_BOARD,
                                Webaccess\WineSupervisorLaravel\Models\WS::SAV_BOARD,
                                Webaccess\WineSupervisorLaravel\Models\WS::OUT_OF_ORDER_BOARD,
                                Webaccess\WineSupervisorLaravel\Models\WS::RESELL_BOARD,
                            ] as $board_type)
                                <option value="{{ $board_type }}" @if ($ws->board_type == $board_type) selected="selected" @endif>
                                    {{ Webaccess\WineSupervisorLaravel\Services\WSService::getBoardTypeLabel($board_type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="first_activation_date">Date de <sup>1ère</sup> activation</label>
                        <input type="text" name="first_activation_date" id="first_activation_date" value="@if ($ws->first_activation_date){{ DateTime::createFromFormat('Y-m-d H:i:s', $ws->first_activation_date)->format('d/m/Y') }}@endif" disabled />
                    </div>

                    <div class="form-group">
                        <label for="deactivation_date">Date de désactivation</label>
                        <input type="text" name="deactivation_date" id="deactivation_date" value="@if ($ws->deactivation_date){{ DateTime::createFromFormat('Y-m-d H:i:s', $ws->deactivation_date)->format('d/m/Y') }}@endif" disabled />
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