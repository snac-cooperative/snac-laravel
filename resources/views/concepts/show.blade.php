@extends ("layouts.snac_layout")

@section ('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <ol class="breadcrumb">
        {{-- TODO:  Rename Occupation Terms with dynamic concept category or categories   --}}
        <li class="breadcrumb-item"><a href="/concepts">Concepts</a></li>

        @if (!empty($concept->conceptCategories) and (count($concept->conceptCategories) > 0))
            <li class="breadcrumb-item active">{{ $concept->conceptCategories[0]['value']}} Terms</li>
        @endif
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
            :sources-props="{{ $concept->sources }}"
            can-edit-vocabulary="{{ json_encode($isVocabularyEditor) }}"
        >
        </concept>

        @if ( count($relations) )
            <hr>
            <h2>Relations</h2>

            <div class="relations mx-0" style="display: grid; grid-auto-flow: column; grid-auto-columns: minmax(0, 1fr); column-gap: 2rem;">
                @foreach($relations as $title => $terms)
                    <div>
                        <h3>{{ $title }}</h3>
                        @foreach($terms as $term)
                            <term-item :term="{{ $term }}"></term-item>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
