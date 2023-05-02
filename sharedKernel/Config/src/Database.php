<?php

namespace SharedKernel\ConfigResolver;

use App\Http\Services\ConfigService;

class Database
{

    private ConfigService $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function findByKey($key)
    {
        return $this->configService::getConfigByKey($key);
    }
}

