<?php

namespace GameapModules\Fastdl\Http\Requests;

use Gameap\Http\Requests\Request;

class FastdlDsRequest extends Request
{
    public function rules(): array
    {
        return [
            'method' => 'required|string|max:64|in:link,mount,copy,rsync',
            'host' => 'required|string|max:128',
            'port' => 'required|integer|between:1,65535',
            'autoindex' => '',
        ];
    }
}
