@extends ('layouts.snac_layout')

@section ('title')
Concepts
@endsection
@section ('content')
    <h1>New concept:</h1>

    <ol class="breadcrumb">
        <li><a href="{{env('SNAC_URL')}}/vocab_administrator/dashboard">Vocabulary</a></li>
        <li>New</li>
    </ol>
    <div class="row">
      <div class="col-md-8" id="conceptForm"></div>
      <br>
    </div>
@endsection
