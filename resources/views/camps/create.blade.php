@extends('admin')

@section('content')
<div >
    <h3>Create Camp</h3>
    <a href="{{ route('admin.camp.index') }}" class="btn btn-success my-1">
            Home
    </a>
    @include('camps/campForm')
        </div>
@endsection
