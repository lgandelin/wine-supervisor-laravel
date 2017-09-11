@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::contact.meta_title') }}@endsection

@section('page-content')
    <div class="contact-template">

        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner" id="top">
            <h2>
                <span class="your-cellar subtitle"></span>
                <span class="title">{{ trans('wine-supervisor::contact.page_title') }}</span>
            </h2>
        </div>
        <!-- BANNER -->

        <!-- CONTACT FORM -->
        <div class="contact-form main-content container">

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

            <div class="left-content">
                <div class="page-header">
                    <h1>{{ trans('wine-supervisor::contact.page_title') }}</h1>
                    <p>{{ trans('wine-supervisor::contact.page_header') }}</p>
                </div>

                <div class="info" style="margin-left: 4.5rem;">
                    <strong style="display:block; margin-bottom: 1rem;">WineSupervisor</strong>
                    +33 (0)4 79 34 91 84
                </div>
            </div>

            <div class="page-content">
                <form action="{{ route('contact_handler') }}" method="post">

                    <div class="form-group">
                        <label for="subject">{{ trans('wine-supervisor::contact.subject') }} :</label>
                        <input type="text" name="subject" required />
                    </div>

                    <div class="form-group">
                        <label for="email">{{ trans('wine-supervisor::contact.email') }} :</label>
                        <input type="text" name="email" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">{{ trans('wine-supervisor::contact.phone') }} :</label>
                        <input type="text" name="phone" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">{{ trans('wine-supervisor::contact.message') }} :</label>
                        <textarea name="message" id="message" cols="30" rows="10"></textarea>
                    </div>

                    <input type="submit" value="{{ trans('wine-supervisor::contact.send') }}" />
                    {{ csrf_field() }}
                </form>
            </div>

        </div>
        <!-- CONTACT FORM -->

        @include('wine-supervisor::partials.legal-notices')
    </div>
@stop