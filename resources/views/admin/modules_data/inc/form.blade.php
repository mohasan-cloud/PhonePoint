@push('js')
<style type="text/css">
    .error {
        color: red;
    }
    .form-control-file {
        border: 1px solid;
    }
</style>

<script type="text/javascript">
    var thumbnail_height = "{{$module->thumbnail_height}}";
    var thumbnail_width = "{{$module->thumbnail_width}}";
</script>
@endpush

<input type="hidden" name="module_id" value="{{$module->id}}">
<input type="hidden" name="module_term" value="{{$module->term}}">
<input type="hidden" name="module_slug" value="{{$module->slug}}">
<input type="hidden" id="attached_file" <?php if(isset($module_data)){echo 'value="'.$module_data->image.'"';} ?> name="attached_file">
<input type="hidden" id="attached_files" <?php if(isset($module_data)){echo 'value="'.$module_data->images.'"';} ?> name="images">
<?php $style = ''; ?>
<?php if(in_array($module->id, array(29,31,33,35))){ $style = 'display:none'; $titleVal = $module->term; } ?>

<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('Name', 'title', ['class' => '']) !!} {!! Html::text('title', null)->class('form-control')->placeholder('Name') !!}
        </div>
    </div>

    <div class="col-md-12" style="display: none;">
        <div class="mb-3">
            {!! Html::label('term', $module->term.' Slug', ['class' => '']) !!} {!! Html::input('text', 'slug', null)->class('form-control')->id('slug')->placeholder($module->term.' Slug')->required() !!}
        </div>
    </div>

    @if($module->category && $module->multiple_category)
    <div class="col-md-12">
        <div class="mb-3">
            @php $category_ids = isset($module_data) ? explode(',', $module_data->category_ids) : null; @endphp
            {!! Html::label('Courses','category_ids', ['class' => '']) !!}
            {!! Html::select('category_ids[]', [''=>'Select Courses'] + $categories, $category_ids)->class('js-example-basic-multiple col-sm-12')->id('category_ids')->multiple() !!}

            {!! APFrmErrHelp::showErrors($errors,'category_ids') !!}
        </div>
    </div>
    @else @if($module->category)
    <?php
            $parent = App\Models\Modules::findOrFail( $module->parent_id);
            ?>
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('category', 'Select '.$parent->term, ['class' => '']) !!} {!! Html::select('category', [''=>'Select '.$parent->term] + $categories)->class('form-control')->id('category')->required() !!} {!!
            APFrmErrHelp::showErrors($errors, 'category') !!}
        </div>
    </div>
    @endif @endif @if($module->sub_category)
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label($module->term.' Sub Category','sub_category', ['class' => '']) !!}
            <span id="dd-subcategories">
                {!! Html::select('sub_category', [''=>'Select Sub Category'])->class('form-control')->id('sub_category')->required() !!}
            </span>
            {!! APFrmErrHelp::showErrors($errors, 'sub_category') !!}
        </div>
    </div>
    @endif @php $totalFields = $module->extra_fields; $arrSort = []; if ($totalFields > 0) { for ($i = 1; $i <= $totalFields; $i++) { $arrSort += getFieldAttributes($module, $i); } } uksort($arrSort, function ($a, $b) { return $a - $b; });
    $requiredArr = []; if (!empty($arrSort)) { foreach ($arrSort as $key => $sort) { list($fieldTitle, $fieldName, $fieldType, $fieldMaxLength, $fieldRequired, $fieldRequiredMessage, $fieldShow, $fieldAttr, $isRequired, $fieldCol) = $sort;
    $requiredArr[] = [ 'field' => $fieldName, 'required' => $isRequired == 'required' ? 'yes' : 'no', 'message' => $fieldRequiredMessage, ]; @endphp @php $isRequired = $isRequired == 'required' ? true : false; $placeholder = 'Enter ' .
    $fieldTitle; @endphp @if ($fieldShow)
    <div class="col-lg-{{ $module->$fieldCol }}" id="{{ $fieldName }}_div">
        <div class="mb-3">
            <label>
                Enter {{ $fieldTitle }} @if($isRequired)<span id="{{ $fieldName . '_span' }}">*</span> @endif @if($fieldTitle == 'Party Name')
                <a href="javascript:;" onclick="javascript:$('#myModal').modal('show')" style="font-size: 12px; color: red;">Add Party</a>@endif
            </label>

            @switch($fieldType) @case('select') @php if (trim($fieldTitle) == 'Invoice Status') { $dropdown = dropdown($fieldAttr); } else { $dropdown = ['' => 'Select ' . $fieldTitle] + dropdown($fieldAttr); } @endphp {!!
            Html::select($fieldName, $dropdown, null)->class('form-control')->id($fieldName)->attributeIf($isRequired, 'required', 'required')->attribute('oninvalid', "this.setCustomValidity('" . $fieldRequiredMessage .
            "')")->attribute('oninput', "this.setCustomValidity('')") !!} @break @case('auto') @php $digits = $module->$fieldMaxLength; $auto = unique_auto($digits, 'modules_data', $fieldName, $module->id); if (request()->regenerate == 1) {
            $aabb = $auto; } else { $aabb = isset($module_data) ? null : $auto; } @endphp {!! Html::number($fieldName, $aabb)->class('form-control')->id($fieldName)->placeholder($placeholder)->attributeIf($isRequired, 'required',
            'required')->attribute('maxlength', $fieldMaxLength)->attribute('oninvalid', "this.setCustomValidity('" . $fieldRequiredMessage . "')")->attribute('oninput', "this.setCustomValidity('')") !!} @break @case('checkbox') {!!
            Html::checkbox($fieldName)->id($fieldName)->class('form-check-input') !!} @break @case('file') {!! Html::file($fieldName)->class('form-control form-control-file')->id($fieldName)->attributeIf(isset($module_data) &&
            @$module_data->$fieldName, 'value', @$module_data->$fieldName)->attributeIf($isRequired, 'required', 'required')->attribute('oninvalid', "this.setCustomValidity('" . $fieldRequiredMessage . "')")->attribute('oninput',
            "this.setCustomValidity('')") !!} @if(isset($module_data) && $module_data->$fieldName)
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ asset('images/' . $module_data->$fieldName) }}" download>{{ $module_data->$fieldName }}</a> &nbsp
                    <a style="color: red;" href="{{ route('admin.modules.data.delete.file', [$module_data->id, $fieldName]) }}" onclick="return confirm('Are you sure you want to delete this file?')">
                        <i class="fa-regular fa-circle-xmark"></i>
                    </a>
                </div>
            </div>
            @endif @break @default {!! Html::$fieldType($fieldName)->class('form-control')->id($fieldName)->placeholder($placeholder)->attributeIf($isRequired, 'required', 'required')->attribute('maxlength',
            $fieldMaxLength)->attribute('oninvalid', "this.setCustomValidity('" . $fieldRequiredMessage . "')")->attribute('oninput', "this.setCustomValidity('')") !!} @endswitch
        </div>
    </div>
    @endif @php } } @endphp

    <input type="hidden" name="required_json_arr" value="{!!json_encode($requiredArr)!!}" id="required_json_arr" />

    @if($module->is_description)
    <?php
        $html = null;

    ?>
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('description', $module->term.' Description', ['class' => '']) !!} {!! Html::textarea('description', $html)->class('form-control editor1')->id('editor1')->placeholder($module->term.' Description')->required() !!}
        </div>
    </div>
    @endif @if($module->is_highlights)
    <div class="col-md-12">
        <div id="dynamic_form">
            <div class="mb-3">
                {!! Html::label('is_highlights', $module->term.' Highlights', ['class' => '']) !!}
                <div class="row">
                    <div class="col-md-10">
                        {!! Html::input('text', 'highlights')->class('form-control')->id('highlights')->placeholder($module->term.' Highlights') !!}
                    </div>
                    <div class="col-md-2">
                        <div class="button-group">
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="plus" style="font-size: 32px; height: 40px; width: 40px; border-radius: 50%;"><i class="fas fa-circle-plus"></i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" id="minus" style="font-size: 32px; height: 40px; width: 40px; border-radius: 50%;"><i class="fas fa-circle-minus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif
    @if($module->is_image)
    <div class="col-md-12">
        <div class="mb-3">
            <input type="file" name="image" id="filer_input1">
        </div>
    </div>
    @endif @if($module->is_seo)
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('meta_title', $module->term.' Meta Title', ['class' => '']) !!} {!! Html::text('meta_title')->class('form-control')->id('meta_title')->placeholder($module->term.' Meta Title') !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('meta_keywords', $module->term.' Meta Keywords', ['class' => '']) !!} {!! Html::text('meta_keywords')->class('form-control')->id('meta_keywords')->placeholder($module->term.' Meta Keywords') !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('meta_description', $module->term.' Meta Description', ['class' => '']) !!} {!! Html::textarea('meta_description')->class('form-control')->id('meta_description')->placeholder($module->term.' Meta Description')
            !!}
        </div>
    </div>
    @endif
</div>

@push('js')

@include('admin.ckeditor.index')
<script>
@if($module->sub_category)
  sub_categories(<?php echo old('sub_category', (isset($module_data)) ? $module_data->sub_category : 0); ?>);

  $(document).on('change','#category',function(){
        sub_categories(0);
  })

  function sub_categories(id){
    var category = $('#category').val();
    $.ajax({
      url: "{{route('filter-sub-categories')}}?category="+category+"&sub_category="+id,
      method: "GET",
    }).done(function(data) {
      $('#dd-subcategories').html(data);
      //$('#sub_category').select2();
    });
  }
  @endif
</script>

@endpush
