@extends('wine-supervisor::default')

@section('page-title')Mon compte | WineSupervisor @endsection

@section('page-content')

    <div class="technician-template">

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

                    <!-- LEFT COLUMN -->
                    <div class="left-column">
                        <h2>ID Professionnel</h2>
                        <span class="id">{{ $technician->id }}</span>
                    </div>
                    <!-- LEFT COLUMN -->

                    <!-- RIGHT COLUMN -->
                    <div class="right-column">
                        <div class="form-group">
                            <label for="company">Nom de la société <span class="required">*</span></label>
                            <input type="text" name="company" id="company" value="{{ $technician->company }}" required />
                        </div>

                        <div class="form-group">
                            <label for="registration">Immatriculation <span class="required">*</span></label>
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
                            <label for="login">Login <span class="required">*</span></label>
                            <input disabled type="text" name="login" id="login" value="{{ $technician->login }}" required />
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe <span class="required">*</span></label>
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
                            <label for="zipcode">Code postal <span class="required">*</span></label>
                            <input type="text" name="zipcode" id="zipcode" value="{{ $technician->zipcode }}" required />
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