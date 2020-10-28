<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            "name" => "required|max:255",
            "type_name" => "required|exists:App\Models\TaskType,name",
            "place" => "required|max:500",
            "date" => "required|date_format:Y-m-d",
            "time" => "required|date_format:H:i",
            "duration" => "required|date_format:H:i",
            "comment" => "required|max:1024",
        ];
    }

    //public function all($keys = null){
    //    if(empty($keys)){
    //        return parent::json()->all();
    //    }

    //    return collect(parent::json()->all())->only($keys)->toArray();
    //}

}
