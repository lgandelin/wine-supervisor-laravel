@extends('wine-supervisor::default')

@section('page-title') Editer un professionnel < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="technician-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Editer un professionnel</h1>
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

                <form action="{{ route('admin_technician_update_handler') }}" method="POST">

                    <!-- LEFT COLUMN -->
                    <div class="left-column">
                        <h2>ID Professionnel</h2>
                        <span class="id">{{ $technician->id }}</span>
                    </div>
                    <!-- LEFT COLUMN -->

                    <!-- RIGHT COLUMN -->
                    <div class="right-column">
                        <div class="form-group">
                            <label for="company">Nom de la société</label>
                            <input type="text" name="company" id="company" value="{{ $technician->company }}" disabled />
                        </div>

                        <div class="form-group">
                            <label for="registration">Immatriculation</label>
                            <input type="text" name="registration" id="registration" value="{{ $technician->registration }}" disabled />
                        </div>

                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input type="text" name="phone" id="phone" value="{{ $technician->phone }}" disabled />
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" value="{{ $technician->email }}" disabled />
                        </div>

                        <div class="form-group">
                            <label for="login">Login</label>
                            <input type="text" name="login" id="login" value="{{ $technician->login }}" disabled />
                        </div>

                        <div class="form-group">
                            <label for="address">Adresse</label>
                            <input type="text" name="address" id="address" value="{{ $technician->address }}" disabled />
                        </div>

                        <div class="form-group">
                            <label for="zipcode">Code postal</label>
                            <input type="text" name="zipcode" id="zipcode" value="{{ $technician->zipcode }}" disabled />
                        </div>

                        <div class="form-group">
                            <label for="city">Ville</label>
                            <input type="text" name="city" id="city" value="{{ $technician->city }}" disabled />
                        </div>

                        <div class="form-group">
                            <label for="country">Pays</label>
                            <select name="country" id="country" required>
                                @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                    <option value="{{ $key }}" @if ($technician->country == $key)selected="selected"@endif @if (!$technician->country && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="city">Statut</label>
                            <div class="radio"><input type="radio" name="status" @if ($technician->status === Webaccess\WineSupervisorLaravel\Models\Technician::STATUS_ENABLED)checked="checked"@endif value="on" /> Activé</div>
                            <div class="radio"><input type="radio" name="status"   @if (!$technician->status)checked="checked"@endif value="off" /> Désactivé</div>
                        </div>

                    </div>
                    <!-- RIGHT COLUMN -->

                    <div class="submit-container">
                        <input type="submit" value="Valider" />
                    </div>

                    <input type="hidden" name="technician_id" value="{{ $technician->id }}" />
                    {{ csrf_field() }}
                </form>

                <a class="button red-button back-button" href="{{ route('admin_technician_list') }}">Retour</a>

            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop