<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="viewport" content="width=1200">
    @if (env('META_ROBOTS_NO_INDEX'))<meta name="robots" content="noindex, nofollow">@endif
    <title>@yield('page-title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" id="cookiebanner" src="{{ asset('js/vendor/cookiebanner.min.js') }}" data-position="top" data-fg="#ffffff" data-bg="#333" data-link="#fff" data-moreinfo="http://www.cnil.fr/vos-obligations/sites-web-cookies-et-autres-traceurs/que-dit-la-loi/" data-message="Nous utilisons des cookies pour vous garantir une meilleure expérience sur notre site. Si vous continuez à utiliser ce dernier, nous considérerons que vous acceptez l'utilisation de cookies. Le sommelier vous conseille une bouteille de rouge pour les accompagner." data-linkmsg="En savoir plus"></script>

</head>
<body>
