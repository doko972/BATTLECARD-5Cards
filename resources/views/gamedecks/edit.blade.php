@extends('admin')

@section('content')
    <div >
        <h3>Edit Gamedeck</h3>
        <a href="{{ route('admin.gamedeck.index') }}" class="btn btn-success my-1">
                Home
        </a>
        @include('gamedecks/gamedeckForm', ['gamedeck' => $gamedeck])
    </div>
@endsection