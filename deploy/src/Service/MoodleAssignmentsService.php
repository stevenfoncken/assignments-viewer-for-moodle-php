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

namespace StevenFoncken\AssignmentsViewerForMoodle\Service;

use StevenFoncken\AssignmentsViewerForMoodle\Model\Assignment;
use StevenFoncken\AssignmentsViewerForMoodle\Config\AppConfig;
use StevenFoncken\AssignmentsViewerForMoodle\API\MoodleMobileWebServiceAPIInterface;

/**
 * Service that handles various tasks related to Moodle assignments.
 *
 * @since  1.0.0
 * @author Steven Foncken <dev[at]stevenfoncken[dot]de>
 */
class MoodleAssignmentsService
{
    private const string CACHE_DIR_PATH = __DIR__ . '/../../var/cache';



    /**
     * @param AppConfig                          $appConfig
     * @param MoodleMobileWebServiceAPIInterface $moodleMobileWebServiceAPI
     */
    public function __construct(
        private readonly AppConfig $appConfig,
        private readonly MoodleMobileWebServiceAPIInterface $moodleMobileWebServiceAPI
    ) {
    }

    /**
     * @return Assignment[]
     * @throws \Exception
     */
    public function getCurrentAssignments(): array
    {
        $assignmentsByCourses = $this->moodleMobileWebServiceAPI->getAssignments()['courses'];

        $assignments = [];
        foreach ($assignmentsByCourses as $course) {
            $courseAssignments = $course['assignments'];

            foreach ($courseAssignments as $courseAssignment) {
                $allowSubmissionsFromDate = new \DateTime('@' . $courseAssignment['allowsubmissionsfromdate']);
                $dueDate = new \DateTime('@' . $courseAssignment['duedate']);
                $cutOffDate = new \DateTime('@' . $courseAssignment['cutoffdate']);
                $now = new \DateTime('now', new \DateTimeZone('UTC'));

                $submissionStatus = $this->moodleMobileWebServiceAPI->getSubmissionStatus($courseAssignment['id']);
                // Date for granted extension by assignment creator.
                $extensionDueDate = new \DateTime('@' . ($submissionStatus['lastattempt']['extensionduedate'] ?? 0));

                $isSubmitted = (
                    $submissionStatus['lastattempt']['submission']['status'] === 'submitted'
                );

                $isExtensionDueDateNotSet = (
                    $extensionDueDate->getTimestamp() === 0
                );

                $isCutOffDateNotSet = (
                    $cutOffDate->getTimestamp() === 0
                );

                // Determine if current time (minus SETTING_PAST_ASSIGNMENTS_DAYS_COUNT env) is past the due date.
                $isNowPastDueDate = (
                    $now->modify(
                        '-' . $this->appConfig->getPastAssignmentsDaysCountSetting() . ' day'
                    )->getTimestamp() > $dueDate->getTimestamp()
                );

                // Determine if cut-off date is set AND current time is past the cut-off date.
                $isCutOffDateSetAndExpired = (
                    $cutOffDate->getTimestamp() !== 0 && $now->getTimestamp() > $cutOffDate->getTimestamp()
                );

                if (
                    $isExtensionDueDateNotSet &&
                    (
                        ($isCutOffDateNotSet && $isNowPastDueDate) ||
                        $isCutOffDateSetAndExpired ||
                        ($this->appConfig->getHideSubmittedAssignmentsSetting() && $isSubmitted)
                    )
                ) {
                    continue;
                }

                if ($isCutOffDateNotSet) {
                    $cutOffDate = $dueDate;
                }

                if ($extensionDueDate->getTimestamp() !== 0) {
                    $dueDate = $cutOffDate = $extensionDueDate;
                }

                $assignmentURL = $this->appConfig->getMoodleBaseUrl() . '/mod/assign/view.php?id=' . $courseAssignment['cmid'];
                $courseCategory = $this->moodleMobileWebServiceAPI->getCoursesByField('id', $course['id'])['courses'][0]['categoryname'];

                $assignment = new Assignment();
                $assignment->setUrl($assignmentURL);
                $assignment->setTitle($courseAssignment['name']);
                $assignment->setCategoryName($courseCategory);
                $assignment->setCourseName($course['shortname']);
                $assignment->setDueDate($dueDate);
                $assignment->setCutoffDate($cutOffDate);
                $assignment->setOpenedDate($allowSubmissionsFromDate);
                $assignment->setSubmitted($isSubmitted);

                $assignments[] = $assignment;
            }
        }


        return $assignments;
    }

    /**
     * @return Assignment[]
     * @throws \Exception
     */
    public function getCachedCurrentAssignments(): array
    {
        $assignmentsCacheFile = self::CACHE_DIR_PATH . '/assignments.ser';

        if (
            file_exists($assignmentsCacheFile) === false ||
            (time() - filemtime($assignmentsCacheFile) > $this->appConfig->getAssignmentsCacheExpiresAfterSecondsSetting())
        ) {
            $assignments = $this->getCurrentAssignments();
            file_put_contents($assignmentsCacheFile, serialize($assignments));
        } else {
            $assignments = unserialize(
                file_get_contents($assignmentsCacheFile),
                [
                    'allowed_classes' => [
                        Assignment::class,
                        \DateTime::class,
                    ],
                ]
            );
        }


        return $assignments;
    }
}
