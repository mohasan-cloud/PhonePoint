<x-admin-layout>
    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">



        </div>
   <div class="container-xl px-4">
        <div class="card mb-4">
            <livewire:admin.common.header
                :title="'Edit User'"
                :content="'List of all Users are below'"
                :icon="'fa-school'"
                :term="'User'"
                :slug="url('/admin/users')"
                :button="__('Users List')"
            />
            <div class="card-body">
                @if(session()->has('message.added'))
                    <div class="alert alert-{{ session('message.added') }} alert-dismissible fade show" role="alert">
                        <strong>{{__('Congratulations')}}!</strong> {!! session('message.content') !!}.
                    </div>
                @endif
                {{ html()->modelForm($user, 'POST', route('admin.users.update',[$user->id]))->open() }}
               <input type="hidden" name="id" value="{{$user->id}}" />
               <div class="sbp-preview">
                  <div class="sbp-preview-content">
                     @include('admin.users.inc.form')
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
</x-app-layout>
