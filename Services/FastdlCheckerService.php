<?php

namespace GameapModules\Fastdl\Services;

use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Request;

class FastdlCheckerService
{
    public function isHostPortEqualGameap(Request $request, string $host, string $port): bool
    {
        $url = Config::get('app.url');
        $parseResult = parse_url($url);

        if ($host === $parseResult['host'] && $port === $parseResult['port']) {
            return true;
        }

        if ($host === $request->getHost() && $port === $request->getPort()) {
            return true;
        }

        return false;
    }
}
