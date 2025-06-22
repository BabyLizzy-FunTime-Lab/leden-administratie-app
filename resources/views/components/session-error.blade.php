@if (session('error'))
    <div class="alert alert-danger mb-0" role="alert">
        <div class="container">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
