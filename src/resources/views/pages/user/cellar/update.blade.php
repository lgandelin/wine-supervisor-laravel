@extends('wine-supervisor::default')

@section('page-content')

    <!--
    @include('wine-supervisor::pages.user.includes.menu')
    -->

    <div class="cellar-update-template">

        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner">
            <h1>
                <span class="subtitle">Mes caves</span>
                <span class="title">Accessibles partout</span>
            </h1>
            <span class="border"></span>
        </div>
        <!-- BANNER -->

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Modification de cave</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus elit. A hendrerit justo curabitur nteger a hendrerit justo. Curabitur rhoncus faucibus elit. </p>
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

                <!-- LEFT COLUMN -->
                <div class="left-column">
                    <h2>Adresse Mak</h2>
                    <span class="mak">{{ $cellar->id_ws }}</span>

                    <h2>N° de série de l'appareil</h2>
                    <span class="serial-number">{{ $cellar->serial_number }}</span>

                    <div class="links">
                        <a class="link" href="#">SAV</a>
                        <a class="link" href="#">Supprimer</a>
                    </div>
                </div>
                <!-- LEFT COLUMN -->

                <!-- RIGHT COLUMN -->
                <div class="right-column">
                    <form action="{{ route('user_cellar_update_handler') }}" method="POST">
                        <div class="form-group">
                            <label for="name">Nom de la cave</label>
                            <input type="text" name="name" value="{{ $cellar->name }}" />
                        </div>

                        <div class="form-group">
                            <label for="technician_id">ID Professionnel</label>
                            <input type="text" name="technician_id" id="technician_id" value="{{ $cellar->technician_id }}" />
                        </div>

                        <div class="form-group">
                            <label for="subscription_type">Type d'abonnement</label>
                            <select name="subscription_type" id="subscription_type">
                                <option value="-1">Sélectionner</option>
                                <option value="{{ Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION }}" @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION)selected="selected"@endif>Standard</option>
                                <option value="{{ Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION}}" @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION)selected="selected"@endif>Premium</option>
                                <option value="{{ Webaccess\WineSupervisorLaravel\Models\Subscription::FREE_SUBSCRIPTION}}" @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::FREE_SUBSCRIPTION)selected="selected"@endif>Gratuit</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="address">Adresse de la cave</label>
                            <input type="text" name="address" value="{{ $cellar->address }}" />
                        </div>

                        <div class="form-group">
                            <label for="zipcode">Code postal</label>
                            <input type="text" name="zipcode" id="zipcode" value="{{ $cellar->zipcode }}"/>
                        </div>

                        <div class="form-group">
                            <label for="city">Ville</label>
                            <input type="text" name="city" id="city" value="{{ $cellar->city }}"/>
                        </div>

                        <div class="submit-container">
                            <input type="submit" class="button red-button" value="Valider" />
                        </div>

                        <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
                        {{ csrf_field() }}
                    </form>
                </div>
                <!-- RIGHT COLUMN -->

            </div>
            <!-- PAGE CONTENT -->

            <a class="button red-button back-button" href="{{ route('user_cellar_list') }}">Retour</a>
        </div>

        @include('wine-supervisor::partials.legal-notices')

        <!--<h2>SAV</h2>

        <p>Si vous avez changé votre carte, veuillez renseignez ci-dessous l'adresse MAK de votre nouvelle carte.</p>

        <form action="{{ route('user_cellar_sav_handler') }}" method="POST">
            <div>
                <label for="id_ws">Nouvelle adresse MAK</label>
                <input type="text" name="id_ws" id="id_ws" />
            </div>

            <a href="{{ route('user_cellar_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
            {{ csrf_field() }}
        </form>

        <h2>Suppression</h2>

        <p>ATTENTION : Valider ce formulaire entrainera la suppression de votre cave dans le système.</p>

        <form action="{{ route('user_cellar_delete_handler') }}" method="POST">
            <div>
                <label for="reason">Raison de la suppression</label>
                <select name="reason" id="reason">
                    <option value="board_out_of_order">Carte HS</option>
                    <option value="other">Autre</option>
                </select>
            </div>

            <a href="{{ route('user_cellar_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
            {{ csrf_field() }}
        </form>-->

    </div>
@stop