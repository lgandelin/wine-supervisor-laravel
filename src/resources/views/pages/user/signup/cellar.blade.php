@extends('wine-supervisor::default')

@section('page-title') Créer une cave | WineSupervisor @endsection

@section('page-content')
    <div class="signup-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            <!-- STEPS -->
            <div class="steps">
                <div class="step">
                    <span class="step-number">1</span>
                    <span class="step-title">Compte</span>
                </div>

                <div class="step active">
                    <span class="step-number">2</span>
                    <span class="step-title">Cave</span>
                </div>
            </div>
            <!-- STEPS -->


            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Création d'une cave</h1>
                <p>Vous connectez votre cave, inscrivez vos informations dans le formulaire.<br>
                    L’identifiant WineSupervisor et le code d’activation sont inscrits sur votre boitier WineSupervisor II. Ils permettent de connecter votre cave au superviseur.<br>
                    L’ID Professionnel vous est remis par l’installateur en charge du suivi de l’installation. Cette information peut être renseignée ultérieurement.</p>
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

                <form action="{{ route('user_signup_cellar_handler') }}" method="post">

                    <div class="form-group">
                        <label for="name">Nom de la cave</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" />
                    </div>

                    <div class="form-group">
                        <label for="id_ws">Identifiant WineSupervisor <span class="required">*</span></label>
                        @for ($i = 1; $i <= 6; $i++)
                            <input class="id_ws" type="text" name="id_ws_{{ $i }}" value="{{ old('id_ws_' . $i) }}" style="width:6.5rem; display: inline-block;" maxlength="2" required />
                            @if ($i < 6)
                                <span class="separator" style="display: inline-block; margin-left: 1rem; margin-right: 1rem;">:</span>
                            @endif
                        @endfor
                    </div>

                    <div class="form-group">
                        <label for="activation_code">Code d'activation <span class="required">*</span></label>
                        <input type="text" name="activation_code" id="activation_code" value="{{ old('activation_code') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="id_ws">ID Professionnel</label>
                        <input type="text" name="technician_id" id="technician_id" value="{{ old('technician_id') }}" />
                    </div>

                    <div class="form-group">
                        <label for="serial_number">N° de série</label>
                        <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" />
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse de la cave <span class="required">*</span></label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="address2">Complément d'adresse</label>
                        <input type="text" name="address2" id="address2" value="{{ old('address2') }}" />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">Code postal</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}" />
                    </div>

                    <div class="form-group">
                        <label for="city">Ville <span class="required">*</span></label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="country">Pays <span class="required">*</span></label>
                        <select name="country" id="country">
                            @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                <option value="{{ $key }}" @if (old('country') == $key)selected="selected"@endif @if (!old('country') && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="submit-container">
                        <i class="legend"><span class="required">*</span> : champs obligatoires</i>
                        <input type="submit" class="button red-button" value="Valider" />
                    </div>

                    {{ csrf_field() }}
                </form>

            </div>
            <!-- PAGE CONTENT -->

            <a class="button red-button back-button" href="{{ route('user_signup') }}">Retour</a>
        </div>

        @include('wine-supervisor::partials.legal-notices')

    </div>
@stop