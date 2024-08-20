@extends ('layouts.snac_layout')

@section ('title')
Concepts
@endsection
@section ('content')
    <h1>New concept:</h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{env('SNAC_URL')}}/vocab_administrator/dashboard">Vocabulary</a></li>
        <li class="breadcrumb-item active"> New </li>
    </ol>
    <div class="row">
        <div class="col-md-8" id="conceptForm">
                <concept-create-form
                    id="conceptCreate"
                >
                </concept-create-form>
        </div>
        <br>
    </div>
@endsection
