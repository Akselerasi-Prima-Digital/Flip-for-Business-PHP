<?php

namespace AkselerasiPrimaDigital\FlipForBusinessPhp;

/**
 * Flip for Business Configuration.
 */
class Config
{
    public const SANDBOX_BASE_URL = 'https://bigflip.id/big_sandbox_api/v2';
    public const PRODUCTION_BASE_URL = 'https://bigflip.id/api/v2';

    /**
     * API Key dari Flip for Business.
     * @static
     */
    public static $apiKey;

    /**
     * Webhook secret untuk verifikasi HMAC.
     * @static
     */
    public static $webhookSecret;

    /**
     * Gunakan production? true=production, false=sandbox.
     * @static
     */
    public static $isProduction = false;

    /**
     * Logging sederhana (error_log)
     * @static
     */
    public static bool $debug = false;

    /**
     * Base URL sesuai environment.
     */
    public static function getBaseUrl(): string
    {
        return self::$isProduction
            ? self::PRODUCTION_BASE_URL
            : self::SANDBOX_BASE_URL;
    }
}
