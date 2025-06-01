    @section('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row">
    <div class="col-md-8">
        <form action="{{ isset($game) ? route('admin.game.update', ['game' => $game->id]) : route('admin.game.store') }}" method="POST" >
        @csrf
        @if(isset($game))
            @method('PUT')
        @endif    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text"  placeholder="Name ..."  name="name" value="{{ old('name', isset($game) ? $game->name : '') }}" class="form-control" id="name" aria-describedby="nameHelp" required/>

        @error('name')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <input type="text"  placeholder="Status ..."  name="status" value="{{ old('status', isset($game) ? $game->status : '') }}" class="form-control" id="status" aria-describedby="statusHelp" required/>

        @error('status')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="player1_id" class="form-label">Player1_id</label>
        <input type="text"  placeholder="Player1_id ..."  name="player1_id" value="{{ old('player1_id', isset($game) ? $game->player1_id : '') }}" class="form-control" id="player1_id" aria-describedby="player1_idHelp" required/>

        @error('player1_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="player2_id" class="form-label">Player2_id</label>
        <input type="text"  placeholder="Player2_id ..."  name="player2_id" value="{{ old('player2_id', isset($game) ? $game->player2_id : '') }}" class="form-control" id="player2_id" aria-describedby="player2_idHelp" required/>

        @error('player2_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="winner_id" class="form-label">Winner_id</label>
        <input type="text"  placeholder="Winner_id ..."  name="winner_id" value="{{ old('winner_id', isset($game) ? $game->winner_id : '') }}" class="form-control" id="winner_id" aria-describedby="winner_idHelp" required/>

        @error('winner_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="current_turn" class="form-label">Current_turn</label>
        <input type="text"  placeholder="Current_turn ..."  name="current_turn" value="{{ old('current_turn', isset($game) ? $game->current_turn : '') }}" class="form-control" id="current_turn" aria-describedby="current_turnHelp" required/>

        @error('current_turn')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="turn_number" class="form-label">Turn_number</label>
        <input type="text"  placeholder="Turn_number ..."  name="turn_number" value="{{ old('turn_number', isset($game) ? $game->turn_number : '') }}" class="form-control" id="turn_number" aria-describedby="turn_numberHelp" required/>

        @error('turn_number')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="started_at" class="form-label">Started_at</label>
        <input type="text"  placeholder="Started_at ..."  name="started_at" value="{{ old('started_at', isset($game) ? $game->started_at : '') }}" class="form-control" id="started_at" aria-describedby="started_atHelp" required/>

        @error('started_at')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="finished_at" class="form-label">Finished_at</label>
        <input type="text"  placeholder="Finished_at ..."  name="finished_at" value="{{ old('finished_at', isset($game) ? $game->finished_at : '') }}" class="form-control" id="finished_at" aria-describedby="finished_atHelp" required/>

        @error('finished_at')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="player1_id" class="form-label">Player1_id</label>
        <input type="text"  placeholder="Player1_id ..."  name="player1_id" value="{{ old('player1_id', isset($game) ? $game->player1_id : '') }}" class="form-control" id="player1_id" aria-describedby="player1_idHelp" required/>

        @error('player1_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="player2_id" class="form-label">Player2_id</label>
        <input type="text"  placeholder="Player2_id ..."  name="player2_id" value="{{ old('player2_id', isset($game) ? $game->player2_id : '') }}" class="form-control" id="player2_id" aria-describedby="player2_idHelp" required/>

        @error('player2_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="winner_id" class="form-label">Winner_id</label>
        <input type="text"  placeholder="Winner_id ..."  name="winner_id" value="{{ old('winner_id', isset($game) ? $game->winner_id : '') }}" class="form-control" id="winner_id" aria-describedby="winner_idHelp" required/>

        @error('winner_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <a href="{{ route('admin.game.index') }}" class="btn btn-danger mt-1">
        Cancel
    </a>
    <button class="btn btn-primary mt-1"> {{ isset($game) ? 'Update' : 'Create' }}</button>
 </form>
    </div>
    <div class="col-md-4">
    <a  class="btn btn-danger mt-1" href="{{ route('admin.game.index') }}">
    Cancel
</a>
<button class="btn btn-primary mt-1"> {{ isset($game) ? 'Update' : 'Create' }}</button>
    </div>
    </div>

    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>

    <script>
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach((textarea) => {
            ClassicEditor
                .create(textarea)
                .catch(error => {
                    console.error(error);
                });
        });

        $(document).ready(function() {
            $('select').select2();
        });
        function triggerFileInput(fieldId) {
            const fileInput = document.getElementById(fieldId);
            if (fileInput) {
                fileInput.click();
            }
        }

        const imageUploads = document.querySelectorAll('.imageUpload');
        imageUploads.forEach(function(imageUpload) {
            imageUpload.addEventListener('change', function(event) {
                event.preventDefault()
                const files = this.files; // Récupérer tous les fichiers sélectionnés
                console.log(files)
                if (files && files.length > 0) {
                    const previewContainer = document.getElementById('preview_' + this.id);
                    previewContainer.innerHTML = ''; // Effacer le contenu précédent

                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        if (file) {
                            const reader = new FileReader();
                            const img = document.createElement('img'); // Créer un élément img pour chaque image

                            reader.onload = function(event) {
                                img.src = event.target.result;
                                img.alt = "Prévisualisation de l'image"
                                img.style.maxWidth = '100px';
                                img.style.display = 'block';
                            }

                            reader.readAsDataURL(file);
                            previewContainer.appendChild(img); // Ajouter l'image à la prévisualisation
                            console.log({img})
                            console.log({previewContainer})
                        }
                    }
                    console.log({previewContainer})
                }
            });
        });
    </script>
    @endsection