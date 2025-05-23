<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UsZipCode;
use App\Models\Event;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        // grabs the {event} from route-model binding
        return $this->user()->can('update', $this->route('event'));
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'date'          => 'required|date',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i|after_or_equal:18:00|before_or_equal:22:00',
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
