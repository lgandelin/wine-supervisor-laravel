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
                                <div class="table-cell date">@if ($cellar->subscription_end_date){{ DateTime::createFromFormat('Y-m-d H:i:s', $cellar->subscription_end_date)->format('d/m/Y') }}@endif</div>
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

                @if (!$cellar->user->read_only)
                    <a href="{{ route('user_cellar_create') }}" class="add add-cellar-button">{{ trans('wine-supervisor::cellar.create_cellar_button') }}</a>
                @endif
            </div>
            <!-- PAGE CONTENT -->

        </div>

        @include('wine-supervisor::partials.legal-notices')

    </div>
@stop