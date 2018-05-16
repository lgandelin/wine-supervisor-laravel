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

                <div class="step1">
                    <h2>Etape 1 - Sélection des destinataires</h2>
                    <form action="#">
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
                    </form>
                </div>

                <div class="step2" style="display: none;">
                    <h2>Etape 2 - Sélection du contenu à envoyer</h2>

                    <form action="#">
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
                            <input type="submit" value="Valider" />
                        </div>
                    </form>
                </div>

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
                        console.log(data.content);
                        CKEDITOR.instances.text.setData(data.content.text);
                        CKEDITOR.instances.text_en.setData(data.content.text_en);
                    },
                    error: function() {
                        alert('Une erreur est survenue lors du chargement du contenu.');
                    }
                });
            });
        });
    </script>
@stop