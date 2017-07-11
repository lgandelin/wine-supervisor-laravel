@extends('wine-supervisor::default')

@section('page-title') Créer un compte | WineSupervisor @endsection

@section('page-content')
    <div class="signup-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            <!-- STEPS -->
            <div class="steps">
                <div class="step active">
                    <span class="step-number">1</span>
                    <span class="step-title">Compte</span>
                </div>

                <div class="step">
                    <span class="step-number">2</span>
                    <span class="step-title">Cave</span>
                </div>
            </div>
            <!-- STEPS -->


            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Créer un compte</h1>
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

                <form action="">
                    <div class="form-group">
                        <label>Vous êtes</label>
                        <select name="type" id="type">
                            <option value="-1">Sélectionner</option>
                            <option value="1">Client de WineSupervisor</option>
                            <option value="2">Professionnel</option>
                        </select>
                    </div>
                </form>

                <!-- USER FORM -->
                <form id="user_signup" action="{{ route('user_signup_handler') }}" method="post">

                    <div class="form-group">
                        <label for="last_name">Nom</label>
                        <input type="text" name="last_name" id="last_name" value="{{ $last_name }}" required />
                    </div>

                    <div class="form-group">
                        <label for="first_name">Prénom</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $first_name }}"/>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="{{ $email }}" required />
                    </div>

                    <div class="form-group">
                        <label for="email_confirm">Confirmation email</label>
                        <input type="text" name="email_confirm" id="email_confirm" value="{{ $email }}"/>
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="text" name="phone" id="phone" value="{{ $phone }}" required />
                    </div>

                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" name="login" id="login" value="{{ $login }}" required />
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" required />
                    </div>

                    <div class="form-group">
                        <label for="opt_in">Infos Club</label>
                        <div class="radio"><input type="radio" name="opt_in" value="1" id="opt_in" @if ($opt_in === true || $opt_in === null)checked="checked"@endif /> Oui</div>
                        <div class="radio"><input type="radio" name="opt_in" value="0" @if ($opt_in === false)checked="checked"@endif /> Non</div>
                    </div>

                    <div class="submit-container">
                        <input type="submit" class="button red-button" value="Valider" />
                    </div>

                    {{ csrf_field() }}
                </form>
                <!-- USER FORM -->


                <!-- TECHNICIAN FORM -->
                <form id="technician_signup" action="{{ route('technician_signup_handler') }}" method="post" style="display:none">

                    <div class="form-group">
                        <label for="company">Nom de la société</label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="registration">Immatriculation</label>
                        <input type="text" name="registration" id="registration" value="{{ old('registration') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="{{ old('email') }}" />
                    </div>

                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" name="login" id="login" value="{{ old('login') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" required />
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">Code postal</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}" />
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" />
                    </div>

                    <div class="submit-container">
                        <input type="submit" class="button red-button" value="Valider" />
                    </div>

                    {{ csrf_field() }}
                </form>
                <!-- TECHNICIAN FORM -->

            </div>
            <!-- PAGE CONTENT -->
        </div>

        @include('wine-supervisor::partials.legal-notices')

    </div>

    <script>
        $(document).ready(function() {
           $('#type').change(function() {
               if ($(this).val() == 1) {
                   $('#user_signup').show();
                   $('#technician_signup').hide();
                   $('.steps .step').show();
               } else if ($(this).val() == 2) {
                   $('#user_signup').hide();
                   $('#technician_signup').show();
                   $('.steps .step').hide();
               }
           });
        });
    </script>
@stop