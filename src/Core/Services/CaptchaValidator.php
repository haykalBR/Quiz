<?php
namespace App\Core\Services;
use ReCaptcha\ReCaptcha;

class CaptchaValidator
{
    private string $key;
    private string $secret;

    public function __construct(string $key, string $secret)
    {
        $this->key    = $key;
        $this->secret = $secret;
    }

    /**
     * Validate Captcha.
     */
    public function validateCaptcha(string $gRecaptchaResponse): bool
    {
        $recaptcha = new ReCaptcha($this->secret);
        $resp      = $recaptcha->verify($gRecaptchaResponse);

        return $resp->isSuccess();
    }

    /**
     *  get Key in env.
     */
    public function getKey(): string
    {
        return $this->key;
    }
}