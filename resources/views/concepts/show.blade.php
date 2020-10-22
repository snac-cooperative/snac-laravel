@extends ("layouts.snac_layout")

@section ('content')
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
    {{-- <h1>Term: {{ $concept->terms[0]->text}}</h1> --}}

    <!-- {{ dump($concept['terms']) }} -->
    <ol class="breadcrumb">
        {{-- TEST --}}
        {{-- TODO:  Rename Occupation Terms with dynamic concept category or categories   --}}
        <li class="breadcrumb-item"><a href="{{ env('SNAC_URL') }}/vocab_administrator/dashboard">Concepts</a></li>

        <li class="breadcrumb-item active"><a href="{{ env('SNAC_URL') }}/vocab_administrator/dashboard"> {{ $concept->conceptCategories[0]['value']}} Terms</a></li>
        <!-- <li>{\{data.response.concepts[0].term}}</li> -->
    </ol>

        @if (false) #permissions.EditResources
        <div class="text-center">
            <a href="{{ env('SNAC_URL') }}/vocab_administrator/add_concept" class="btn btn-success">
                <i class="fa fa-fw fa-plus"></i> Add New Concept
            </a>
        </div>
        @endif
        <div id="conceptShow" data-concept="$concept"></div>

        <div id="app">
            <form v-on:submit.prevent action="index.html" method="post">
                <concept-form
                    id="conceptShow"
                    :concept-props="{{ $concept }}"
                    :term-props="{{ $concept->terms}}"
                    :sources-props="{{ $concept->sources}}"
                >
                </concept-form>

                <br>
                <h5>Category: {{ $concept->conceptCategories[0]['value']}}</h5>

                <div class="form-group">
                    <h2>Relations</h2>
                    <div class="mt-3">
                        <b-button variant="info"><i class="fa fa-plus"></i> Add Relationship</b-button>
                    </div>


                </div>

                <div class="row">
                    @if (count($concept->broader))
                        <div class="col-xs-8" style="width:50%">
                            <h3>Broader</h3>
                            @foreach($concept->broader as $broader)
                                <term-item :term="{{ $broader->terms[0]}}"></term-item>
                            @endforeach
                        </div>
                    @endif

                    @if (count($concept->narrower))
                        <div class="col-xs-8" style="width:50%">
                            <h3>Narrower</h3>
                            @foreach($concept->narrower as $narrower)
                                <term-item :term="{{ $narrower->terms[0]}}"></term-item>
                            @endforeach
                        </div>
                    @endif

                    @if (count($concept->related))
                        <div class="col-xs-8" style="width:50%">
                            <h3>Related</h3>
                            @foreach($concept->related as $related)
                                <term-item :term="{{ $related->terms[0]}}"></term-item>
                            @endforeach
                        </div>
                    @endif
                </div>
            </form>
        </div>

    </table>
@endsection
