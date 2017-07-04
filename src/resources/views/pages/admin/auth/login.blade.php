@extends('wine-supervisor::master')

@section('page-title') Connexion @endsection

@section('main-content')

    <div class="login-template">

        @include('wine-supervisor::pages.admin.includes.header')

        <div class="main-content container">

            @if (isset($error))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Se connecter</h1>

                <div class="login" style="overflow: hidden;">
                    <form class="login form-horizontal" role="form" method="POST" action="{{ route('admin_login_handler') }}">
                        <div class="input-login">
                            <input type="text" class="form-control" name="email" />
                        </div>

                        <div class="input-password">
                            <input type="password" class="form-control" name="password" autocomplete="off" />
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-valid" value="{{ trans('wine-supervisor::login.login') }}" />
                        </div>

                        {!! csrf_field() !!}
                    </form>
                </div>
            </div>
            <!-- PAGE HEADER -->

        </div>
    </div>

@endsection
