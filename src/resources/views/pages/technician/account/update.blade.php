@extends('wine-supervisor::default')

@section('page-title')Mon compte | WineSupervisor @endsection

@section('page-content')

    <div class="technician-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Mon compte</h1>
                <p>
                    Votre compte professionnel vous permet de suivre l’intégralité des climatiseurs de cave connectés que vous avez installés et dont vous avez la charge soit pendant la période de garantie ou lors d’un contrat d’entretien établi avec votre client.<br>
                    Lorsque celui-ci enregistre sur sa cave votre ID Professionnel vous êtes en mesure de la retrouver d’un coup d’œil sur la carte de WineSupervisor ou en tapant le nom du client.
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

                <form action="{{ route('technician_update_account_handler') }}" method="POST">

                    <!-- LEFT COLUMN -->
                    <div class="left-column">
                        <h2>ID Professionnel</h2>
                        <span class="id">{{ $technician->technician_code }}</span>
                    </div>
                    <!-- LEFT COLUMN -->

                    <!-- RIGHT COLUMN -->
                    <div class="right-column">
                        <div class="form-group">
                            <label for="last_name">Nom</label>
                            <input type="text" name="last_name" id="last_name" value="{{ $technician->last_name }}" />
                        </div>

                        <div class="form-group">
                            <label for="first_name">Prénom</label>
                            <input type="text" name="first_name" id="first_name" value="{{ $technician->first_name }}" />
                        </div>

                        <div class="form-group">
                            <label for="company">Nom de la société <span class="required">*</span></label>
                            <input type="text" name="company" id="company" value="{{ $technician->company }}" required />
                        </div>

                        <div class="form-group">
                            <label for="registration">Immatriculation<span class="required">*</span> <i style="display:inline-block; vertical-align: middle; margin-left: 1rem;">(N° de TVA intracommunautaire)</i></label>
                            <input type="text" name="registration" id="registration" value="{{ $technician->registration }}" required />
                        </div>

                        <div class="form-group">
                            <label for="phone">Téléphone <span class="required">*</span></label>
                            <input type="text" name="phone" id="phone" value="{{ $technician->phone }}" required />
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="text" name="email" id="email" value="{{ $technician->email }}" required />
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe <span class="required">*</span> <i style="display:inline-block; vertical-align: middle; margin-left: 1rem;">(7 caractères minimum)</i></label>
                            <input type="password" name="password" id="password" value="********" />
                        </div>

                        <div class="form-group">
                            <label for="password_confirm">Confirmation du mot de passe <span class="required">*</span></label>
                            <input type="password" name="password_confirm" id="password_confirm" autocomplete="new-password" value="********" />
                        </div>

                        <div class="form-group">
                            <label for="address">Adresse <span class="required">*</span></label>
                            <input type="text" name="address" id="address" value="{{ $technician->address }}" required />
                        </div>

                        <div class="form-group">
                            <label for="address2">Complément d'adresse</label>
                            <input type="text" name="address2" id="address2" value="{{ $technician->address2 }}" />
                        </div>

                        <div class="form-group">
                            <label for="zipcode">Code postal</label>
                            <input type="text" name="zipcode" id="zipcode" value="{{ $technician->zipcode }}" />
                        </div>

                        <div class="form-group">
                            <label for="city">Ville <span class="required">*</span></label>
                            <input type="text" name="city" id="city" value="{{ $technician->city }}" required />
                        </div>

                        <div class="form-group">
                            <label for="country">Pays <span class="required">*</span></label>
                            <select name="country" id="country" required>
                                @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                    <option value="{{ $key }}" @if ($technician->country == $key)selected="selected"@endif @if (!$technician->country && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <i class="legend"><span class="required">*</span> : champs obligatoires</i>
                    </div>
                    <!-- RIGHT COLUMN -->

                    @if (!$technician->read_only)
                        <div class="submit-container">
                            <input type="submit" class="button red-button" value="Valider" />
                        </div>
                    @endif

                    {{ csrf_field() }}
                </form>

            </div>
            <!-- PAGE CONTENT -->

        </div>

        @include('wine-supervisor::partials.legal-notices')

    </div>

@stop