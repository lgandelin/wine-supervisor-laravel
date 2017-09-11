@extends('wine-supervisor::master')

@section('page-title'){{ trans('wine-supervisor::login.forgotten_password.meta_title') }}@endsection

@section('main-content')

    <div class="login-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>{{ trans('wine-supervisor::login.forgotten_password.page_title') }}</h1>

                <div class="login">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('forgotten_password_handler') }}">
                        <div class="input-login">
                            <input type="text" name="email" value="{{ old('email') }}" placeholder="{{ trans('wine-supervisor::login.forgotten_password.your_email') }}" />
                        </div>

                        <input type="submit" class="btn btn-valid" value="{{ trans('wine-supervisor::login.forgotten_password.send_me_a_new_password') }}" />
                        <a href="{{ route('user_login') }}" title="{{ trans('wine-supervisor::generic.back') }}" class="back-link">{{ trans('wine-supervisor::generic.back') }}</a>

                        {!! csrf_field() !!}
                    </form>
                </div>
            </div>
            <!-- PAGE HEADER -->

            @if ($message)
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif

            @if ($error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif

        </div>
    </div>

@endsection