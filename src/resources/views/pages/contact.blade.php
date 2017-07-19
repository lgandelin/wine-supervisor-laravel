@extends('wine-supervisor::default')

@section('page-title') Votre cave, accessible partout | WineSupervisor @endsection

@section('page-content')
    <div class="contact-template">

        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner" id="top">
            <h2>
                <span class="your-cellar subtitle"></span>
                <span class="title">Nous contacter</span>
            </h2>
        </div>
        <!-- BANNER -->

        <!-- CONTACT FORM -->
        <div class="contact-form main-content container">

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

            <div class="page-header">
                <h1>Nous contacter</h1>
                <p>N'hésitez pas à nous contacter via ce formulaire pour n'importe quelle demande.</p>
            </div>

            <div class="page-content">
                <form action="{{ route('contact_handler') }}" method="post">

                    <div class="form-group">
                        <label for="subject">Sujet :</label>
                        <input type="text" name="subject" required />
                    </div>

                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="text" name="email" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone :</label>
                        <input type="text" name="phone" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">Message :</label>
                        <textarea name="message" id="message" cols="30" rows="10"></textarea>
                    </div>

                    <input type="submit" value="Envoyer" />
                    {{ csrf_field() }}
                </form>
            </div>

        </div>
        <!-- CONTACT FORM -->

        @include('wine-supervisor::partials.legal-notices')
    </div>
@stop