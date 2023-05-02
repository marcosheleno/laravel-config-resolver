<?php

namespace App\Http\Services;

use App\Models\Config;
use App\Http\Services\CacheService;

class ConfigService
{
    protected static array $defaults = [
        'TTL_HOME' => 3600,
        'TTL_CONFIG' => 86400,
        'TTL_CATEGORY_SLUG' => 3600,
        'TTL_INSTITUTIONAL_INFORMATION' => 3600,
        'TTL_PRODUCT_ID' => 3600,
        'TTL_DASHBOARD_TOTAL_SALES' => 3600,
        'TTL_DASHBOARD' => 86400,
        'WEBHOOK_URL_UPDATE_BANNER' => 'https://123milhas.com/api/v3/promo-offers/update',
        'TIME_DISTANCE_BETWEEN_EXPIRY_TIMES' => 60,
        'ENABLE_CACHE_SCALING' => 1,
        'BASE_REDIS_KEY' => 'promo_123_database_',
        'ENABLE_CACHE_JOB' => 1,
    ];

    public function __construct()
    {
    }

    public static function getConfig(string $configName)
    {
        $result = json_decode(CacheService::get($configName));
        if (!isset($result)) {
            $result = Config::where('key', $configName)->first() !== null ? Config::where('key', $configName)->first()->value : null;
            if (!isset($result)) {
                $result = self::$defaults[$configName];
                if (!isset($result)) {
                    throw new \RuntimeException('Invalid Config Name');
                }
                $config = new Config();
                $config->key = $configName;
                $config->value = self::$defaults[$configName];
                $config->save();
            }
            CacheService::set($configName, $result, 'EX', self::$defaults['TTL_CONFIG']);
        }
        return $result;
    }

    public static function getConfigByKey(string $configName)
    {
        // FIXME - Retirar , este é um fix temporario e pode mascarar erros importantes ao buscar config no bd
        try {
            return Config::where("status", 1)
                ->where("key", $configName)
                ->first()
                ->value ?? null;
        } catch (\Throwable $th) {
            //TODO
        }
    }

    public static function getConfigDescriptionByKey(string $configName)
    {
        // FIXME - Retirar , este é um fix temporario e pode mascarar erros importantes ao buscar config no bd
        try {
            return Config::where("status", 1)
                ->where("key", $configName)
                ->first()
                ->description ?? null;
        } catch (\Throwable $th) {
            //TODO
        }
    }
}
