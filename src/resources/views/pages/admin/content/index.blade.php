@extends('wine-supervisor::default')

@section('page-title') Gestion des actualités < Administration | WineSupervisor @endsection

@section('page-content')

    @include('wine-supervisor::pages.admin.includes.header')

    <div class="content-template admin-template">

        <!-- MAIN CONTENT -->
        <div class="main-content container">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <h1>Gestion des actualités</h1>
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

                <table class="table-list less-padding">
                    <tr class="table-row">
                        <th class="table-cell table-cell-header @if ($sort_column == 'title') current-filter @endif"><a href="{{ route('admin_content_list', ['sc' => 'title', 'so' => $sort_order]) }}">Titre</a></th>
                        <th class="table-cell table-cell-header @if ($sort_column == 'publication_date' || !$sort_column) current-filter @endif"><a href="{{ route('admin_content_list', ['sc' => 'publication_date', 'so' => $sort_order]) }}">Date de publication</a></th>
                        <th class="table-cell table-cell-header">Action</th>
                    </tr>
                    @foreach ($contents as $content)
                        <tr class="table-row">
                            <td class="table-cell align-left">{{ $content->title }}</td>
                            <td class="table-cell align-left">@if ($content->publication_date){{ \DateTime::createFromFormat('Y-m-d', $content->publication_date)->format('d/m/Y') }}@endif</td>
                            <td class="table-cell align-left action" width="15%">
                                <a href="{{ route('admin_content_update', $content->id) }}"><button class="edit">Modifier</button></a>
                                <a href="{{ route('admin_content_delete_handler', $content->id) }}"><button class="delete">Supprimer</button></a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <a href="{{ route('admin_content_create') }}" class="add">Créer une actualité</a>
            </div>
            <!-- PAGE CONTENT -->

        </div>
        <!-- MAIN CONTENT -->

    </div>
@stop