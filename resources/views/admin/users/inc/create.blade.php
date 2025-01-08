<x-admin-layout>
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
               {{ html()->form('POST', route('admin.users.store'))->open() }}
               <div>
                  <div>
                     @include('admin.users.inc.form')
                     <div class="col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">{{__('Create')}} &nbsp <i class="fa-solid fa-arrow-right"></i></button>
                     </div>
                  </div>
               </div>
               {{ html()->form()->close() }}
            </div>
        </div>
        
    </div>
</x-app-layout>
