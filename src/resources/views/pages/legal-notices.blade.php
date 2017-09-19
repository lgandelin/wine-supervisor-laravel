@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::legal_notices.meta_title') }}@endsection

@section('page-content')
<div class="contact-template">

    @include('wine-supervisor::pages.user.includes.header')

    <!-- BANNER -->
    <div class="banner" id="top">
        <h2>
            <span class="your-cellar subtitle"></span>
            <span class="title">{{ trans('wine-supervisor::legal_notices.page_title') }}</span>
        </h2>
    </div>
    <!-- BANNER -->

    <!-- LEGAL NOTICES -->
    <div class="legal-notices main-content container">

        <?php include base_path() . '/contents/' . App::getLocale() . '/mentions-legales/mentions-legales.html' ?>

    </div>
    <!-- LEGAL NOTICES -->

</div>
@stop