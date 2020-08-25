@extends ('layouts.snac_layout')

@section ('content')
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
    <h1>Vocabulary: Concepts</h1>


    <ol class="breadcrumb">
        <li><a href="{{env('SNAC_URL')}}/vocab_administrator/dashboard">Vocabulary</a></li>
        <li>{\{data.title}}</li>
        <!-- <li>{\{data.response.concepts[0].term}}</li> -->
    </ol>

        @if (false) #(permissions.EditResources)
        <div class="text-center">
            <a href="{{ env('SNAC_URL') }}/vocab_administrator/add_concept" class="btn btn-success">
                <i class="fa fa-fw fa-plus"></i> Add New Concept
            </a>
        </div>
        @endif

        <div id="app">
            <div>
                <b-input-group prepend="$" append=".00">
                    <b-form-input></b-form-input>
                </b-input-group>

                <b-input-group prepend="0" append="100" class="mt-3">
                    <b-form-input type="text"></b-form-input>
                </b-input-group>
            </div>

        <h1>TABLE</h1>
        <concept-table></concept-table>
        </div>


    <!-- <table id="concept-table" class="table">
        <thead>
            <tr>
                <th>Concept</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($concepts as $concept)
          <tr><td><a href="{{ url('concepts',$concept->id) }}">{{ $concept->terms->first->text }}</a></td></tr>
        @endforeach
        </tbody>
    </table> -->
@endsection
