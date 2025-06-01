@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div >
        <h3>Show Gamedeck</h3>

        <a href="{{ route('admin.gamedeck.index') }}" class="btn btn-success my-1">
            Home
        </a>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                    <tr>
        <th>Game_id</th> 
        <td>{{ $gamedeck->game_id }}</td>
</tr>
    <tr>
        <th>Player_id</th> 
        <td>{{ $gamedeck->player_id }}</td>
</tr>
    <tr>
        <th>Card_id</th> 
        <td>{{ $gamedeck->card_id }}</td>
</tr>
    <tr>
        <th>Position</th> 
        <td>{{ $gamedeck->position }}</td>
</tr>
    <tr>
        <th>Current_hp</th> 
        <td>{{ $gamedeck->current_hp }}</td>
</tr>
    <tr>
        <th>Is_alive</th> 
        <td>
            <div class="form-check form-switch">
                <input name="is_alive" disabled id="is_alive" value="true" data-bs-toggle="toggle"  {{ $gamedeck->is_alive == 'true' ? 'checked' : '' }} class="form-check-input" type="checkbox" role="switch" />
            </div>
        </td>
    </tr>
    <tr>
        <th>Game_id</th> 
        <td>{{ $gamedeck->game_id }}</td>
</tr>
    <tr>
        <th>Player_id</th> 
        <td>{{ $gamedeck->player_id }}</td>
</tr>
    <tr>
        <th>Card_id</th> 
        <td>{{ $gamedeck->card_id }}</td>
</tr>
	
            </tbody>
        </table>

        <div>
            <a href="{{ route('admin.gamedeck.edit', ['id' => $gamedeck->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i>  Edit
            </a>
        </div>
    </div>
@endsection