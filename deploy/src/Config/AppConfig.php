<?php

/**
 * This file is part of the assignments-viewer-for-moodle-php project.
 *
 * @see https://github.com/stevenfoncken/assignments-viewer-for-moodle-php
 *
 * @copyright 2024-present Steven Foncken <dev[at]stevenfoncken[dot]de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * @license https://github.com/stevenfoncken/assignments-viewer-for-moodle-php/blob/master/LICENSE MIT License
 */

namespace StevenFoncken\AssignmentsViewerForMoodle\Config;

/**
 * Class to encapsulate environment variables.
 *
 * @since  1.1.0
 * @author Steven Foncken <dev[at]stevenfoncken[dot]de>
 */
class AppConfig
{
    /**
     * @param array|null $env
     */
    public function __construct(
        private readonly array|null $env
    ) {
    }

    /**
     * URL of the Moodle instance.
     *
     * @return string
     */
    public function getMoodleBaseUrl(): string
    {
        return $this->env['MOODLE_BASE_URL'];
    }

    /**
     * @return string
     */
    public function getMoodleUsername(): string
    {
        return $this->env['MOODLE_USERNAME'];
    }

    /**
     * @return string
     */
    public function getMoodlePassword(): string
    {
        return $this->env['MOODLE_PASSWORD'];
    }

    /**
     * Hide submitted assignments in overview.
     *
     * @return bool
     */
    public function getHideSubmittedAssignmentsSetting(): bool
    {
        return \filter_var($this->env['SETTING_HIDE_SUBMITTED_ASSIGNMENTS'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Number of days to display past assignments.
     *
     * @return int
     */
    public function getPastAssignmentsDaysCountSetting(): int
    {
        return $this->env['SETTING_PAST_ASSIGNMENTS_DAYS_COUNT'];
    }

    /**
     * Cache expiration date of the stored assignments data.
     *
     * @return int
     */
    public function getAssignmentsCacheExpiresAfterSecondsSetting(): int
    {
        return $this->env['SETTING_ASSIGNMENTS_CACHE_EXPIRES_AFTER_SEC'];
    }

    /**
     * @return string
     */
    public function getAppTimezone(): string
    {
        return $this->env['APP_TIMEZONE'];
    }
}
