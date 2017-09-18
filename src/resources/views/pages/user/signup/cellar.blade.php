@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::signup.meta_title') }}@endsection

@section('page-content')
    <div class="signup-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            <!-- STEPS -->
            <div class="steps">
                <div class="step">
                    <span class="step-number">1</span>
                    <span class="step-title">{{ trans('wine-supervisor::signup.steps.account') }}</span>
                </div>

                <div class="step active">
                    <span class="step-number">2</span>
                    <span class="step-title">{{ trans('wine-supervisor::signup.steps.cellar') }}</span>
                </div>
            </div>
            <!-- STEPS -->


            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>{{ trans('wine-supervisor::signup.page_title') }}</h1>
                <p>
                    {{ trans('wine-supervisor::signup.page_header.1') }}<br>
                    {{ trans('wine-supervisor::signup.page_header.2') }}<br>
                    {{ trans('wine-supervisor::signup.page_header.3') }}
                </p>
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

                <form action="{{ route('user_signup_cellar_handler') }}" method="post">

                    <div class="form-group">
                        <label for="name">{{ trans('wine-supervisor::cellar.cellar_name') }}</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" />
                    </div>

                    <div class="form-group">
                        <label for="cd_ws_id">{{ trans('wine-supervisor::cellar.winesupervisor_id') }} <span class="required">*</span></label>
                        <input type="text" name="cd_ws_id" id="cd_ws_id" value="{{ old('cd_ws_id') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="activation_code">{{ trans('wine-supervisor::cellar.activation_code') }} <span class="required">*</span></label>
                        <input type="text" name="activation_code" id="activation_code" value="{{ old('activation_code') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="id_ws">{{ trans('wine-supervisor::cellar.technician_id') }}</label>
                        <input type="text" name="technician_id" id="technician_id" value="{{ old('technician_id') }}" />
                    </div>

                    <div class="form-group">
                        <label for="serial_number">{{ trans('wine-supervisor::cellar.serial_number') }}</label>
                        <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" />
                    </div>

                    <div class="form-group">
                        <label for="address">{{ trans('wine-supervisor::cellar.cellar_address') }} <span class="required">*</span></label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="address2">{{ trans('wine-supervisor::generic.address_2') }}</label>
                        <input type="text" name="address2" id="address2" value="{{ old('address2') }}" />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">{{ trans('wine-supervisor::generic.zipcode') }}</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}" />
                    </div>

                    <div class="form-group">
                        <label for="city">{{ trans('wine-supervisor::generic.city') }} <span class="required">*</span></label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="country">{{ trans('wine-supervisor::generic.country') }} <span class="required">*</span></label>
                        <select name="country" id="country">
                            @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                <option value="{{ $key }}" @if (old('country') == $key)selected="selected"@endif @if (!old('country') && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <i class="legend"><span class="required">*</span> : {{ trans('wine-supervisor::generic.mandatory_fields') }}</i>

                    <div class="submit-container">
                        <input type="submit" class="button red-button" value="{{ trans('wine-supervisor::generic.valid') }}" />
                    </div>

                    {{ csrf_field() }}
                </form>

            </div>
            <!-- PAGE CONTENT -->

            <a class="button red-button back-button" href="{{ route('user_signup') }}">{{ trans('wine-supervisor::generic.back') }}</a>
        </div>

        @include('wine-supervisor::partials.legal-notices')

    </div>
@stop