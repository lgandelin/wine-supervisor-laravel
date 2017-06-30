@extends('wine-supervisor::default')

@section('page-content')

    <!--
    @include('wine-supervisor::pages.user.includes.menu')
    -->

    <div class="cellar-create-template">

        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner">
            <h1>
                <span class="subtitle">Mes caves</span>
                <span class="title">Accessibles partout</span>
            </h1>
            <span class="border"></span>
        </div>
        <!-- BANNER -->

        <div class="main-content container">

             <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Ajouter une cave</h1>
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

            <form action="{{ route('user_cellar_create_handler') }}" method="POST">

                <div class="form-group">
                    <label for="name">Nom de la cave</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"/>
                </div>

                <div class="form-group">
                    <label for="id_ws">Adresse MAK</label>
                    <input type="text" name="id_ws" id="id_ws" value="{{ old('id_ws') }}" />
                </div>

                <div class="form-group">
                    <label for="serial_number">N° de série</label>
                    <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" />
                </div>

                <div class="form-group">
                    <label for="technician_id">ID Professionnel</label>
                    <input type="text" name="technician_id" id="technician_id" value="{{ old('technician_id') }}"/>
                </div>

                <div class="form-group">
                    <label for="address">Adresse</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}"/>
                </div>

                <div class="form-group">
                    <label for="zipcode">Code postal</label>
                    <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}"/>
                </div>

                <div class="form-group">
                    <label for="city">Ville</label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}"/>
                </div>

                <div class="submit-container">
                    <input type="submit" class="button red-button" value="Valider" />
                </div>

                {{ csrf_field() }}
            </form>
        </div>
        <!-- PAGE CONTENT -->

        <a class="button red-button back-button" href="{{ route('user_cellar_list') }}">Retour</a>

    </div>
@stop