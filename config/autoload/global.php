<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'session_config'    =>  array(
        'name' => 'hangman',
        'cache_expire'          =>  2419200,
        'cookie_lifetime'       =>  2419200,
        'gc_maxlifetime'        =>  2419200,
        'cookie_path'           =>  '/',
        'cookie_secure'         =>  false,
        'remember_me_seconds'   =>  2419200,
        'use_cookies'           =>  true,
    ),
);
