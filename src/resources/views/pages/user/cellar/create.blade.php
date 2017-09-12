@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::cellar.create.meta_title') }}@endsection

@section('page-content')

    <div class="cellar-create-template">

        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner">
            <h1>
                <span class="title">{{ trans('wine-supervisor::cellar.create.banner_title') }}</span>
            </h1>
        </div>
        <!-- BANNER -->

        <div class="main-content container">

             <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>{{ trans('wine-supervisor::cellar.create.page_title') }}</h1>
                <p>
                    {{ trans('wine-supervisor::cellar.create.page_header.1') }}<br/>
                    {{ trans('wine-supervisor::cellar.create.page_header.2') }}<br/>
                    {{ trans('wine-supervisor::cellar.create.page_header.3') }}
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

            <form action="{{ route('user_cellar_create_handler') }}" method="POST">

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
                    <label for="serial_number">{{ trans('wine-supervisor::cellar.serial_number') }}</label>
                    <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" />
                </div>

                <div class="form-group">
                    <label for="technician_id">{{ trans('wine-supervisor::cellar.technician_id') }}</label>
                    <input type="text" name="technician_id" id="technician_id" value="{{ old('technician_id') }}" />
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
                    <select name="country" id="country" required>
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

        <a class="button red-button back-button" href="{{ route('user_update_account') }}">{{ trans('wine-supervisor::generic.back') }}</a>

    </div>
@stop