<?php

/**
 * This file is part of the assignments-viewer-for-moodle-php project.
 *
 * @see https://github.com/stevenfoncken/assignments-viewer-for-moodle-php
 *
 * @copyright 2021-present Steven Foncken <dev[at]stevenfoncken[dot]de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * @license https://github.com/stevenfoncken/assignments-viewer-for-moodle-php/blob/master/LICENSE MIT License
 */

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required(
    [
        'APP_TIMEZONE',
        'MOODLE_BASE_URL',
        'MOODLE_USERNAME',
        'MOODLE_PASSWORD',
    ]
)->notEmpty();
$dotenv->required('SETTING_PAST_ASSIGNMENTS_DAYS_COUNT')->isInteger();
$dotenv->required('SETTING_HIDE_SUBMITTED_ASSIGNMENTS')->isBoolean();
$dotenv->required('SETTING_ASSIGNMENTS_CACHE_EXPIRES_AFTER_SEC')->isInteger();

date_default_timezone_set($_ENV['APP_TIMEZONE']);
