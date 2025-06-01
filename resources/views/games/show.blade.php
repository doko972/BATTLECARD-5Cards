@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div >
        <h3>Show Game</h3>

        <a href="{{ route('admin.game.index') }}" class="btn btn-success my-1">
            Home
        </a>
        <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                    <tr>
        <th>Name</th> 
        <td>{{ $game->name }}</td>
</tr>
    <tr>
        <th>Status</th> 
        <td>{{ $game->status }}</td>
</tr>
    <tr>
        <th>Player1_id</th> 
        <td>{{ $game->player1_id }}</td>
</tr>
    <tr>
        <th>Player2_id</th> 
        <td>{{ $game->player2_id }}</td>
</tr>
    <tr>
        <th>Winner_id</th> 
        <td>{{ $game->winner_id }}</td>
</tr>
    <tr>
        <th>Current_turn</th> 
        <td>{{ $game->current_turn }}</td>
</tr>
    <tr>
        <th>Turn_number</th> 
        <td>{{ $game->turn_number }}</td>
</tr>
    <tr>
        <th>Started_at</th> 
        <td>{{ $game->started_at }}</td>
</tr>
    <tr>
        <th>Finished_at</th> 
        <td>{{ $game->finished_at }}</td>
</tr>
    <tr>
        <th>Player1_id</th> 
        <td>{{ $game->player1_id }}</td>
</tr>
    <tr>
        <th>Player2_id</th> 
        <td>{{ $game->player2_id }}</td>
</tr>
    <tr>
        <th>Winner_id</th> 
        <td>{{ $game->winner_id }}</td>
</tr>
	
            </tbody>
        </table>

        <div>
            <a href="{{ route('admin.game.edit', ['id' => $game->id]) }}" class="btn btn-primary my-1">
                <i class="fa-solid fa-pen-to-square"></i>  Edit
            </a>
        </div>
    </div>
@endsection