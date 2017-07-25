@extends('wine-supervisor::default')

@section('page-title') Mentions légales | WineSupervisor @endsection

@section('page-content')
<div class="contact-template">

    @include('wine-supervisor::pages.user.includes.header')

    <!-- BANNER -->
    <div class="banner" id="top">
        <h2>
            <span class="your-cellar subtitle"></span>
            <span class="title">Mentions légales</span>
        </h2>
    </div>
    <!-- BANNER -->

    <!-- LEGAL NOTICES -->
    <div class="legal-notices main-content container">

        <?php include base_path() . '/contents/mentions-legales/mentions-legales.html' ?>

    </div>
    <!-- LEGAL NOTICES -->

</div>
@stop