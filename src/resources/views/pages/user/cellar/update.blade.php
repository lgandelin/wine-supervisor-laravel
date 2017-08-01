@extends('wine-supervisor::default')

@section('page-title') Modifier une cave | WineSupervisor @endsection

@section('page-content')

    <div class="cellar-update-template">

        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner">
            <h1>
                <span class="title">La Cave, partout.</span>
            </h1>
        </div>
        <!-- BANNER -->

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Modification de cave</h1>
                <p>Vous pouvez modifier les informations sur votre cave si vous le désirez.<br/>
                    L’ID professionnel peut-être ajouté si toutefois vous n’en disposiez pas lors de l’enregistrement initial.</p>
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
                    <h2>Identifiant WineSupervisor</h2>
                    <span class="mak">{{ $cellar->id_ws }}</span>

                    @if ($cellar->serial_number)
                        <h2>N° de série de l'appareil</h2>
                        <span class="serial-number">{{ $cellar->serial_number }}</span>
                    @endif

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
                            <label for="subscription_type">Type d'abonnement <span class="required">*</span></label>
                            <select name="subscription_type" id="subscription_type" required>
                                <option value="">Sélectionner</option>
                                <option value="{{ Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION }}" @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION)selected="selected"@endif>Standard</option>
                                {{--<option value="{{ Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION}}" @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION)selected="selected"@endif>Premium</option>--}}
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="address">Adresse de la cave <span class="required">*</span></label>
                            <input type="text" name="address" value="{{ $cellar->address }}" required />
                        </div>

                        <div class="form-group">
                            <label for="address2">Complément d'adresse</label>
                            <input type="text" name="address2" id="address2" value="{{ $cellar->address2 }}"/>
                        </div>

                        <div class="form-group">
                            <label for="zipcode">Code postal</label>
                            <input type="text" name="zipcode" id="zipcode" value="{{ $cellar->zipcode }}" />
                        </div>

                        <div class="form-group">
                            <label for="city">Ville <span class="required">*</span></label>
                            <input type="text" name="city" id="city" value="{{ $cellar->city }}" required />
                        </div>

                        <div class="form-group">
                            <label for="country">Pays <span class="required">*</span></label>
                            <select name="country" id="country" required>
                                @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                    <option value="{{ $key }}" @if ($cellar->country == $key)selected="selected"@endif>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <i class="legend"><span class="required">*</span> : champs obligatoires</i>

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

            <a class="button red-button back-button" href="{{ route('user_update_account') }}">Retour</a>
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