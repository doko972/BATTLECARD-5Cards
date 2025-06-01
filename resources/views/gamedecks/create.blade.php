@extends('admin')

@section('content')
<div >
    <h3>Create Gamedeck</h3>
    <a href="{{ route('admin.gamedeck.index') }}" class="btn btn-success my-1">
            Home
    </a>
    @include('gamedecks/gamedeckForm')
        </div>
@endsection
