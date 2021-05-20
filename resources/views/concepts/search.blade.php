@extends ('layouts.snac_layout')

@section ('content')
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
    <h1>Vocabulary</h1>

    <ol class="breadcrumb">
        <li><a href="{{env('APP_URL')}}/concepts/search_page">Concepts Search</a></li>
        <!-- <li>{\{data.response.concepts[0].term}}</li> -->
    </ol>

        {{-- @if (false) #(permissions.EditResources)
        @endif
        @if ($isVocabularyEditor)
        @endif --}}

        @auth
        <div class="text-center">
            {{-- <a href="{{ env('SNAC_URL') }}/vocab_administrator/add_concept" class="btn btn-success"> --}}
            <a href="{{ env('APP_URL') }}/concepts/create" class="btn btn-success">
                <i class="fa fa-fw fa-plus"></i> Add New Concept
            </a>
        </div>

        @endauth


        <concept-search></concept-search>
    @endsection
