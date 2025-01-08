<div class="row">
  <div class="col-md-12">
     <div class="form-group">
        <label for="title" class="font-weight-bold">Widget Page Title</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Widget Page Title" value="{{ old('title', $widget_page->title ?? '') }}">
        @if ($errors->has('title'))
          <span class="text-danger">{{ $errors->first('title') }}</span>
        @endif
     </div>
  </div>
</div>
