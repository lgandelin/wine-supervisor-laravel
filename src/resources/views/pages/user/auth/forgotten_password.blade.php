@extends('wine-supervisor::master')

@section('page-title') Mot de passe oublié @endsection

@section('main-content')

    <div class="container">
        <div class="login-template">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="margin-top: 5rem">
                    <div class="panel-heading">Mot de passe oublié</div>
                    <div class="panel-body">

                        @if ($message)
                            <div class="alert alert-info">
                                {{ $message }}
                            </div>
                        @endif

                        @if ($error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('forgotten_password_handler') }}">
                            <div class="form-group">
                                <label>{{ trans('wine-supervisor::login.login') }}</label>
                                <input type="login" class="form-control" name="login" value="{{ old('login') }}" />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-valid">{{ trans('wine-supervisor::login.send_new_password') }}</button>
                                <a href="{{ route('user_login') }}" title="{{ trans('wine-supervisor::generic.back') }}">{{ trans('wine-supervisor::generic.back') }}</a>
                            </div>

                            {!! csrf_field() !!}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
