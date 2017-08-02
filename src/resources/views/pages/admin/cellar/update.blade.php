@extends('wine-supervisor::default')

@section('page-title') Editer une cave < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="cellar-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Editer une cave</h1>
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

                <form action="{{ route('admin_cellar_update_handler') }}" method="POST">

                    <h2>Infos cave</h2>

                    <div class="form-group">
                        <label for="id_ws">Identifiant WineSupervisor</label>
                        <input type="text" name="id_ws" id="id_ws" value="{{ $cellar->id_ws }}" disabled />
                    </div>

                    <div class="form-group">
                        <label for="technician_id">ID Professionnel</label>
                        <input type="text" name="technician_id" id="technician_id" value="@if ($cellar->technician){{ $cellar->technician->technician_code }}@endif" disabled />
                    </div>

                    <div class="form-group">
                        <label for="name">Nom de la cave</label>
                        <input type="text" name="name" id="name" value="{{ $cellar->name }}" disabled />
                    </div>

                    <div class="form-group">
                        <label for="serial_number">N° de série</label>
                        <input type="text" name="serial_number" id="serial_number" value="{{ $cellar->serial_number }}" disabled />
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ $cellar->address }}" disabled />
                    </div>

                    <div class="form-group">
                        <label for="address2">Complément d'adresse</label>
                        <input type="text" name="address2" id="address2" value="{{ $cellar->address2 }}" disabled />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">Code postal</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ $cellar->zipcode }}" disabled />
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" value="{{ $cellar->city }}" disabled />
                    </div>

                    <div class="form-group">
                        <label for="country">Pays</label>
                        <select name="country" id="country" disabled>
                            @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                <option value="{{ $key }}" @if ($cellar->country == $key)selected="selected"@endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="user">Utilsateur associé</label>
                        @if ($cellar->user) <a href="{{ route('admin_user_update', ['uuid' => $cellar->user->id]) }}" title="Voir la fiche de l'utilisateur">{{ $cellar->user->last_name }} {{ $cellar->user->first_name }}</a> @endif
                    </div>

                    <div class="submit-container">
                        <input type="submit" value="Valider" style="display:none" />
                    </div>

                    <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
                    {{ csrf_field() }}
                </form>

                <a class="button red-button back-button" href="{{ route('admin_cellar_list') }}">Retour</a>

                @if ($cellar->history)
                    <h2 style="margin-top: 5rem;">Historique des modifications</h2>

                    <table class="table-list less-padding">
                        <tr class="table-row">
                            <th class="table-cell table-cell-header align-left">Champ</th>
                            <th class="table-cell table-cell-header align-left">Ancienne</th>
                            <th class="table-cell table-cell-header align-left">Nouvelle</th>
                            <th class="table-cell table-cell-header align-left">Utilisateur</th>
                            <th class="table-cell table-cell-header align-left">Date</th>
                        </tr>

                        @foreach ($cellar->history as $history)
                            <tr class="table-row">
                                <td class="table-cell align-left">{{ $history->column }}</td>
                                <td class="table-cell align-left">{{ $history->old_value }}</td>
                                <td class="table-cell align-left">{{ $history->new_value }}</td>
                                <td class="table-cell align-left">
                                    @if ($history->user) {{ $history->user->last_name }} {{ $history->user->first_name }} [Utilisateur] @endif
                                    @if ($history->admin) {{ $history->admin->last_name }} {{ $history->admin->first_name }} [Administrateur] @endif
                                </td>
                                <td class="table-cell align-left">@if ($history->created_at){{ DateTime::createFromFormat('Y-m-d H:i:s', $history->created_at)->format('d/m/Y H:i:s') }}@endif</td>
                            </tr>
                        @endforeach
                    </table>
                @endif

                <a class="button red-button back-button" href="{{ route('admin_cellar_list') }}" style="position: static; clear: both; display: inline-block; margin-top: 5rem; margin-bottom: 5rem;">Retour</a>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop