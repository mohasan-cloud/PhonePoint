
<x-admin-layout>

<div class="pcoded-content">
   <div class="pcoded-inner-content">
      <!-- Main-body start -->
      <div class="main-body">
         <div class="page-wrapper">
            <!-- Page header start -->
            <div class="page-header">
               <div class="page-header-title">
                  <h4>{{__('Basic Widget Inputs')}}</h4>
               </div>
               <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                     <li class="breadcrumb-item">
                        <a href="{{url('/admin')}}">
                        <i class="icofont icofont-home"></i>
                        </a>
                     </li>
                     <li class="breadcrumb-item">{{__('Widget  Components')}}
                     </li>
                     
                  </ul>
               </div>
            </div>
            <!-- Page header end -->
            <!-- Page body start -->
            <div class="page-body">
               <div class="row">
                  <div class="col-sm-12">
                     <!-- Basic Form Inputs card start -->
                     <div class="card">
                        <div class="card-block">
                           <h4 class="sub-title">{{__('Widget Inputs')}}</h4>




                           <form action="{{ route('admin.widgets.store') }}" method="POST" enctype="multipart/form-data" class="form">
                    @csrf
                    
                    <div class="sbp-preview">
                        <div class="sbp-preview-content">
                        @include('admin.widgets.inc.form')
                        <div class="col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }} &nbsp <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>



                          
                           
                        </div>

                     </div>
                  </div>
               </div>
            </div>
            <!-- Page body end -->
         </div>
      </div>
   </div>
</div>

</x-admin-layout>

