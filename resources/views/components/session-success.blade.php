@if(session('success'))
    <div class="alert alert-success mb-0" role="alert">
        <div class="container">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
