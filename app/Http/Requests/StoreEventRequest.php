<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UsZipCode;
use App\Models\Event;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        // runs your EventPolicy::create($user)
        return $this->user()->can('create', Event::class);
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'date'          => 'required|date',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i',
            'description'   => 'required|string',
            'street'        => 'required|string|max:255',
            'city'          => 'required|string|max:255',
            'state'         => 'required|string|max:255',
            'zip_code'      => ['required', new UsZipCode()],
            'location_name' => 'required|string|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }
}
