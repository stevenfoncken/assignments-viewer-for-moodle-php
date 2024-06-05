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

namespace StevenFoncken\AssignmentsViewerForMoodle\Helper;

/**
 * Helpers for template rendering.
 *
 * @since  1.0.0
 * @author Steven Foncken <dev[at]stevenfoncken[dot]de>
 */
class RenderHelper
{
    /**
     * @param string $templatePath
     * @param array  $placeholders
     * @param array  $data
     *
     * @return string
     */
    public static function render(string $templatePath, array $placeholders, array $data): string
    {
        return str_replace(
            $placeholders,
            $data,
            file_get_contents($templatePath)
        );
    }
}
