@extends('wine-supervisor::default')

@section('page-title')Mon compte | WineSupervisor @endsection

@section('page-content')

    <div class="cellars-template">

        @include('wine-supervisor::pages.user.includes.header')

                <!-- BANNER -->
        <div class="banner">
            <h1>
                <span class="subtitle">Mes caves</span>
                <span class="title">Accessibles partout</span>
            </h1>
        </div>
        <!-- BANNER -->

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Mes caves</h1>
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

                @if ($cellars)
                    <div class="table-list">
                        <div class="table-row">
                            <div class="table-cell table-cell-header cellar">Cave</div>
                            <div class="table-cell table-cell-header status">Statut abonnement</div>
                            <div class="table-cell table-cell-header date">Date d'expiration</div>
                            <div class="table-cell table-cell-header type">Type d'abonnement</div>
                            <div class="table-cell table-cell-header price">€</div>
                            <div class="table-cell table-cell-header action">&nbsp;</div>
                        </div>

                        @foreach($cellars as $cellar)
                            <div class="table-row">
                                <div class="table-cell cellar">@if ($cellar->name){{ $cellar->name }}@endif</div>
                                <div class="table-cell status"><span class="icon status-ok"></span></div>
                                <div class="table-cell date">12/03/2019</div>
                                <div class="table-cell type">
                                    @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION)Standard
                                    @elseif ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION)Premium
                                    @elseif ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::FREE_SUBSCRIPTION)Gratuit
                                    @else Aucun
                                    @endif
                                </div>
                                <div class="table-cell price">
                                    @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION)20€
                                    @elseif ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION)45€
                                    @elseif ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::FREE_SUBSCRIPTION)-
                                    @else -
                                    @endif
                                </div>
                                <div class="table-cell action"><a href="{{ route('user_cellar_update', ['id' => $cellar->id]) }}"><button class="edit">Modifier</button></a></div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <a href="{{ route('user_cellar_create') }}" class="add">{{ trans('wine-supervisor::cellar.create_cellar_button') }}</a>
            </div>
            <!-- PAGE CONTENT -->

        </div>

    </div>


    <div class="my-account-template" style="margin-top: 20rem;">

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

                <form action="{{ route('user_update_account_handler') }}" method="POST">

                    <div class="form-group">
                        <label for="last_name">Nom</label>
                        <input type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" />
                    </div>

                    <div class="form-group">
                        <label for="first_name">Prénom</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $user->first_name }}"/>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="{{ $user->email }}" autocomplete="off" />
                    </div>

                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" name="login" id="login" value="{{ $user->login }}" autocomplete="off" />
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" autocomplete="new-password" />
                        <i>Laisser vide pour ne pas modifier le mot de passe</i>
                    </div>

                    <div class="form-group">
                        <label for="opt_in">Infos Club</label>
                        <div class="radio"><input type="radio" name="opt_in" value="1" id="opt_in" @if ($user->opt_in == true || $user->opt_in === null)checked="checked"@endif /> Oui</div>
                        <div class="radio"><input type="radio" name="opt_in" value="0" @if (!$user->opt_in)checked="checked"@endif /> Non</div>
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