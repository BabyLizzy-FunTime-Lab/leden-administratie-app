@if (session('warning'))
    <div class="alert alert-warning mb-0" role="alert">
        <div class="container">
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
