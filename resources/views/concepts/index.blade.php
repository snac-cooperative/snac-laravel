@extends ('layouts.snac_layout')

@section ('content')
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
  <div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a class="" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
    </a>

    </div>
    <h1>Vocabulary: {\{ data.title }}</h1>

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
    <concept-list></concept-list>
@endsection
