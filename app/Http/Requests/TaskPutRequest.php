<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskPutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "max:255",
            "type_name" => "exists:App\Models\TaskType,name",
            "place" => "max:500",
            "date" => "date_format:Y-m-d",
            "time" => "date_format:H:i",
            "duration" => "date_format:H:i",
            "comment" => "max:1024",
            "done" => "boolean"
        ];
    }
}
