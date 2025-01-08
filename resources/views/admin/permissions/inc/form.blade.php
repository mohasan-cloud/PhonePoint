<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="mb-3">
            <label for="name" class="form-label">Permission Name</label>
            <input type="text" value='{{$permission->name}}' name="name"  id="name" class="form-control" placeholder="Permission Name">
            <!-- Replace with error handling if necessary -->
            @if ($errors->has('name'))
                <div class="text-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>
    </div>
</div>
