@extends('wine-supervisor::default')

@section('page-title'){{ trans('wine-supervisor::user.update_account.meta_title') }}@endsection

@section('page-content')

    <div class="cellars-template">

        @include('wine-supervisor::pages.user.includes.header')

        <!-- BANNER -->
        <div class="banner">
            <h1>
                <span class="title">{{ trans('wine-supervisor::user.update_account.banner_title') }}</span>
            </h1>
        </div>
        <!-- BANNER -->

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>{{ trans('wine-supervisor::user.update_account.my_cellars.page_title') }}</h1>
                <p>{{ trans('wine-supervisor::user.update_account.my_cellars.page_header') }}</p>
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

                @if ($cellars)
                    <div class="table-list">
                        <div class="table-row">
                            <div class="table-cell table-cell-header cellar">{{ trans('wine-supervisor::user.update_account.my_cellars.table.cellar') }}</div>
                            <div class="table-cell table-cell-header status">{{ trans('wine-supervisor::user.update_account.my_cellars.table.subscription_status') }}</div>
                            <div class="table-cell table-cell-header date">{{ trans('wine-supervisor::user.update_account.my_cellars.table.expiration_date') }}</div>
                            <div class="table-cell table-cell-header type">{{ trans('wine-supervisor::user.update_account.my_cellars.table.subscription_type') }}</div>
                            {{--<div class="table-cell table-cell-header price">€</div>--}}
                            <div class="table-cell table-cell-header action">&nbsp;</div>
                        </div>

                        @foreach($cellars as $cellar)
                            <div class="table-row">
                                <div class="table-cell cellar">@if ($cellar->name){{ $cellar->name }}@endif</div>
                                <div class="table-cell status"><span class="icon status-ok" title="Votre abonnement est valide"></span></div>
                                <div class="table-cell date">@if ($cellar->subscription_end_date){{ DateTime::createFromFormat('Y-m-d H:i:s', $cellar->subscription_end_date)->format('d/m/Y') }}@else{{'&nbsp;'}}@endif</div>
                                <div class="table-cell type">
                                    @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION){{ trans('wine-supervisor::subscriptions.standard') }}
                                    @elseif ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION){{ trans('wine-supervisor::subscriptions.premium') }}
                                    @elseif ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::FREE_SUBSCRIPTION){{ trans('wine-supervisor::subscriptions.free') }}
                                    @else {{ trans('wine-supervisor::subscriptions.none') }}
                                    @endif
                                </div>
                                {{--<div class="table-cell price">
                                    @if ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::DEFAULT_SUBSCRIPTION)20€
                                    @elseif ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::PREMIUM_SUBSCRIPTION)45€
                                    @elseif ($cellar->subscription_type == Webaccess\WineSupervisorLaravel\Models\Subscription::FREE_SUBSCRIPTION)-
                                    @else -
                                    @endif
                                </div>--}}
                                <div class="table-cell action"><a href="{{ route('user_cellar_update', ['id' => $cellar->id]) }}"><button class="edit">{{ trans('wine-supervisor::generic.modify') }}</button></a></div>
                            </div>
                        @endforeach
                    </div>

                    <div class="status-legend">
                        <span class="status"><span class="icon status-ok"></span> {{ trans('wine-supervisor::subscriptions.valid_subscription') }}</span>
                        <span class="status"><span class="icon status-soon-ko"></span> {{ trans('wine-supervisor::subscriptions.soon_expired_subscription') }}</span>
                        <span class="status"><span class="icon status-ko"></span> {{ trans('wine-supervisor::subscriptions.expired_subscription') }}</span>
                    </div>
                @endif

                @if (!$user->read_only)
                    <a href="{{ route('user_cellar_create') }}" class="add">{{ trans('wine-supervisor::cellar.create_cellar_button') }}</a>
                @endif
            </div>
            <!-- PAGE CONTENT -->

        </div>

    </div>


    <div class="my-account-template" style="margin-top: 20rem;">

        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>{{ trans('wine-supervisor::user.update_account.my_account.page_title') }}</h1>
                <p>
                    {{ trans('wine-supervisor::user.update_account.my_account.page_header.1') }}<br/>
                    {{ trans('wine-supervisor::user.update_account.my_account.page_header.2') }}
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

                <form action="{{ route('user_update_account_handler') }}" method="POST">

                    <div class="form-group">
                        <label for="last_name">{{ trans('wine-supervisor::generic.last_name') }} <span class="required">*</span></label>
                        <input type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" required />
                    </div>

                    <div class="form-group">
                        <label for="first_name">{{ trans('wine-supervisor::generic.first_name') }} </label>
                        <input type="text" name="first_name" id="first_name" value="{{ $user->first_name }}" />
                    </div>

                    <div class="form-group">
                        <label for="phone">{{ trans('wine-supervisor::generic.phone') }} <span class="required">*</span></label>
                        <input type="text" name="phone" id="phone" value="{{ $user->phone }}" required />
                    </div>

                    <div class="form-group">
                        <label for="email">{{ trans('wine-supervisor::generic.email') }} <span class="required">*</span></label>
                        <input type="text" name="email" id="email" value="{{ $user->email }}" autocomplete="off" required />
                    </div>

                    <div class="form-group">
                        <label for="password">{{ trans('wine-supervisor::generic.password') }} <span class="required">*</span> <i style="display:inline-block; vertical-align: middle; margin-left: 1rem;">{{ trans('wine-supervisor::generic.password_notice') }}</i></label>
                        <input type="password" name="password" id="password" autocomplete="new-password" value="********" />
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">{{ trans('wine-supervisor::generic.password_confirmation') }} <span class="required">*</span></label>
                        <input type="password" name="password_confirm" id="password_confirm" autocomplete="new-password" value="********" />
                    </div>

                    <div class="form-group">
                        <label for="address">{{ trans('wine-supervisor::generic.address') }} <span class="required">*</span></label>
                        <input type="text" name="address" id="address" value="{{ $user->address }}" required />
                    </div>

                    <div class="form-group">
                        <label for="address2">{{ trans('wine-supervisor::generic.address_2') }}</label>
                        <input type="text" name="address2" id="address2" value="{{ $user->address2 }}" />
                    </div>

                    <div class="form-group">
                        <label for="zipcode">{{ trans('wine-supervisor::generic.zipcode') }}</label>
                        <input type="text" name="zipcode" id="zipcode" value="{{ $user->zipcode }}" />
                    </div>

                    <div class="form-group">
                        <label for="city">{{ trans('wine-supervisor::generic.city') }} <span class="required">*</span></label>
                        <input type="text" name="city" id="city" value="{{ $user->city }}" required />
                    </div>

                    <div class="form-group">
                        <label for="country">{{ trans('wine-supervisor::generic.country') }} <span class="required">*</span></label>
                        <select name="country" id="country" required>
                            @foreach (\Webaccess\WineSupervisorLaravel\Tools\CountriesTool::getCountriesList() as $key => $label)
                                <option value="{{ $key }}" @if ($user->country == $key)selected="selected"@endif @if (!$user->country && $key == 'FR')selected="selected"@endif>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="locale">{{ trans('wine-supervisor::generic.locale') }}</label>
                        <select name="locale" id="locale" required>
                            <option value="fr" @if ($user->locale == 'fr' || !$user->locale)selected="selected"@endif>Français</option>
                            <option value="en" @if ($user->locale == 'en')selected="selected"@endif>English</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="opt_in">{{ trans('wine-supervisor::user.update_account.receive_club_newsletter') }}</label>
                        <div class="radio"><input type="radio" name="opt_in" value="1" id="opt_in" @if ($user->opt_in == true || $user->opt_in === null)checked="checked"@endif /> {{ trans('wine-supervisor::generic.yes') }}</div>
                        <div class="radio"><input type="radio" name="opt_in" value="0" @if (!$user->opt_in)checked="checked"@endif /> {{ trans('wine-supervisor::generic.no') }}</div>
                    </div>

                    <i class="legend"><span class="required">*</span> : {{ trans('wine-supervisor::generic.mandatory_fields') }}</i>

                    @if (!$user->read_only)
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