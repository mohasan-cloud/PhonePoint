<x-admin-layout>
    <style>
        .badge-primary{
            font-size: 12px;
    background: #3f51b5;
    color: #fff;
        }
    </style>
    <div class="container-xl px-4">
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">{{$module->name}}</div>
                    <div class="col-md-4">
                        <div class="input-group input-group-joined border-0 add-button">
                            @if($module->is_preview)
                            <a class="btn btn-success btn-sm" href="javascript:;" onclick="javascript:$('#myModal1').modal('show')">{{__('Import')}}</a>&nbsp <a class="btn btn-success btn-sm" href="javascript:;" onclick="javascript:$('#myModal').modal('show')">{{__('Assign')}}</a>&nbsp @endif<a class="btn btn-danger btn-sm" href="{{url('/admin/'.$module->slug.'/add')}}">{{__('Add New '.$module->term)}}</a>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="card-body">
                @if(session()->has('message.added'))
                    <div class="alert alert-{{ session('message.added') }} alert-dismissible fade show" role="alert">
                        <strong>{{__('Congratulations')}}!</strong> {!! session('message.content') !!}.
                    </div>
                @endif
                <input type="hidden" id="table-modules-data-url" value="{{ Request::url() }}">
                <input type="hidden" id="is_enable_modules_data_action" value="{{ (in_array('modules.data.edit', permissions()) || in_array('modules.data.destroy', permissions())) ? 'yes' : 'no' }}">
                <table class="table table-bordered" id="table-modules-data">
                    <thead>
                        <tr>
                            @if($module->is_image)
                                <th>{{__('Image')}}</th>
                            @endif
                            
                            @if($module->is_preview)
                            <th>
                            <span><input type="checkbox" name="title[]" value="all" placeholder="" class=""></span>
                            </th>
                            @endif
                            
                            <th>
                            Name
                                
                            </th>
                            
                            @if($module->category)
                                <th>{!! $parent->term !!}</th>
                            @endif
                            @foreach($module->fields()->get() ?? [__('Created Date')] as $list)
                                <th>{{ $list->field_title ?? __('Created Date') }}</th>
                            @endforeach
                            @if($module->is_preview)
                            <th>{{__('Assigned Users')}}</th>
                            @else
                            <th>{{__('Status')}}</th>
                            @endif
                            

                            <th style="@if($module->is_preview) width: 120px; @endif">{{__('Action')}}</th>
                        </tr>
                        <tr role="row" class="filter">
                            @if($module->is_image)
                                <td></td>
                            @endif
                            @if($module->is_preview)
                            <td>
                                
                               
                                
                                
                            </td>
                            @endif
                            <td>
                                <input type="text" class="form-control" name="title" id="title" autocomplete="off" placeholder="Search Name">
                                
                            </td>
                           @if($module->category)
                                <td>
                                    {!! Html::select('category', [''=>'Select '.$parent->term] + dataArray($module->parent_id))->class('form-control')->id('category')->required() !!}
                                </td>
                            @endif

                            @foreach($module->fields()->get() ?? [] as $list)
                                <td>
                                    @if($list->field_type == 'select')
                                        {!! Html::select($list->field, [''=>'Select '.$list->field_title] + dataArray($list->field_attr))->class('form-control')->id($list->field)->required() !!}
                                    @else
                                        {!! Html::input('text', $list->field)->class('form-control')->name($list->field)->id($list->field)->autocomplete('off')->placeholder('Search '.$list->field_title) !!}
                                    @endif
                                </td>
                            @endforeach
                           
                            <td>
                                @if($module->is_preview)
                                <?php $users = App\Models\User::where('role',4)->get(); ?>
                                    <select name="native-select" placeholder="User Select" id="select-user" class="form-control">
                                        <option value="">Select User</option>
                                        @if(null!==($users))
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                @else
                                <select name="status" id="status" class="form-control status">
                                    <option value="">Select Status</option>
                                    
                                    <option value="active">Active</option>
                                    <option value="blocked">Blocked</option>
                                    
                                </select>
                                @endif
                                
                            </td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <input type="hidden" id="is_image" name="is_image" value="{{ $module->is_image ? 'yes' : 'no' }}">
    <input type="hidden" id="is_preview" name="is_preview" value="{{ $module->is_preview ? 'yes' : 'no' }}">
    <input type="hidden" id="is_category" name="is_category" value="{{ $module->category ? 'yes' : 'no' }}">
    <input type="hidden" id="message_added" name="message_added" value="{{ session()->has('message.added') ? 'yes' : 'no' }}">
    <input type="hidden" id="message" name="message" value="{!! session('message.content') !!}">
    <input type="hidden" id="modules_data_fetch" name="modules_data_fetch" value="{{ route('admin.modules.data.fetch') }}">
    <input type="hidden" id="module_id" name="module_id" value="{{ $module->id }}">
    <input type="hidden" id="module_fields" name="module_fields" value="{{ json_encode($module->fields()->get()) }}">
    <input type="hidden" id="base_url" name="base_url" value="{{ url('/') }}">

    @push('js')
        <script src="{{ asset('admin_assets/js/modules.js?v=4.2') }}"></script>
           
    @endpush
</x-admin-layout>
