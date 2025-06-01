@extends('admin')

@section('content')
    <div >
        <h3>Edit Card</h3>
        <a href="{{ route('admin.card.index') }}" class="btn btn-success my-1">
                Home
        </a>
        @include('cards/cardForm', ['card' => $card])
    </div>
@endsection