<?php


namespace GameapModules\FastDl\Http\Requests;

use Gameap\Http\Requests\Request;

class FastdlDsRequest extends Request
{
    public function rules()
    {
        return [
            'method' => 'required|string|max:64|in:link,mount,copy,rsync',
            'host' => 'required|string|max:128',
            'port' => 'required|integer|between:1,65535',
            'autoindex' => '',
        ];
    }
}