@extends('wine-supervisor::master')

@section('page-title') Connexion @endsection

@section('main-content')

    <div class="container">
        <div class="login-template">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="margin-top: 5rem">
                    <div class="panel-heading">{{ trans('wine-supervisor::login.title') }}</div>
                    <div class="panel-body">

                        @if (isset($error))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('admin_login_handler') }}">

                            <div class="form-group">
                                <label>{{ trans('wine-supervisor::login.email') }}</label>
                                <input type="email" class="form-control" name="email" />
                            </div>

                            <div class="form-group">
                                <label>{{ trans('wine-supervisor::login.password') }}</label>
                                <input type="password" class="form-control" name="password" autocomplete="off" />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-valid">{{ trans('wine-supervisor::login.login') }}</button>
                            </div>

                            {!! csrf_field() !!}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
