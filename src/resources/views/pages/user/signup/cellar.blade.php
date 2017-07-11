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
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus elit.</p>
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
                        <label for="id_ws">Adresse Mak</label>
                        <input type="text" name="id_ws" id="id_ws" value="{{ old('id_ws') }}" />
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
                        <label for="address">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">Code postal</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required />
                    </div>

                    <div class="submit-container">
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