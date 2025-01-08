
<div class="row">
<div class="col-md-12">
    <div class="mb-3">
        {!! Html::label('title', 'Widget Title', ['class' => '']) !!}
        {!! Html::text('title')->class('form-control')->id('title')->placeholder('Widget Title') !!}
    </div>
</div>

     
   </div>
   <div class="row">
     <div class="col-md-12">
     <div class="mb-3">
    {!! Html::label('widget_page_id', 'Widget Page', ['class' => '']) !!}
    {!! Html::select('widget_page_id', ['' => 'Select Widget Page'] + $widget_pages)->class('form-control')->id('widget_page_id') !!}
</div>
        
      </div>
      <div class="col-md-12">
      @php
        $fields = [
            0 => 'No',
            1 => 'Yes',
        ];
    @endphp
    {!! Html::label('is_description', 'Widget Description', ['class' => '']) !!}
    {!! Html::select('is_description', $fields)->class('form-control')->id('is_description') !!}
</div>
      </div>
      
  </div>
   

  <div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('is_extra_image_title_1', 'Widget Image 1', ['class' => '']) !!}
            {!! Html::select('is_extra_image_title_1', $fields)->class('form-control')->id('is_extra_image_title_1') !!}
        </div>
    </div>
    <div class="col-md-4 image_section">
        <div class="mb-3">
            {!! Html::label('extra_image_title_1', 'Widget Image 1 Title', ['class' => '']) !!}
            {!! Html::text('extra_image_title_1')->class('form-control')->id('extra_image_title_1')->placeholder('Widget Image 1 Title') !!}
        </div>
    </div>
    <div class="col-md-4 image_section">
        <div class="mb-3">
            {!! Html::label('extra_image_1_height', 'Thumbnail Height', ['class' => '']) !!}
            {!! Html::text('extra_image_1_height')->class('form-control')->id('extra_image_1_height')->placeholder('Thumbnail Height') !!}
        </div>
    </div>
    <div class="col-md-4 image_section">
        <div class="mb-3">
            {!! Html::label('extra_image_1_width', 'Thumbnail Width', ['class' => '']) !!}
            {!! Html::text('extra_image_1_width')->class('form-control')->id('extra_image_1_width')->placeholder('Thumbnail Width') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('is_extra_image_title_2', 'Widget Image 2', ['class' => '']) !!}
            {!! Html::select('is_extra_image_title_2', $fields)->class('form-control')->id('is_extra_image_title_2') !!}
        </div>
    </div>
    <div class="col-md-4 image_section_2">
        <div class="mb-3">
            {!! Html::label('extra_image_title_2', 'Widget Image 2 Title', ['class' => '']) !!}
            {!! Html::text('extra_image_title_2')->class('form-control')->id('extra_image_title_2')->placeholder('Widget Image 2 Title') !!}
        </div>
    </div>
    <div class="col-md-4 image_section_2">
        <div class="mb-3">
            {!! Html::label('extra_image_2_height', 'Thumbnail Height', ['class' => '']) !!}
            {!! Html::text('extra_image_2_height')->class('form-control')->id('extra_image_2_height')->placeholder('Thumbnail Height') !!}
        </div>
    </div>
    <div class="col-md-4 image_section_2">
        <div class="mb-3">
            {!! Html::label('extra_image_2_width', 'Thumbnail Width', ['class' => '']) !!}
            {!! Html::text('extra_image_2_width')->class('form-control')->id('extra_image_2_width')->placeholder('Thumbnail Width') !!}
        </div>
    </div>
</div>


   
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            @php
                $extra_fields = array_combine(range(1, 19), range(1, 19));
            @endphp
            {!! Html::label('extra_fields', 'Extra Fields', ['class' => 'form-label']) !!}
            {!! Html::select('extra_fields', ['' => 'Select Extra Fields'] + $extra_fields)
                ->class('form-control')
                ->id('extra_fields') !!}
        </div>
    </div>
</div>

@for ($i = 1; $i <= 7; $i++)
    <div class="row">
        <div class="col-md-12 extra_field_" style="display: none;">
            <div class="mb-3">
                {!! Html::label('extra_field_' . $i, 'Extra Field Title ' . $i, ['class' => 'form-label']) !!}
                {!! Html::text('extra_field_' . $i)
                    ->class('form-control')
                    ->id('extra_field_' . $i)
                    ->placeholder('Extra Field Title ' . $i) !!}
            </div>
        </div>
    </div>
@endfor


	   
<div class="col-md-12">
    <div class="mb-3">
        @php
        $radio_buttons = array(
            1 => 1,
            2 => 2,
            3 => 3,
        );
        @endphp
        {!! Html::label('radio_buttons', 'Radio Buttons', ['class' => '']) !!}
        {!! Html::select('radio_buttons', [''=>'Select Radio Buttons'] + $radio_buttons)->class('form-control')->id('radio_buttons') !!}
    </div>
</div>

<div class="col-md-12 extra_button_title" style="display: none;">
    <div class="mb-3">
        {!! Html::label('radio_button_title_1', 'Radio Button Title 1', ['class' => '']) !!}
        {!! Html::text('radio_button_title_1')->class('form-control')->id('radio_button_title_1')->placeholder('Radio Button Title 1') !!}
    </div>
</div>
<div class="col-md-12 extra_button_title" style="display: none;">
    <div class="mb-3">
        {!! Html::label('radio_button_title_2', 'Radio Button Title 2', ['class' => '']) !!}
        {!! Html::text('radio_button_title_2')->class('form-control')->id('radio_button_title_2')->placeholder('Radio Button Title 2') !!}
    </div>
</div>

<div class="col-md-12 extra_button_title" style="display: none;">
    <div class="mb-3">
        {!! Html::label('radio_button_title_3', 'Radio Button Title 3', ['class' => '']) !!}
        {!! Html::text('radio_button_title_3')->class('form-control')->id('radio_button_title_3')->placeholder('Radio Button Title 3') !!}
    </div>
</div>

	   
	
  

@push('js')

<script type="text/javascript">
   // Initialize the extra fields based on the old value or the widget's value
extrafields("{{ old('extra_fields', (isset($widget) ? $widget->extra_fields : '')) }}");

// Set up the event listener for the 'change' event on the select element
$('#extra_fields').on('change', function() {
    extrafields($(this).val());
});

// Function to show the appropriate extra fields based on the selected value
function extrafields(val) {
    $('.extra_field_').hide();  // Hide all extra fields

    for (var i = 1; i <= val; i++) {
        $('#extra_field_' + i).parent().parent().show();  // Show the fields that should be visible
    }
}


    show_thumb("{{old('is_extra_image_title_1', (isset($widget))? $widget->is_extra_image_title_1:'')}}");
    $('#is_extra_image_title_1').on('change',function(){
        show_thumb($(this).val());
    })

    function show_thumb(val){
        if(val==1){
            $('.image_section').show();
        }else{
            $('.image_section').hide();
        }
    }

    show_thumb_2("{{old('is_extra_image_title_2', (isset($widget))? $widget->is_extra_image_title_2:'')}}");
    $('#is_extra_image_title_2').on('change',function(){
        show_thumb_2($(this).val());
    })

    function show_thumb_2(val){
        if(val==1){
            $('.image_section_2').show();
        }else{
            $('.image_section_2').hide();
        }
    }
	
	radio_buttons("{{old('radio_buttons', (isset($widget))? $widget->radio_buttons:'')}}");
    $('#radio_buttons').on('change',function(){
        radio_buttons($(this).val());
    })
    function radio_buttons(val){
        $('.extra_button_title').hide();
        for (var i = 1; i <= val; i++) {
            $('#radio_button_title_'+i).parent().parent().show(); 
        }
    }


</script>

@endpush