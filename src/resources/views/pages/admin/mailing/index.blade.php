@extends('wine-supervisor::default')

@section('page-name') Mailing < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="mailing-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Mailing</h1>
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

                    <div class="step1">
                        <h2>Etape 1 - Sélection des destinataires</h2>
                        <h3 style="font-weight:bold; font-size: 2rem; margin-bottom: 2rem;">Utilisateurs</h3>
                        <div class="form-group">
                            <label for="text">Type d'abonnement :
                            <input type="checkbox" name="user_filter_standard" value="standard" /> {{ trans('wine-supervisor::subscriptions.standard') }}
                            <input type="checkbox" name="user_filter_premium" value="premium" /> {{ trans('wine-supervisor::subscriptions.premium') }}
                            <input type="checkbox" name="user_filter_free" value="free" /> {{ trans('wine-supervisor::subscriptions.free') }}
                            </label>
                        </div>

                        <h3 style="font-weight:bold; font-size: 2rem; margin-bottom: 2rem;">Installateurs</h3>
                        <div class="form-group">
                            <label for="text">Compte rattaché à une cave client :
                            <input type="checkbox" name="technician_filter_cellar_yes" value="yes" /> Oui
                            <input type="checkbox" name="technician_filter_cellar_no" value="no" /> Non
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="text">Statut du compte activé :
                            <input type="checkbox" name="technician_filter_status_yes" value="yes" /> Oui
                            <input type="checkbox" name="technician_filter_status_no" value="no" /> Non
                            </label>
                        </div>

                        <h3 style="font-weight:bold; font-size: 2rem; margin-bottom: 2rem;">Invités</h3>
                        <div class="form-group">
                            <label for="text">Date d'accès vente valide :
                            <input type="checkbox" name="guest_filter_access_yes" value="yes" /> Oui
                            <input type="checkbox" name="guest_filter_access_no" value="no" /> Non
                            </label>
                        </div>

                        <div class="form-group" style="overflow: hidden; margin-bottom: 5rem">
                            <input type="submit" value="Valider" id="submit-step1" />
                        </div>
                    </div>

                    <div class="step2" style="display: none;">
                        <h2>Etape 2 - Sélection du contenu à envoyer</h2>

                        <h3 style="font-weight:bold; font-size: 2rem; margin-bottom: 2rem;">Actualités</h3>
                        <p style="font-style: italic; color: #555">Remarque : cliquer sur une actualité remplacera le contenu dans les zones de texte ci-dessous</p>

                        <div class="form-group news-list" style="padding-left: 2rem; margin-bottom: 3rem">
                            @foreach ($news_list as $news)
                                <p><input type="radio" name="news" data-id="{{ $news->id }}" /> {{ $news->title }}</p>
                            @endforeach
                        </div>

                        <h3 style="font-weight:bold; font-size: 2rem; margin-bottom: 2rem;">Contenu</h3>
                        <div class="form-group">
                            <label for="text">Texte <img class="lang-flag" src="{{ asset('img/generic/flags/fr.jpg') }}" width="25" height="20" /></label>
                            <textarea class="editor" name="text" id="text"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="text_en">Texte <img class="lang-flag" src="{{ asset('img/generic/flags/en.jpg') }}" width="25" height="20" /></label>
                            <textarea class="editor" name="text_en" id="text_en"></textarea>
                        </div>

                        <div class="form-group" style="overflow: hidden; margin-bottom: 5rem">
                            <a href="#" class="back-step1" style="margin-top:2rem">Retour</a>
                            <input type="submit" value="Valider" id="submit-step2" />
                        </div>

                    </div>

                    <div class="step3" style="display: none">
                        <h2>Etape 3 - Vérification avant envoi</h2>

                        <div class="form-group">
                            <label for="emails">Adresses emails</label>
                            <textarea name="emails" id="emails" cols="30" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="text">Texte <img class="lang-flag" src="{{ asset('img/generic/flags/fr.jpg') }}" width="25" height="20" /></label>
                            <div id="text_field"></div>
                        </div>

                        <div class="form-group">
                            <label for="text_en">Texte <img class="lang-flag" src="{{ asset('img/generic/flags/en.jpg') }}" width="25" height="20" /></label>
                            <div id="text_en_field"></div>
                        </div>

                        <div class="form-group">
                            <label for="test_email">Email de test</label>
                            <input id="test_email" type="text" style="width:50%;" />
                            <input type="submit" value="Envoyer" id="send-test-email" style="background:#45cc3e; float:none; display: inline-block; margin-left: 2%"/>
                        </div>

                        <div class="form-group" style="overflow: hidden; margin-top: 5rem; margin-bottom: 5rem; clear:both;">
                            <a href="#" class="back-step2" style="display: inline-block; margin-top:2rem">Retour</a>
                            <input type="submit" value="Valider" id="submit-step2" />
                        </div>

                    </div>
                </form>

            </div>
            <!-- PAGE CONTENT -->
            {{ csrf_field() }}

        </div>
        <!-- MAIN CONTENT -->

    </div>

    <script>
        $(document).ready(function() {
            CKEDITOR.replace( 'text' );
            CKEDITOR.replace( 'text_en' );

            $('#submit-step1').click(function(e) {
                e.preventDefault();

                var filters = {
                    user_filter_standard: $('.step1 input[name="user_filter_standard"]').is(':checked'),
                    user_filter_premium: $('.step1 input[name="user_filter_premium"]').is(':checked'),
                    user_filter_free: $('.step1 input[name="user_filter_free"]').is(':checked'),
                    technician_filter_cellar_yes: $('.step1 input[name="technician_filter_cellar_yes"]').is(':checked'),
                    technician_filter_cellar_no: $('.step1 input[name="technician_filter_cellar_no"]').is(':checked'),
                    technician_filter_status_yes: $('.step1 input[name="technician_filter_status_yes"]').is(':checked'),
                    technician_filter_status_no: $('.step1 input[name="technician_filter_status_no"]').is(':checked'),
                    guest_filter_access_yes: $('.step1 input[name="guest_filter_access_yes"]').is(':checked'),
                    guest_filter_access_no: $('.step1 input[name="guest_filter_access_no"]').is(':checked'),
                };

                $.ajax({
                    url: "{{ route('admin_mailing_get_emails') }}",
                    data: {
                        filters: filters,
                        _token: $('input[name="_token"]').val(),
                    },
                    type: 'post',
                    success: function(data) {
                        $('.step1').hide();
                        $('.step2').show();

                        for (var i in data.emails) {
                            $('#emails').val($('#emails').val() + data.emails[i] + "\n");
                        }
                    },
                    error: function() {
                        alert('Une erreur est survenue lors du chargement des adresses email.');
                    }
                });
            });

            $('.news-list input[name="news"]').click(function() {
                var news_id = $(this).attr('data-id');

                $.ajax({
                    url: "{{ route('admin_content_get', ['uuid' => '']) }}/" + news_id,
                    data: {
                        news_id: news_id
                    },
                    type: 'get',
                    success: function(data) {
                        CKEDITOR.instances.text.setData(data.content.text);
                        CKEDITOR.instances.text_en.setData(data.content.text_en);
                    },
                    error: function() {
                        alert('Une erreur est survenue lors du chargement du contenu.');
                    }
                });
            });

            $('#submit-step2').click(function(e) {
                e.preventDefault();

                $('.step1').hide();
                $('.step2').hide();
                $('.step3').show();

                $('#text_field').html(CKEDITOR.instances.text.getData());
                $('#text_en_field').html(CKEDITOR.instances.text_en.getData());
            });

            $('.back-step1').click(function(e) {
                e.preventDefault();

                $('.step1').show();
                $('.step2').hide();
                $('.step3').hide();
            });

            $('.back-step2').click(function(e) {
                e.preventDefault();

                $('.step1').hide();
                $('.step2').show();
                $('.step3').hide();
            });

            $('#send-test-email').click(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('admin_mailing_send_test_email') }}",
                    data: {
                        "email": $('#test_email').val(),
                        "text": CKEDITOR.instances.text.getData(),
                        "text_en": CKEDITOR.instances.text_en.getData(),
                        _token: $('input[name="_token"]').val(),
                    },
                    type: 'post',
                    success: function(data) {
                        alert('Email de test envoyé');
                    },
                    error: function() {
                        alert('Une erreur est survenue lors de l\'envoi de l\'email de test');
                    }
                });
            });
        });
    </script>
@stop