@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::technician.update_account.meta_title') }}@endsection

@section('page-content')

    <div class="technician-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>{{ trans('wine-supervisor::technician.update_account.page_title') }}</h1>
                <p>
                    {{ trans('wine-supervisor::technician.update_account.page_header.1') }}<br/>
                    {{ trans('wine-supervisor::technician.update_account.page_header.2') }}
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

                <form action="{{ route('technician_update_account_handler') }}" method="POST">

                    <!-- LEFT COLUMN -->
                    <div class="left-column">
                        <h2>{{ trans('wine-supervisor::technician.technician_id') }}</h2>
                        <span class="id">{{ $technician->technician_code }}</span>
                    </div>
                    <!-- LEFT COLUMN -->

                    <!-- RIGHT COLUMN -->
                    <div class="right-column">
                        <div class="form-group">
                            <label for="last_name">{{ trans('wine-supervisor::generic.last_name') }}</label>
                            <input type="text" name="last_name" id="last_name" value="{{ $technician->last_name }}" />
                        </div>

                        <div class="form-group">
                            <label for="first_name">{{ trans('wine-supervisor::generic.first_name') }}</label>
                            <input type="text" name="first_name" id="first_name" value="{{ $technician->first_name }}" />
                        </div>

                        <div class="form-group">
                            <label for="company">{{ trans('wine-supervisor::technician.company_name') }} <span class="required">*</span></label>
                            <input type="text" name="company" id="company" value="{{ $technician->company }}" required />
                        </div>

                        <div class="form-group">
                            <label for="registration">{{ trans('wine-supervisor::technician.immatriculation') }} <span class="required">*</span> <i style="display:inline-block; vertical-align: middle; margin-left: 1rem;">{{ trans('wine-supervisor::technician.immatriculation_notice') }}</i></label>
                            <input type="text" name="registration" id="registration" value="{{ $technician->registration }}" required />
                        </div>

                        <div class="form-group">
                            <label for="phone">{{ trans('wine-supervisor::generic.phone') }} <span class="required">*</span></label>
                            <input type="text" name="phone" id="phone" value="{{ $technician->phone }}" required />
                        </div>

                        <div class="form-group">
                            <label for="email">{{ trans('wine-supervisor::generic.email') }} <span class="required">*</span></label>
                            <input type="text" name="email" id="email" value="{{ $technician->email }}" required />
                        </div>

                        <div class="form-group">
                            <label for="password">{{ trans('wine-supervisor::generic.password') }} <span class="required">*</span> <i style="display:inline-block; vertical-align: middle; margin-left: 1rem;">{{ trans('wine-supervisor::generic.password_notice') }}</i></label>
                            <input type="password" name="password" id="password" value="********" />
                        </div>

                        <div class="form-group">
                            <label for="password_confirm">{{ trans('wine-supervisor::generic.password_confirmation') }} <span class="required">*</span></label>
                            <input type="password" name="password_confirm" id="password_confirm" autocomplete="new-password" value="********" />
                        </div>

                        <div class="form-group">
                            <label for="address">{{ trans('wine-supervisor::generic.address') }} <span class="required">*</span></label>
                            <input type="text" name="address" id="address" value="{{ $technician->address }}" required />
                        </div>

                        <div class="form-group">
                            <label for="address2">{{ trans('wine-supervisor::generic.address_2') }}</label>
                            <input type="text" name="address2" id="address2" value="{{ $technician->address2 }}" />
                        </div>

                        <div class="form-group">
                            <label for="zipcode">{{ trans('wine-supervisor::generic.zipcode') }}{{ trans('wine-supervisor::generic.zipcode') }}</label>
                            <input type="text" name="zipcode" id="zipcode" value="{{ $technician->zipcode }}" />
                        </div>

                        <div class="form-group">
                            <label for="city">{{ trans('wine-supervisor::generic.city') }} <span class="required">*</span></label>
                            <input type="text" name="city" id="city" value="{{ $technician->city }}" required />
                        </div>

                        <div class="form-group">
                            <label for="country">{{ trans('wine-supervisor::generic.country') }} <span class="required">*</span></label>
                            <select name="country" id="country" required>
                                @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                    <option value="{{ $key }}" @if ($technician->country == $key)selected="selected"@endif @if (!$technician->country && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <i class="legend"><span class="required">*</span> : {{ trans('wine-supervisor::generic.mandatory_fields') }}</i>
                    </div>
                    <!-- RIGHT COLUMN -->

                    @if (!$technician->read_only)
                        <div class="submit-container">
                            <input type="submit" class="button red-button" value="{{ trans('wine-supervisor::generic.valid') }}" />
                        </div>
                    @endif

                    {{ csrf_field() }}
                </form>

            </div>
            <!-- PAGE CONTENT -->

        </div>

        @include('wine-supervisor::partials.legal-notices')

    </div>

@stop