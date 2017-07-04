@extends('wine-supervisor::default')

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="guest-template">

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

        <h1>Gestion des invités</h1>

        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Login</th>
                <th>Date de début d'accès</th>
                <th>Date de fin d'accès</th>
                <th>Action</th>
            </tr>
            @foreach ($guests as $guest)
                <tr>
                    <td>{{ $guest->last_name }}</td>
                    <td>{{ $guest->first_name }}</td>
                    <td><a href="mailto:{{ $guest->email }}">{{ $guest->email }}</a></td>
                    <td>{{ $guest->login }}</td>
                    <td>{{ \DateTime::createFromFormat('Y-m-d', $guest->access_start_date)->format('d/m/Y') }}</td>
                    <td>{{ \DateTime::createFromFormat('Y-m-d', $guest->access_end_date)->format('d/m/Y') }}</td>
                    <td><a href="{{ route('admin_guest_update', $guest->id) }}">Modifier</a></td>
                    <td><a href="{{ route('admin_guest_delete_handler', $guest->id) }}">Supprimer</a></td>
                </tr>
            @endforeach
        </table>

        <a href="{{ route('admin_guest_create') }}">Créer un invité</a><br/>
    </div>
@stop