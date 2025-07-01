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
        $rules = [
            'name'          => 'required|string|max:255',
            'is_multi_day'  => 'sometimes|boolean',
            'description'   => 'required|string',
            'street'        => 'required|string|max:255',
            'city'          => 'required|string|max:255',
            'state'         => 'required|string|max:255',
            'zip_code'      => ['required', new UsZipCode()],
            'location_name' => 'required|string|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,gif,webp',
            'is_featured'   => 'sometimes|boolean',
        ];

        if (request('is_multi_day')) {
            // Multi-day event rules
            $rules['event_days']          = 'required|array|min:1';
            $rules['event_days.*.date']   = 'required|date';
            $rules['event_days.*.start_time'] = 'required|date_format:H:i';
            $rules['event_days.*.end_time']   = 'required|date_format:H:i';
            $rules['event_days.*.id']     = 'nullable|exists:event_days,id';
        } else {
            // Single-day event rules
            $rules['date']       = 'required|date';
            $rules['start_time'] = 'required|date_format:H:i';
            $rules['end_time']   = 'required|date_format:H:i';
        }

        return $rules;
    }
}
