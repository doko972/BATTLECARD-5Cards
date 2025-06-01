@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div >
        <h3>Show Camp</h3>

        <a href="{{ route('admin.camp.index') }}" class="btn btn-success my-1">
            Home
        </a>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                    <tr>
        <th>Name</th> 
        <td>{{ $camp->name }}</td>
</tr>
    <tr>
        <th>Color</th> 
        <td>{{ $camp->color }}</td>
</tr>
    <tr>
        <th>Description</th> 
        <td>{{ $camp->description }}</td>
</tr>
    <tr>
        <th>Is_active</th> 
        <td>
            <div class="form-check form-switch">
                <input name="is_active" disabled id="is_active" value="true" data-bs-toggle="toggle"  {{ $camp->is_active == 'true' ? 'checked' : '' }} class="form-check-input" type="checkbox" role="switch" />
            </div>
        </td>
    </tr>
	
            </tbody>
        </table>

        <div>
            <a href="{{ route('admin.camp.edit', ['id' => $camp->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i>  Edit
            </a>
        </div>
    </div>
@endsection