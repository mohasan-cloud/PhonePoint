<x-admin-layout>


    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">



        </div>
    <div class="container-xl px-4">

        <div class="card mb-4">
            <livewire:admin.common.header :title="'Update '.$module->term" :content="'Please fill all the fields to update '.$module->term" :icon="'fa-school'" :term="$module->term" :slug="url('/admin/'.$module->slug)" :button="__($module->name.' List')"/>
            <div class="card-body">
                 @if(session()->has('message.added'))
                    <div class="alert alert-{{ session('message.added') }} alert-dismissible fade show" role="alert">
                        <strong>{{__('Congratulations')}}!</strong> {!! session('message.content') !!}.
                    </div>
                @endif
               <div class="tab-content" id="nav-tabContent">
               <div class="tab-pane fade show active" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">
               {{ html()->modelForm($module_data, 'POST', route('admin.modules.data.update', $module->slug))->attribute('enctype', 'multipart/form-data')->open() }}
               <input type="hidden" name="id" value="{{$module_data->id}}" />

               <div class="sbp-preview">

                  <div class="sbp-preview-content">

                     @include('admin.modules_data.inc.form')

                     <div class="col-sm-12 col-md-12 text-center">

                        <button type="submit" class="btn btn-primary">{{__('Update')}} &nbsp <i class="fa-solid fa-arrow-right"></i></button>

                     </div>

                  </div>

               </div>
               {{ html()->form()->close() }}


               </div>


               </div>
            </div>

        </div>


    </div>
</div>
</div>

    </div>

    @push('js')

<script src="{{asset('admin_assets/assets/pages/filer/jquery.fileuploadsedit.init.js')}}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script type="text/javascript">

@if(session()->has('message.added'))





    $(document).ready(function() {



    /*--------------------------------------

         Notifications & Dialogs

     ---------------------------------------*/

    /*

     * Notifications

     */

    function notify(from, align, icon, type, animIn, animOut){

        $.growl({

            icon: icon,

            title: ' <strong>Created Successfully!</strong> ',

            message: "{!! session('message.content') !!}",

            url: ''

        },{

            element: 'body',

            type: type,

            allow_dismiss: true,

            placement: {

                from: from,

                align: align

            },

            offset: {

                x: 30,

                y: 30

            },

            spacing: 10,

            z_index: 999999,

            delay: 2500,

            timer: 1000,

            url_target: '_blank',

            mouse_over: false,

            animate: {

                enter: animIn,

                exit: animOut

            },

            icon_type: 'class',

            template: '<div data-growl="container" class="alert" role="alert">' +

            '<button type="button" class="close" data-growl="dismiss">' +

            '<span aria-hidden="true">&times;</span>' +

            '<span class="sr-only">Close</span>' +

            '</button>' +

            '<span data-growl="icon"></span>' +

            '<span data-growl="title"></span>' +

            '<span data-growl="message"></span>' +

            '<a href="#" data-growl="url"></a>' +

            '</div>'

        });

    };







        var nFrom = 'top';

        var nAlign = 'right';

        var nIcons = $(this).attr('data-icon');

        var nType = 'success';

        var nAnimIn = 'animated flipInY';

        var nAnimOut = 'animated flipOutY';



        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);



});

@endif



$("#title").keyup(function(){

        var Text = $(this).val();

        Text = Text.toLowerCase();

        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');

        $("#slug").val(Text);

});



   @if($module->is_highlights)



   $(document).ready(function() {

    var dynamic_form = $("#dynamic_form").dynamicForm("#dynamic_form", "#plus", "#minus", {

        limit: 10,

        formPrefix: "dynamic_form",

        normalizeFullForm: false,

        // JSON data which will prefill the form

        //data: [{reference_links:'ttttttt'}]



    });



    @if(isset($module_data))

    dynamic_form.inject({!!$module_data->highlights!!});

    @else

    dynamic_form.inject();

    @endif





    //dynamic_form.inject([{p_name: 'Hemant',quantity: '123',remarks: 'testing remark'},{p_name: 'Harshal',quantity: '123',remarks: 'testing remark'}]);



    $("#dynamic_form #minus").on('click', function() {

        var initDynamicId = $(this).closest('#dynamic_form').parent().find(

                "[id^='dynamic_form']")

            .length;

        if (initDynamicId === 2) {

            $(this).closest('#dynamic_form').next().find('#minus').hide();

        }

        $(this).closest('#dynamic_form').remove();

    });



    $('form').on('submit', function(event) {

        var values = {};

        $.each($('form').serializeArray(), function(i, field) {

            values[field.name] = field.value;

        });

        //console.log(values)

        //event.preventDefault();

    })

});

   @endif

</script>

@endpush

</x-admin-layout>
