@extends('wine-supervisor::default')

@section('page-title') Editer un utilisateur < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="user-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Editer un utilisateur</h1>
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

                <form action="{{ route('admin_user_update_handler') }}" method="POST">

                    <div class="form-group">
                        <label for="first_name">Prénom</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $user->first_name }}" />
                    </div>

                    <div class="form-group">
                        <label for="last_name">Nom</label>
                        <input type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" />
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="text" name="phone" id="phone" value="{{ $user->phone }}" />
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="{{ $user->email }}" />
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe <span class="required">*</span> <i style="display:inline-block; vertical-align: middle; margin-left: 1rem;">(7 caractères minimum)</i></label>
                        <input type="password" name="password" id="password" autocomplete="new-password" value="********" />
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirmation du mot de passe <span class="required">*</span></label>
                        <input type="password" name="password_confirm" id="password_confirm" autocomplete="new-password" value="********" />
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse</label>
                        <input type="text" name="address" id="address" value="{{ $user->address }}" />
                    </div>

                    <div class="form-group">
                        <label for="address2">Complément d'adresse</label>
                        <input type="text" name="address2" id="address2" value="{{ $user->address2 }}" />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">Code postal</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ $user->zipcode }}" />
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" value="{{ $user->city }}" />
                    </div>

                    <div class="form-group">
                        <label for="country">Pays</label>
                        <select name="country" id="country" required>
                            @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                <option value="{{ $key }}" @if ($user->country == $key)selected="selected"@endif @if (!$user->country && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="creation_date">Date de création</label>
                        <input type="text" name="creation_date" id="creation_date" value="{{ DateTime::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d/m/y') }}" disabled />
                    </div>

                    <div class="form-group">
                        <label for="last_connection_date">Date de dernière connexion</label>
                        <input type="text" name="last_connection_date" id="last_connection_date" value="{{ DateTime::createFromFormat('Y-m-d H:i:s', $user->last_connection_date)->format('d/m/y') }}" disabled />
                    </div>

                    <div class="form-group">
                        <label for="opt_in">Inscrit à la Newsletter</label>
                        <div class="radio"><input type="radio" name="opt_in" value="1" id="opt_in" @if ($user->opt_in == true || $user->opt_in === null)checked="checked"@endif /> Oui</div>
                        <div class="radio"><input type="radio" name="opt_in" value="0" @if (!$user->opt_in)checked="checked"@endif /> Non</div>
                    </div>

                    <div class="form-group">
                        <label for="opt_in">Lecture seule</label>
                        <div class="radio"><input type="radio" name="read_only" value="1" id="read_only" @if ($user->read_only == true || $user->read_only === null)checked="checked"@endif /> Oui</div>
                        <div class="radio"><input type="radio" name="read_only" value="0" @if (!$user->read_only)checked="checked"@endif /> Non</div>
                    </div>

                    @if ($cellars)
                    <div class="form-group">
                        <label for="user">Caves associées</label>
                        @foreach ($cellars as $cellar)
                            <a href="{{ route('admin_cellar_update', ['uuid' => $cellar->id]) }}" title="Voir la fiche de la cave">@if ($cellar->name){{ $cellar->name }}@else{{ 'Ma cave' }}@endif </a>
                            <br>
                        @endforeach
                    </div>
                    @endif

                    <div class="submit-container">
                        <input type="submit" value="Valider" />
                    </div>

                    <input type="hidden" name="user_id" value="{{ $user->id }}" />
                    {{ csrf_field() }}
                </form>

                <a class="button red-button back-button" href="{{ route('admin_user_list') }}">Retour</a>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop