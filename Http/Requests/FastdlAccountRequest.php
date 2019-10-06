<?php


namespace GameapModules\FastDl\Http\Requests;


use Gameap\Http\Requests\Request;

class FastdlAccountRequest extends Request
{
    public function rules()
    {
        return [
            'server_id' => 'required|numeric|exists:servers,id'
        ];
    }
}