<div class="row">
   <div class="col-xl-6">
      <!-- Account details card-->
      <div class="card mb-4">
         <div class="card-header" style="background-color: #eeee;color: #69707a !important;">General</div>
         <div class="card-body">
            <div class="row">
               <div class="col-sm-6 col-md-6">
                  <div class="mb-3">
                     {!! Html::label('First Name', 'first_name', ['class' => '']) !!}
                     {!! Html::text('first_name')->class('form-control')->id('first_name')->placeholder('First Name') !!}
                     {!! APFrmErrHelp::showErrors($errors, 'first_name') !!}
                  </div>
               </div>
               <div class="col-sm-6 col-md-6">
                  <div class="mb-3">
                     {!! Html::label('Last Name', 'last_name', ['class' => '']) !!}
                     {!! Html::text('last_name')->class('form-control')->id('last_name')->placeholder('Last Name') !!}
                     {!! APFrmErrHelp::showErrors($errors, 'last_name') !!}
                  </div>
               </div>
               <div class="col-sm-6 col-md-6">
                  <div class="mb-3">
                     {!! Html::label('Email address', 'email', ['class' => '']) !!}
                     {!! Html::email('email')->class('form-control')->id('email')->placeholder('Email address') !!}
                     {!! APFrmErrHelp::showErrors($errors, 'email') !!}
                  </div>
               </div>
               <div class="col-sm-6 col-md-6">
                  <div class="mb-3">
                     {!! Html::label('Phone Number', 'phone', ['class' => '']) !!}
                     {!! Html::text('phone')->class('form-control')->id('phone')->placeholder('Phone Number') !!}
                     {!! APFrmErrHelp::showErrors($errors, 'phone') !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-xl-6">
      <!-- Account details card-->
      <div class="card mb-4">
         <div class="card-header" style="background-color: #eeee;color: #69707a !important;">Security</div>
         <div class="card-body">
            <div class="row">
               <div class="col-sm-6 col-md-6">
                  <div class="mb-3">
                     {!! Html::label('Username', 'username', ['class' => '']) !!}
                     {!! Html::text('username')->class('form-control')->id('username')->placeholder('Username') !!}
                     {!! APFrmErrHelp::showErrors($errors, 'username') !!}
                  </div>
               </div>
               <div class="col-sm-6 col-md-6">
    <?php $roles = Spatie\Permission\Models\Role::pluck('name', 'name')->toArray(); ?>
    <div class="mb-3">
        {!! Html::label('Role', 'role', ['class' => '']) !!}
        {!! Html::select('role', ['' => 'Select Role'] + $roles)->class('form-control')->id('role')->required() !!}
        {!! APFrmErrHelp::showErrors($errors, 'role') !!}
    </div>
</div>

               <div class="col-sm-12 col-md-12">
                  <div class="mb-3">
                     {!! Html::label('Password', 'password', ['class' => '']) !!}
                     {!! Html::password('password')->class('form-control')->id('password')->placeholder('*******')->attribute('autocomplete', 'new-password') !!}
                     {!! APFrmErrHelp::showErrors($errors, 'password') !!}
                  </div>
               </div>
               <div class="col-sm-6 col-md-6">
                  <div class="mb-3">
                     {!! Html::label('User Status', 'status', ['class' => '']) !!}
                     {!! Html::select('status', ['active' => 'Active', 'blocked' => 'Blocked'])->class('form-control select2')->id('class_id')->required() !!}
                     {!! APFrmErrHelp::showErrors($errors, 'phone') !!}
                  </div>
               </div>
               <div class="col-sm-6 col-md-6" id="company">
                  <?php $users = App\Models\User::pluck('name', 'id')->toArray(); ?>
                  <div class="mb-3">
                     {!! Html::label('Reports To', 'parent_id', ['class' => '']) !!}
                     {!! Html::select('parent_id', ['' => 'Select'] + $users)->class('form-control')->id('parent_id')->required() !!}
                     {!! APFrmErrHelp::showErrors($errors, 'parent_id') !!}
                  </div>
               </div>
               <div class="col-sm-6 col-md-6">
                  <div class="mb-3">
                     {!! Html::label('Change Profile Picture', 'profile_image', ['class' => '']) !!}
                     <input type="file" name="profile_image" class="form-control">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
