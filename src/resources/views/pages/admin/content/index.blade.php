@extends('wine-supervisor::default')

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="content-template admin-template">

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

        <h1>Gestion des contenus</h1>

        <table>
            <tr>
                <th>Titre</th>
                <th>URI</th>
                <th>Date de création</th>
                <th>Date de mise à jour</th>
                <th>Action</th>
            </tr>
            @foreach ($contents as $content)
                <tr>
                    <td>{{ $content->title }}</td>
                    <td>{{ $content->slug }}</td>
                    <td>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $content->created_at)->format('d/m/Y H:i:s') }}</td>
                    <td>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $content->updated_at)->format('d/m/Y H:i:s') }}</td>
                    <td><a href="{{ route('admin_content_update', $content->id) }}">Modifier</a></td>
                    <td><a href="{{ route('admin_content_delete_handler', $content->id) }}">Supprimer</a></td>
                </tr>
            @endforeach
        </table>

        <a href="{{ route('admin_content_create') }}">Créer un contenu</a><br/>
    </div>
@stop