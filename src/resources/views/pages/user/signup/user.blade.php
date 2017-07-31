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
            <div class="page-header" id="user_header">
                <h1>Créer un compte</h1>
                <p>Vous venez d’acquérir un WineSupervisor II et désirez le connecter. Rien de plus simple.<br>
                    Remplissez le formulaire en cochant la case utilisateur. Indiquez les codes fournis avec votre produit. Validez, vous êtes connectés sur le superviseur.<br>
                    Si vous avez déjà un compte et que vous désirez ajouter une nouvelle cave alors connectez-vous et créez votre nouvelle cave dans ce compte.</p>
            </div>

            <div class="page-header" id="technician_header" style="display:none">
                <h1>Créer un compte</h1>
                <p>Vous êtes installateurs de systèmes WineSupervisor II. Cochez la case installateur et remplissez le formulaire. Après validation par notre équipe vous
                    obtiendrez un identifiant que vous communiquerez aux utilisateurs dont vous avez le suivi des caves. Vous pourrez ainsi suivre le bon fonctionnement
                    de l’ensemble des installations réalisées chez vos clients.
                </p>
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
                        <div class="radio"><input type="radio" name="type" value="1" checked="checked" /> Utilisateur</div>
                        <div class="radio"><input type="radio" name="type" value="2"> Installateur</div>
                    </div>
                </form>

                <!-- USER FORM -->
                <form id="user_signup" action="{{ route('user_signup_handler') }}" method="post">

                    <div class="form-group">
                        <label for="last_name">Nom <span class="required">*</span></label>
                        <input type="text" name="last_name" id="last_name" value="{{ $last_name }}" required />
                    </div>

                    <div class="form-group">
                        <label for="first_name">Prénom</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $first_name }}" />
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone <span class="required">*</span></label>
                        <input type="text" name="phone" id="phone" value="{{ $phone }}" required />
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="text" name="email" id="email" value="{{ $email }}" required />
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe <span class="required">*</span><i style="display:inline-block; vertical-align: middle; margin-left: 1rem;">(7 caractères minimum)</i></label>
                        <input type="password" name="password" id="password" required />
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirmation mot de passe <span class="required">*</span></label>
                        <input type="password" name="password_confirm" id="password_confirm" required />
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse <span class="required">*</span></label>
                        <input type="text" name="address" id="address" value="{{ $address }}" required />
                    </div>

                    <div class="form-group">
                        <label for="address2">Complément d'adresse</label>
                        <input type="text" name="address2" id="address2" value="{{ $address2 }}" />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">Code postal <span class="required">*</span></label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ $zipcode }}" required />
                    </div>

                    <div class="form-group">
                        <label for="city">Ville <span class="required">*</span></label>
                        <input type="text" name="city" id="city" value="{{ $city }}" required />
                    </div>

                    <div class="form-group">
                        <label for="country">Pays <span class="required">*</span></label>
                        <select name="country" id="country" required>
                            @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                <option value="{{ $key }}" @if ($country == $key)selected="selected"@endif @if (!$country && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="opt_in" style="display: inline-block; margin-right: 1rem; vertical-align: middle;">Recevoir la Newsletter du Club</label><i>(modifiable dans votre espace utilisateur)</i><br>
                        <div class="radio"><input type="radio" name="opt_in" value="1" id="opt_in" @if ($opt_in == true || $opt_in === null)checked="checked"@endif /> Oui</div>
                        <div class="radio"><input type="radio" name="opt_in" value="0" @if (!$opt_in)checked="checked"@endif /> Non</div>
                    </div>

                    <i class="legend"><span class="required">*</span> : champs obligatoires</i>

                    <div class="submit-container">
                        <input type="submit" class="button red-button" value="Valider" />
                    </div>

                    {{ csrf_field() }}
                </form>
                <!-- USER FORM -->


                <!-- TECHNICIAN FORM -->
                <form id="technician_signup" action="{{ route('technician_signup_handler') }}" method="post" style="display:none">

                    <div class="form-group">
                        <label for="company">Nom de la société <span class="required">*</span></label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="registration">Immatriculation <span class="required">*</span></label>
                        <input type="text" name="registration" id="registration" value="{{ old('registration') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone <span class="required">*</span></label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="text" name="email" id="email" value="{{ old('email') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe <span class="required">*</span></label>
                        <input type="password" name="password" id="password" required />
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirmation mot de passe <span class="required">*</span></label>
                        <input type="password" name="password_confirm" id="password_confirm" required />
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse <span class="required">*</span></label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="address2">Complément d'adresse</label>
                        <input type="text" name="address2" id="address2" value="{{ old('address2') }}" />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">Code postal <span class="required">*</span></label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="city">Ville <span class="required">*</span></label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="country">Pays <span class="required">*</span></label>
                        <select name="country" id="country" required>
                            @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                <option value="{{ $key }}" @if (old('country') == $key)selected="selected"@endif @if (!old('country') && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <i class="legend"><span class="required">*</span> : champs obligatoires</i>

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

            //User type
            $('input[name="type"]').change(function() {
                if ($(this).val() == 1) {
                    $('#user_signup').show();
                    $('#user_header').show();
                    $('#technician_signup').hide();
                    $('#technician_header').hide();
                    $('.steps .step').show();
                } else if ($(this).val() == 2) {
                    $('#user_signup').hide();
                    $('#user_header').hide();
                    $('#technician_signup').show();
                    $('#technician_header').show();
                    $('.steps .step').hide();
                }
            });

            //Disable copy paste in email field
            /*$('#email, #email_confirm').on('cut copy paste', function(e) {
                e.preventDefault();
            });*/
        });
    </script>
@stop