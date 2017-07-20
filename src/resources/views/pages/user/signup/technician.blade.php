@extends('wine-supervisor::default')

@section('page-title') Création de votre compte professionnel effectuée | WineSupervisor @endsection

@section('page-content')
    <div class="signup-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Créer un compte</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a hendrerit justo. Curabitur rhoncus faucibus elit.</p>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-content" style="padding-top: 6rem">

                <h2 class="subtitle">Confirmation</h2>
                <p>
                    Votre compte professionnel a été créé avec succès. Nous vous avertirons par mail une fois votre compte validé.<br/><br/>
                    Cordialement,<br/><br/>
                    L'équipe de WineSupervisor
                </p>

            </div>
            <!-- PAGE CONTENT -->
        </div>

        @include('wine-supervisor::partials.legal-notices')

    </div>
@stop