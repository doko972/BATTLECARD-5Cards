    @section('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div class="row">
    <div class="col-md-8">
        <form action="{{ isset($gamedeck) ? route('admin.gamedeck.update', ['gamedeck' => $gamedeck->id]) : route('admin.gamedeck.store') }}" method="POST" >
        @csrf
        @if(isset($gamedeck))
            @method('PUT')
        @endif    <div class="mb-3">
        <label for="game_id" class="form-label">Game_id</label>
        <input type="text"  placeholder="Game_id ..."  name="game_id" value="{{ old('game_id', isset($gamedeck) ? $gamedeck->game_id : '') }}" class="form-control" id="game_id" aria-describedby="game_idHelp" required/>

        @error('game_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="player_id" class="form-label">Player_id</label>
        <input type="text"  placeholder="Player_id ..."  name="player_id" value="{{ old('player_id', isset($gamedeck) ? $gamedeck->player_id : '') }}" class="form-control" id="player_id" aria-describedby="player_idHelp" required/>

        @error('player_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="card_id" class="form-label">Card_id</label>
        <input type="text"  placeholder="Card_id ..."  name="card_id" value="{{ old('card_id', isset($gamedeck) ? $gamedeck->card_id : '') }}" class="form-control" id="card_id" aria-describedby="card_idHelp" required/>

        @error('card_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="position" class="form-label">Position</label>
        <input type="text"  placeholder="Position ..."  name="position" value="{{ old('position', isset($gamedeck) ? $gamedeck->position : '') }}" class="form-control" id="position" aria-describedby="positionHelp" required/>

        @error('position')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="current_hp" class="form-label">Current_hp</label>
        <input type="text"  placeholder="Current_hp ..."  name="current_hp" value="{{ old('current_hp', isset($gamedeck) ? $gamedeck->current_hp : '') }}" class="form-control" id="current_hp" aria-describedby="current_hpHelp" required/>

        @error('current_hp')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3 d-flex gap-2">
        <label for="is_alive" class="form-label">Is_alive</label>
        <div class="form-check form-switch">
            <input name="is_alive" id="is_alive" value="true" data-bs-toggle="toggle"  {{ old('is_alive', isset($gamedeck) && $gamedeck->is_alive == 'true' ? 'checked' : '') }} class="form-check-input" type="checkbox" role="switch" />
        </div>
        {{-- <select class="form-control" name="is_alive" id="is_alive">
            <option value="true" {{ old('is_alive', isset($gamedeck) && $gamedeck->is_alive == 'true' ? 'selected' : '') }}>Yes</option>
            <option value="false" {{ old('is_alive', isset($gamedeck) && $gamedeck->is_alive == 'false' ? 'selected' : '') }}>No</option>
        </select> --}}

        @error('is_alive')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="game_id" class="form-label">Game_id</label>
        <input type="text"  placeholder="Game_id ..."  name="game_id" value="{{ old('game_id', isset($gamedeck) ? $gamedeck->game_id : '') }}" class="form-control" id="game_id" aria-describedby="game_idHelp" required/>

        @error('game_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="player_id" class="form-label">Player_id</label>
        <input type="text"  placeholder="Player_id ..."  name="player_id" value="{{ old('player_id', isset($gamedeck) ? $gamedeck->player_id : '') }}" class="form-control" id="player_id" aria-describedby="player_idHelp" required/>

        @error('player_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <div class="mb-3">
        <label for="card_id" class="form-label">Card_id</label>
        <input type="text"  placeholder="Card_id ..."  name="card_id" value="{{ old('card_id', isset($gamedeck) ? $gamedeck->card_id : '') }}" class="form-control" id="card_id" aria-describedby="card_idHelp" required/>

        @error('card_id')
            <div class="error text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>    <a href="{{ route('admin.gamedeck.index') }}" class="btn btn-danger mt-1">
        Cancel
    </a>
    <button class="btn btn-primary mt-1"> {{ isset($gamedeck) ? 'Update' : 'Create' }}</button>
 </form>
    </div>
    <div class="col-md-4">
    <a  class="btn btn-danger mt-1" href="{{ route('admin.gamedeck.index') }}">
    Cancel
</a>
<button class="btn btn-primary mt-1"> {{ isset($gamedeck) ? 'Update' : 'Create' }}</button>
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