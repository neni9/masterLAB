<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostRequest extends Request
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
            'title'         => 'required|string',
            'content'       => 'required|string|min:20', 
            'excerpt'       => 'string|min:20|max:255', 
            'user_id'       => 'integer',
            'status'        => 'in:published,unpublished',
            'published_at'  => 'date:Y-m-d H:i:s',
            'tweet_content' => 'string|max:100', 

        ];
    }
}
