@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::signup.user.meta_title') }}@endsection

@section('page-content')
    <div class="signup-template">

        @include('wine-supervisor::pages.user.includes.header')

        <div class="main-content container">

            <!-- STEPS -->
            <div class="steps">
                <div class="step active">
                    <span class="step-number">1</span>
                    <span class="step-title">{{ trans('wine-supervisor::signup.steps.account') }}</span>
                </div>

                <div class="step">
                    <span class="step-number">2</span>
                    <span class="step-title">{{ trans('wine-supervisor::signup.steps.cellar') }}</span>
                </div>
            </div>
            <!-- STEPS -->


            <!-- PAGE HEADER -->
            <div class="page-header" id="user_header">
                <h1>{{ trans('wine-supervisor::signup.create_account') }}</h1>
                <p>
                    {{ trans('wine-supervisor::signup.user.page_header.1') }}<br>
                    {{ trans('wine-supervisor::signup.user.page_header.2') }}<br>
                    {{ trans('wine-supervisor::signup.user.page_header.3') }}
                </p>
            </div>

            <div class="page-header" id="technician_header" style="display:none">
                <h1>{{ trans('wine-supervisor::signup.create_account') }}</h1>
                <p>
                    {{ trans('wine-supervisor::signup.technician.page_header') }}
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

                <form action="">
                    <div class="form-group">
                        <label>{{ trans('wine-supervisor::signup.you_are') }}</label>
                        <div class="radio"><input type="radio" name="user_type" value="1" checked="checked" /> {{ trans('wine-supervisor::signup.user_account') }}</div>
                        <div class="radio"><input type="radio" name="user_type" value="2"> {{ trans('wine-supervisor::signup.technician_account') }}</div>
                    </div>
                </form>

                <!-- USER FORM -->
                <form id="user_signup" action="{{ route('user_signup_handler') }}" method="post">

                    <div class="form-group">
                        <label for="first_name">{{ trans('wine-supervisor::generic.first_name') }}</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $first_name }}" />
                    </div>

                    <div class="form-group">
                        <label for="last_name">{{ trans('wine-supervisor::generic.last_name') }} <span class="required">*</span></label>
                        <input type="text" name="last_name" id="last_name" value="{{ $last_name }}" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">{{ trans('wine-supervisor::generic.phone') }} <span class="required">*</span></label>
                        <input type="text" name="phone" id="phone" value="{{ $phone }}" required />
                    </div>

                    <div class="form-group">
                        <label for="email">{{ trans('wine-supervisor::generic.email') }} <span class="required">*</span></label>
                        <input type="text" name="email" id="email" value="{{ $email }}" required />
                    </div>

                    <div class="form-group">
                        <label for="password">{{ trans('wine-supervisor::generic.password') }} <span class="required">*</span><i style="display:inline-block; vertical-align: middle; margin-left: 1rem;">{{ trans('wine-supervisor::generic.password_notice') }}</i></label>
                        <input type="password" name="password" id="password" required />
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">{{ trans('wine-supervisor::generic.password_confirmation') }} <span class="required">*</span></label>
                        <input type="password" name="password_confirm" id="password_confirm" required />
                    </div>

                    <div class="form-group">
                        <label for="address">{{ trans('wine-supervisor::generic.address') }} <span class="required">*</span></label>
                        <input type="text" name="address" id="address" value="{{ $address }}" required />
                    </div>

                    <div class="form-group">
                        <label for="address2">{{ trans('wine-supervisor::generic.address_2') }}</label>
                        <input type="text" name="address2" id="address2" value="{{ $address2 }}" />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">{{ trans('wine-supervisor::generic.zipcode') }}</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ $zipcode }}" />
                    </div>

                    <div class="form-group">
                        <label for="city">{{ trans('wine-supervisor::generic.city') }} <span class="required">*</span></label>
                        <input type="text" name="city" id="city" value="{{ $city }}" required />
                    </div>

                    <div class="form-group">
                        <label for="country">{{ trans('wine-supervisor::generic.country') }} <span class="required">*</span></label>
                        <select name="country" id="country" required>
                            @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                <option value="{{ $key }}" @if ($country == $key)selected="selected"@endif @if (!$country && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="opt_in" style="display: inline-block; margin-right: 1rem; vertical-align: middle;">{{ trans('wine-supervisor::user.update_account.receive_club_newsletter') }}</label><i>{{ trans('wine-supervisor::signup.user.club_newsletter_updatable_in_account') }}</i><br>
                        <div class="radio"><input type="radio" name="opt_in" value="1" id="opt_in" @if ($opt_in == true || $opt_in === null)checked="checked"@endif /> {{ trans('wine-supervisor::generic.yes') }}</div>
                        <div class="radio"><input type="radio" name="opt_in" value="0" @if (!$opt_in)checked="checked"@endif /> {{ trans('wine-supervisor::generic.no') }}</div>
                    </div>

                    <div class="form-group">
                        <label for=""><input type="checkbox" style="vertical-align: middle; display: inline-block;" class="cgv" /> {{ trans('wine-supervisor::signup.i_read_and_accept') }} <span class="required">*</span></label>
                        <ul style="list-style: inside">
                            <li>{{ trans('wine-supervisor::signup.the') }} <a href="http://friax.fr/download/cgv-cgu-winesupervisor/?wpdmdl=28761" target="_blank">{{ trans('wine-supervisor::signup.sales_terms') }}</a></li>
                            <li>{{ trans('wine-supervisor::signup.the') }} <a href="http://friax.fr/politique-de-confidentialite/" target="_blank">{{ trans('wine-supervisor::signup.confidentiality_declarations') }}</a></li>
                        </ul>
                    </div>

                    <i class="legend"><span class="required">*</span> : {{ trans('wine-supervisor::generic.mandatory_fields') }}</i>

                    <div class="submit-container">
                        <input type="submit" class="button red-button" value="{{ trans('wine-supervisor::generic.valid') }}" />
                    </div>
                    <input type="hidden" value="1" name="type" />
                    {{ csrf_field() }}
                </form>
                <!-- USER FORM -->


                <!-- TECHNICIAN FORM -->
                <form id="technician_signup" action="{{ route('technician_signup_handler') }}" method="post" style="display:none">

                    <div class="form-group">
                        <label for="first_name">{{ trans('wine-supervisor::generic.first_name') }}</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" />
                    </div>

                    <div class="form-group">
                        <label for="last_name">{{ trans('wine-supervisor::generic.last_name') }}</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" />
                    </div>

                    <div class="form-group">
                        <label for="company">{{ trans('wine-supervisor::technician.company_name') }} <span class="required">*</span></label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="registration">{{ trans('wine-supervisor::technician.immatriculation') }} <span class="required">*</span> <i style="display:inline-block; vertical-align: middle; margin-left: 1rem;">{{ trans('wine-supervisor::technician.immatriculation_notice') }}</i></label>
                        <input type="text" name="registration" id="registration" value="{{ old('registration') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="phone">{{ trans('wine-supervisor::generic.phone') }} <span class="required">*</span></label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="email">{{ trans('wine-supervisor::generic.email') }} <span class="required">*</span></label>
                        <input type="text" name="email" id="email" value="{{ old('email') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="password">{{ trans('wine-supervisor::generic.password') }} <span class="required">*</span><i style="display:inline-block; vertical-align: middle; margin-left: 1rem;">{{ trans('wine-supervisor::generic.password_notice') }}</i></label>
                        <input type="password" name="password" id="password" required />
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">{{ trans('wine-supervisor::generic.password_confirmation') }} <span class="required">*</span></label>
                        <input type="password" name="password_confirm" id="password_confirm" required />
                    </div>

                    <div class="form-group">
                        <label for="address">{{ trans('wine-supervisor::generic.address') }} <span class="required">*</span></label>
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

                    <div class="form-group">
                        <label for="opt_in" style="display: inline-block; margin-right: 1rem; vertical-align: middle;">{{ trans('wine-supervisor::user.update_account.receive_club_newsletter') }}</label><i>{{ trans('wine-supervisor::signup.user.club_newsletter_updatable_in_account') }}</i><br>
                        <div class="radio"><input type="radio" name="opt_in" value="1" id="opt_in" @if ($opt_in == true || $opt_in === null)checked="checked"@endif /> {{ trans('wine-supervisor::generic.yes') }}</div>
                        <div class="radio"><input type="radio" name="opt_in" value="0" @if (!$opt_in)checked="checked"@endif /> {{ trans('wine-supervisor::generic.no') }}</div>
                    </div>

                    <div class="form-group">
                        <label for=""><input type="checkbox" style="vertical-align: middle; display: inline-block;" class="cgv" /> {{ trans('wine-supervisor::signup.i_read_and_accept') }} <span class="required">*</span></label>
                        <ul style="list-style: inside">
                            <li>{{ trans('wine-supervisor::signup.the') }} <a href="http://friax.fr/download/cgv-cgu-winesupervisor/?wpdmdl=28761" target="_blank">{{ trans('wine-supervisor::signup.sales_terms') }}</a></li>
                            <li>{{ trans('wine-supervisor::signup.the') }} <a href="http://friax.fr/politique-de-confidentialite/" target="_blank">{{ trans('wine-supervisor::signup.confidentiality_declarations') }}</a></li>
                        </ul>
                    </div>

                    <i class="legend"><span class="required">*</span> : {{ trans('wine-supervisor::generic.mandatory_fields') }}</i>

                    <div class="submit-container">
                        <input type="submit" class="button red-button" value="{{ trans('wine-supervisor::generic.valid') }}" />
                    </div>

                    <input type="hidden" value="2" name="type" />
                    {{ csrf_field() }}
                </form>
                <!-- TECHNICIAN FORM -->

            </div>
            <!-- PAGE CONTENT -->
        </div>

        @include('wine-supervisor::partials.legal-notices')

    </div>

    <script>
        $(document).ready(function() {

            //User type
            $('input[name="user_type"]').change(function() {
                display_tab($(this).val());
            });

            @if (old('type'))
                $('input[name="user_type"][value="{{ old('type')}}"]').trigger('click');
            @endif

            $('.signup-template .page-content input[type="submit"]').click(function() {
                if (!$(this).closest('form').find('.cgv').is(':checked')) {
                    alert('{{ trans('wine-supervisor::signup.must_accept_cgv') }}');
                    return false;
                }
            });
        });

        function display_tab(tab) {
            if (tab == 1) {
                $('#user_signup').show();
                $('#user_header').show();
                $('#technician_signup').hide();
                $('#technician_header').hide();
                $('.steps .step').show();
            } else if (tab == 2) {
                $('#user_signup').hide();
                $('#user_header').hide();
                $('#technician_signup').show();
                $('#technician_header').show();
                $('.steps .step').hide();
            }
        }
    </script>
@stop