@extends ("layouts.snac_layout")

@section ('content')
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
    <h1>Vocabulary: {{ $concept->terms[0]->text}}</h1>

    <!-- {{ dump($concept['terms']) }} -->
    <ol class="breadcrumb">
        <li><a href="{{ env('SNAC_URL') }}/vocab_administrator/dashboard">Vocabulary</a></li>
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
            <concept-form id="conceptShow" :concept-props="{{ $concept }}" :term-props="{{ $concept->terms}}"></concept-form>

            <div class="col-xs-8">
                @if (count($concept->broader))
                    <h3>Broader</h3>
                    @foreach($concept->broader as $broader)
                        <term-item :term="{{ $broader->terms[0]}}"></term-item>
                    @endforeach
                @endif

                @if (count($concept->narrower))
                    <h3>Narrower</h3>
                    @foreach($concept->narrower as $narrower)
                        <term-item :term="{{ $narrower->terms[0]}}"></term-item>
                    @endforeach
                @endif

                @if (count($concept->related))
                    <h3>Related</h3>
                    @foreach($concept->related as $related)
                        <term-item :term="{{ $related->terms[0]}}"></term-item>
                    @endforeach
                @endif
            </div>





            </form>
        </div>

    </table>
@endsection
