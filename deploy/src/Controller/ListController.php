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

namespace StevenFoncken\AssignmentsViewerForMoodle\Controller;

use StevenFoncken\AssignmentsViewerForMoodle\Helper\RenderHelper;
use StevenFoncken\AssignmentsViewerForMoodle\Service\MoodleAssignmentsService;

/**
 * List Controller.
 *
 * @since  1.0.0
 * @author Steven Foncken <dev[at]stevenfoncken[dot]de>
 */
class ListController
{
    private const string TEMPLATE_DIR_PATH                      = __DIR__ . '/../../templates';
    private const array LIST_TEMPLATE_PLACEHOLDER_VARS          = ['###ASSIGNMENT_BOXES###'];
    private const array ASSIGNMENTBOX_TEMPLATE_PLACEHOLDER_VARS = [
        '###ASSIGNMENT_URL###',
        '###ASSIGNMENT_TITLE###',
        '###ASSIGNMENT_CATEGORYNAME###',
        '###ASSIGNMENT_COURSENAME###',
        '###ASSIGNMENT_DUE###',
        '###ASSIGNMENT_CUTOFF###',
        '###ASSIGNMENT_OPENED###',
        '###ASSIGNMENT_DEADLINE_INDICATOR_COLOR###',
    ];



    /**
     * @param MoodleAssignmentsService $moodleAssignmentsService
     */
    public function __construct(
        private readonly MoodleAssignmentsService $moodleAssignmentsService
    ) {
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function index(): string
    {
        $assignments = $this->moodleAssignmentsService->getCachedCurrentAssignments();
        $timezone = new \DateTimeZone(date_default_timezone_get());
        $dateFormat = 'd.m.Y - H:i:s';

        $assignmentBoxes = '';
        foreach ($assignments as $assignment) {
            $assignmentBoxes .= RenderHelper::render(
                self::TEMPLATE_DIR_PATH . '/partials/AssignmentBox.html',
                self::ASSIGNMENTBOX_TEMPLATE_PLACEHOLDER_VARS,
                [
                    $assignment->getUrl(),
                    $assignment->getTitle(),
                    $assignment->getCategoryName(),
                    $assignment->getCourseName(),
                    $assignment->getDueDate()->setTimezone($timezone)->format($dateFormat),
                    $assignment->getCutoffDate()->setTimezone($timezone)->format($dateFormat),
                    $assignment->getOpenedDate()->setTimezone($timezone)->format($dateFormat),
                    $assignment->getDeadlineIndicatorColor(),
                ]
            );
        }


        return RenderHelper::render(
            self::TEMPLATE_DIR_PATH . '/List.html',
            self::LIST_TEMPLATE_PLACEHOLDER_VARS,
            [$assignmentBoxes]
        );
    }
}
