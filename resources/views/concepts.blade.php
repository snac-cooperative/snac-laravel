<!-- resources/views/concepts.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->
    <div class="panel-body">
    <!-- Loop through hotels returned from controller -->
        @foreach ($concepts as $concept)
        <div class="col-sm-4">
            <div class="mb-3">
                <div class="concept-body">
                    <h5 class="concept-id">{{ $concept->id }}</h5>
                    <small class="concept-deprecated-to">{{ $concept->deprecated_to }}</small>
                    <p class="concept-deprecated">{{ $concept->deprecated }}</p>
                </div>
            </div>  
        </div>
        @endforeach
    </div>

@endsection
