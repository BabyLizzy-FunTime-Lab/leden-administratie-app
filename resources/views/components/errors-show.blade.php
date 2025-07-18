<!-- validation errors -->
@if($errors->any())
    <div class="alert alert-warning mb-0" role="alert">
        <div class="container d-flex justify-content-between">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
