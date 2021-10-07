<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 07/10/2021
 * Time: 15:58
 */

namespace App\Core\Exception;


use Symfony\Component\Security\Core\Exception\AuthenticationException;

class RecaptchaException extends AuthenticationException
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Please prove you are not a robot.';
    }
}