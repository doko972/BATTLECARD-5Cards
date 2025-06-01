@extends('admin')

@section('content')
    <div >
        <h3>Edit Game</h3>
        <a href="{{ route('admin.game.index') }}" class="btn btn-success my-1">
                Home
        </a>
        @include('games/gameForm', ['game' => $game])
    </div>
@endsection