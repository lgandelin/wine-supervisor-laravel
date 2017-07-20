@extends('wine-supervisor::default')

@section('page-title')Mon compte | WineSupervisor @endsection

@section('page-content')

    <div class="my-account-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Mon compte</h1>
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

                <form action="{{ route('technician_update_account_handler') }}" method="POST">

                    <div class="form-group">
                        <label for="company">Nom de la société</label>
                        <input type="text" name="company" id="company" value="{{ $technician->company }}" required />
                    </div>

                    <div class="form-group">
                        <label for="registration">Immatriculation</label>
                        <input type="text" name="registration" id="registration" value="{{ $technician->registration }}" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="text" name="phone" id="phone" value="{{ $technician->phone }}" required />
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="{{ $technician->email }}" required />
                    </div>

                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" name="login" id="login" value="{{ $technician->login }}" required />
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" autocomplete="new-password" />
                        <i>Laisser vide pour ne pas modifier le mot de passe</i>
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ $technician->address }}" required />
                    </div>

                    <div class="form-group">
                        <label for="address2">Complément d'adresse</label>
                        <input type="text" name="address2" id="address2" value="{{ $technician->address2 }}" />
                    </div>


                    <div class="form-group">
                        <label for="zipcode">Code postal</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ $technician->zipcode }}" required />
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" value="{{ $technician->city }}" required />
                    </div>

                    <div class="form-group">
                        <label for="country">Pays</label>
                        <select name="country" id="country" required>
                            @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                <option value="{{ $key }}" @if ($technician->country == $key)selected="selected"@endif @if (!$technician->country && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="submit-container">
                        <input type="submit" class="button red-button" value="Valider" />
                    </div>

                    {{ csrf_field() }}
                </form>

            </div>
            <!-- PAGE CONTENT -->

        </div>

        @include('wine-supervisor::partials.legal-notices')

    </div>

@stop