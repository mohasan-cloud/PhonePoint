<x-admin-layout>
   <div class="container-xl px-4">
      <div class="card mb-4">
         <livewire:admin.common.header :title="$module->name.' List'" :content="'List of all '.$module->name.' are below'" :icon="'fa-school'" :term="$module->term" :slug="url('/admin/'.$module->slug)" :button="__($module->term.' List')"/>
         <div class="card-body">
            <div class="tab-content" id="nav-tabContent">
               <div class="tab-pane fade show active" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">
                  {{ html()->form('POST', route('admin.modules.data.store', $module->slug))->open() }} 
                     <div class="sbp-preview">
                        <div class="sbp-preview-content">
                           @include('admin.modules_data.inc.form')
                           <div class="col-sm-12 col-md-12 text-center">
                              <button type="submit" class="btn btn-primary w-100">{{__('Create')}} &nbsp <i class="fa-solid fa-arrow-right"></i></button>
                           </div>
                        </div>
                     </div>
               </div>
               {{ html()->form()->close() }}
            </div>
         </div>
      </div>
   </div>
   @push('js')
   <script>
      var width = 120;
      var hight = 120;
   </script>
   <script src="{{asset('admin_assets/assets/pages/filer/jquery.fileuploads.init.js')}}" type="text/javascript"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script type="text/javascript">
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
      
          dynamic_form.inject({!!@$module_data->highlights!!});
      
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