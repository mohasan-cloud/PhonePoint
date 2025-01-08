<x-admin-layout>

    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">

                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ url('/admin/modules')}}">Modules</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Edit Module</li>
                            </ol>
                        </nav>
                    </div>

        </div>
        </div>
    <div class="container-xl px-4">
        <div class="card mb-4">
            <div class="card-body">


               {{ html()->modelForm($module, 'POST', route('admin.modules.update'))->attribute('enctype', 'multipart/form-data')->open() }}
               <input type="hidden" name="id" value="{{$module->id}}" />
               <div class="sbp-preview">
                  <div class="sbp-preview-content">
                     @include('admin.modules.inc.form')
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
</x-admin-layout>
