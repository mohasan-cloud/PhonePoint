<?php 
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'supplier_name' => 'required|max:128',
            'supplier_type_id' => 'nullable|integer',
            'supplier_contact_number' => 'nullable|max:26',
            'supplier_mobile_number' => 'nullable|max:26',
            'supplier_email_address' => 'nullable|email|max:128',
            'supplier_location' => 'nullable|max:256',
            'about_supplier' => 'required|max:1024',
            'logo' => 'nullable|max:164',
            'city' => 'nullable|integer',
            'state' => 'nullable|integer',
            'country' => 'nullable|integer',
            'operation_type' => ['nullable', Rule::in(['Inbound', 'Inbound & Out Bound', 'Outbound'])],
            'supplier_markets' => 'nullable|max:264',
            'supplier_created_by' => 'nullable|integer',
            'supplier_last_modified_by' => 'nullable|integer',
            'status' => ['nullable', Rule::in(['1', '0'])],
        ];
    }

    public function messages()
    {
        return [
            'supplier_name.required' => 'The supplier name is required.',
            'supplier_name.max' => 'The supplier name cannot exceed 128 characters.',
            'supplier_type_id.integer' => 'The supplier type must be an integer.',
            'supplier_contact_number.max' => 'The supplier contact number cannot exceed 26 characters.',
            'supplier_mobile_number.max' => 'The supplier mobile number cannot exceed 26 characters.',
            'supplier_email_address.email' => 'The supplier email address must be a valid email.',
            'supplier_email_address.max' => 'The supplier email address cannot exceed 128 characters.',
            'supplier_location.max' => 'The supplier location cannot exceed 256 characters.',
            'about_supplier.required' => 'The about supplier field is required.',
            'about_supplier.max' => 'The about supplier field cannot exceed 1024 characters.',
            'logo.max' => 'The logo path cannot exceed 164 characters.',
            'city.integer' => 'The city must be an integer.',
            'state.integer' => 'The state must be an integer.',
            'country.integer' => 'The country must be an integer.',
            'operation_type.in' => 'The operation type must be one of: Inbound, Inbound & Out Bound, Outbound.',
            'supplier_markets.max' => 'The supplier markets cannot exceed 264 characters.',
            'supplier_created_by.integer' => 'The supplier created by must be an integer.',
            'supplier_last_modified_by.integer' => 'The supplier last modified by must be an integer.',
            'status.in' => 'The status must be one of: 1, 0.',
        ];
    }
}





 ?>