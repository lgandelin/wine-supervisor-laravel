@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::cellar.update.meta_title') }}@endsection

@section('page-content')

    <div class="cellar-update-template">

        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner">
            <h1>
                <span class="title">{{ trans('wine-supervisor::cellar.update.banner_title') }}</span>
            </h1>
        </div>
        <!-- BANNER -->

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>{{ trans('wine-supervisor::cellar.update.page_title') }}</h1>
                <p>
                    {{ trans('wine-supervisor::cellar.update.page_header.1') }}<br/>
                    {{ trans('wine-supervisor::cellar.update.page_header.2') }}
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

                <!-- LEFT COLUMN -->
                <div class="left-column">
                    <h2>{{ trans('wine-supervisor::cellar.winesupervisor_id') }}</h2>
                    <span class="mak">{{ $cellar->cd_cellar_id }}</span>

                    @if ($cellar->serial_number)
                        <h2>{{ trans('wine-supervisor::cellar.serial_number') }}</h2>
                        <span class="serial-number">{{ $cellar->serial_number }}</span>
                    @endif

                    @if (!$cellar->user->read_only)
                        <div class="links">
                            <a class="link" href="#">{{ trans('wine-supervisor::cellar.update.sav') }}</a>
                            <a class="link" href="#">{{ trans('wine-supervisor::generic.delete') }}</a>
                        </div>
                    @endif
                </div>
                <!-- LEFT COLUMN -->

                <!-- RIGHT COLUMN -->
                <div class="right-column">
                    <form action="{{ route('user_cellar_update_handler') }}" method="POST">
                        <div class="form-group">
                            <label for="name">{{ trans('wine-supervisor::cellar.cellar_name') }}</label>
                            <input type="text" name="name" value="{{ $cellar->name }}" />
                        </div>

                        <div class="form-group">
                            <label for="technician_id">{{ trans('wine-supervisor::cellar.technician_id') }}</label>
                            <input type="text" name="technician_id" id="technician_id" value="@if ($cellar->technician){{ $cellar->technician->technician_code }}@endif" />
                        </div>

                        <div class="form-group">
                            <label for="subscription_type">{{ trans('wine-supervisor::cellar.update.subscription_type') }} <span class="required">*</span></label>
                            <select name="subscription_type" id="subscription_type" required>
                                <option value="">{{ trans('wine-supervisor::generic.select') }}</option>
                                <option value="{{ Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION }}" @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION)selected="selected"@endif>{{ trans('wine-supervisor::subscriptions.standard') }}</option>
                                {{--<option value="{{ Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION}}" @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION)selected="selected"@endif>{{ trans('wine-supervisor::subscriptions.premium') }}</option>--}}
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="address">{{ trans('wine-supervisor::cellar.cellar_address') }} <span class="required">*</span></label>
                            <input type="text" name="address" value="{{ $cellar->address }}" required />
                        </div>

                        <div class="form-group">
                            <label for="address2">{{ trans('wine-supervisor::generic.address_2') }}</label>
                            <input type="text" name="address2" id="address2" value="{{ $cellar->address2 }}"/>
                        </div>

                        <div class="form-group">
                            <label for="zipcode">{{ trans('wine-supervisor::generic.zipcode') }}</label>
                            <input type="text" name="zipcode" id="zipcode" value="{{ $cellar->zipcode }}" />
                        </div>

                        <div class="form-group">
                            <label for="city">{{ trans('wine-supervisor::generic.city') }} <span class="required">*</span></label>
                            <input type="text" name="city" id="city" value="{{ $cellar->city }}" required />
                        </div>

                        <div class="form-group">
                            <label for="country">{{ trans('wine-supervisor::generic.country') }} <span class="required">*</span></label>
                            <select name="country" id="country" required>
                                @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                    <option value="{{ $key }}" @if ($cellar->country == $key)selected="selected"@endif>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <i class="legend"><span class="required">*</span> : {{ trans('wine-supervisor::generic.mandatory_fields') }}</i>

                        @if (!$cellar->user->read_only)
                            <div class="submit-container">
                                <input type="submit" class="button red-button" value="{{ trans('wine-supervisor::generic.valid') }}" />
                            </div>
                        @endif

                        <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
                        {{ csrf_field() }}
                    </form>
                </div>
                <!-- RIGHT COLUMN -->

            </div>
            <!-- PAGE CONTENT -->

            <a class="button red-button back-button" href="{{ route('user_update_account') }}">{{ trans('wine-supervisor::generic.back') }}</a>
        </div>

        @include('wine-supervisor::partials.legal-notices')

        <!--<h2>SAV</h2>

        <p>Si vous avez changé votre carte, veuillez renseignez ci-dessous l'adresse MAK de votre nouvelle carte.</p>

        <form action="{{ route('user_cellar_sav_handler') }}" method="POST">
            <div>
                <label for="id_ws">Nouvelle adresse MAK</label>
                <input type="text" name="id_ws" id="id_ws" />
            </div>

            <a href="{{ route('user_cellar_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
            {{ csrf_field() }}
        </form>

        <h2>Suppression</h2>

        <p>ATTENTION : Valider ce formulaire entrainera la suppression de votre cave dans le système.</p>

        <form action="{{ route('user_cellar_delete_handler') }}" method="POST">
            <div>
                <label for="reason">Raison de la suppression</label>
                <select name="reason" id="reason">
                    <option value="board_out_of_order">Carte HS</option>
                    <option value="other">Autre</option>
                </select>
            </div>

            <a href="{{ route('user_cellar_list') }}">Retour</a>
            <input type="submit" value="Valider" />
            <input type="hidden" name="cellar_id" value="{{ $cellar->id }}" />
            {{ csrf_field() }}
        </form>-->

    </div>
@stop