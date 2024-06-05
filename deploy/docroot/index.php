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

$composerAutoload = __DIR__ . '/../vendor/autoload.php';
if (is_file($composerAutoload) === false) {
    throw new LogicException('Composer autoload missing. Try running `composer update`.');
}

require_once $composerAutoload;
require_once __DIR__ . '/../config/config.php';

use StevenFoncken\AssignmentsViewerForMoodle\Config\AppConfig;
use StevenFoncken\AssignmentsViewerForMoodle\Controller\ListController;
use StevenFoncken\AssignmentsViewerForMoodle\API\MoodleMobileWebServiceAPI;
use StevenFoncken\AssignmentsViewerForMoodle\Service\MoodleAssignmentsService;

$appConfig = new AppConfig($_ENV);
$moodleMobileWebServiceAPI = new MoodleMobileWebServiceAPI(
    $appConfig->getMoodleBaseUrl(),
    $appConfig->getMoodleUsername(),
    $appConfig->getMoodlePassword()
);
$moodleAssignmentsService = new MoodleAssignmentsService($appConfig, $moodleMobileWebServiceAPI);

$listController = new ListController($moodleAssignmentsService);
echo $listController->index();
