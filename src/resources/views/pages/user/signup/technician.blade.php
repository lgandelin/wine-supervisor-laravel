@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::signup.technician.meta_title') }}@endsection

@section('page-content')
    <div class="signup-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>{{ trans('wine-supervisor::signup.technician.page_title') }}</h1>
                <p>{{ trans('wine-supervisor::signup.technician.page_header') }}</p>
            </div>
            <!-- PAGE HEADER -->

            <!-- PAGE CONTENT -->
            <div class="page-content" style="padding-top: 6rem">

                <h2 class="subtitle">{{ trans('wine-supervisor::signup.technician.confirmation.title') }}</h2>
                <p>
                    {{ trans('wine-supervisor::signup.technician.confirmation.text_1') }}<br/><br/>
                    {{ trans('wine-supervisor::signup.technician.confirmation.text_2') }}<br/><br/>
                    {{ trans('wine-supervisor::signup.technician.confirmation.text_3') }}
                </p>

            </div>
            <!-- PAGE CONTENT -->
        </div>

        @include('wine-supervisor::partials.legal-notices')

    </div>
@stop