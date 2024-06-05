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

namespace StevenFoncken\AssignmentsViewerForMoodle\API;

/**
 * Interface for the MoodleMobileWebServiceAPI wrapper.
 *
 * @since  1.1.0
 * @author Steven Foncken <dev[at]stevenfoncken[dot]de>
 */
interface MoodleMobileWebServiceAPIInterface
{
    /**
     * @return array
     */
    public function getSiteInfo(): array;

    /**
     * @param string $fieldName
     * @param string $fieldValue
     *
     * @return array
     */
    public function getCoursesByField(string $fieldName, string $fieldValue): array;

    /**
     * @return array
     */
    public function getAssignments(): array;

    /**
     * @param int $assignmentId
     *
     * @return array
     */
    public function getSubmissionStatus(int $assignmentId): array;
}
