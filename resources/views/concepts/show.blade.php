@extends ("layouts.snac_layout")

@section ('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/concepts">Concepts</a></li>
    </ol>

    @if (false) #permissions.EditResources
        <div class="text-center">
            <a href="{{ env('SNAC_URL') }}/vocab_administrator/add_concept" class="btn btn-success">
                <i class="fa fa-fw fa-plus"></i> Add New Concept
            </a>
        </div>
    @endif

    <div id="concept" data-concept="$concept"></div>

    <div id="app">
        <concept
            id="concept"
            :concept-props="{{ $concept }}"
            :term-props="{{ $concept->terms }}"
            :categories-props="{{ $concept->conceptCategories }}"
            :sources-props="{{ $concept->sources }}"
            can-edit-vocabulary="{{ json_encode($isVocabularyEditor) }}"
        >
        </concept>
    </div>
@endsection
