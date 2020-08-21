@extends ("layouts.snac_layout")

@section ('content')
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
    <h1>Vocabulary: {\{ data.title }}</h1>

    <!-- {{ dump($concept['terms']) }} -->
    <ol class="breadcrumb">
        <li><a href="{{ env('SNAC_URL') }}/vocab_administrator/dashboard">Vocabulary</a></li>
        <li>{\{data.title}}</li>
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
                <h2>Relations</h2>
                <h3>Broader</h3>
                <h3>Narrower</h3>
                <h3>Related</h3>
            </div>
            <h2>SHOW Broader</h2>
            <term-item id="s" :term="{{ $concept->broader[0]->terms[0]}}"></term-item>

            <h2>Narrower</h2>



            </form>
        </div>

    </table>
@endsection
