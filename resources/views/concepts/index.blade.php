@extends ('layouts.snac_layout')

@section ('content')
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
    <h1>Vocabulary</h1>

    <ol class="breadcrumb">
        <li><a href="{{config('app.url')}}/concepts">Browse Concepts</a></li>
        <!-- <li>{\{data.response.concepts[0].term}}</li> -->
    </ol>

        {{-- @if (false) #(permissions.EditResources)
        @endif
        @if ($isVocabularyEditor)
        @endif --}}
    <div class="row">
        <div class="text-left"  style="margin-left:40px">
            <a href="{{ config('app.url') }}/concepts/search_page" class="btn btn-primary">
                Search for Concepts
            </a>
        </div>
        @auth
        <div class="text-center" style="margin-left:40px">
            <a href="{{ config('app.url') }}/concepts/create" class="btn btn-success">
                <i class="fa fa-fw fa-plus"></i> Add New Concept
            </a>
        </div>
        @endauth
    </div>

    <concept-list></concept-list>
@endsection
