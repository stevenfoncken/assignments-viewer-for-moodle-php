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

namespace StevenFoncken\AssignmentsViewerForMoodle\Model;

/**
 * Assignment Model.
 *
 * @since  1.1.0
 * @author Steven Foncken <dev[at]stevenfoncken[dot]de>
 */
class Assignment
{
    /**
     * @var string
     */
    private string $url = '';

    /**
     * @var string
     */
    private string $title = '';

    /**
     * @var string
     */
    private string $categoryName = '';

    /**
     * @var string
     */
    private string $courseName = '';

    /**
     * @var \DateTime
     */
    private \DateTime $dueDate;

    /**
     * @var \DateTime
     */
    private \DateTime $cutoffDate;

    /**
     * @var \DateTime
     */
    private \DateTime $openedDate;

    /**
     * @var bool
     */
    private bool $submitted = false;



    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl(string $url): Assignment
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): Assignment
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    /**
     * @param string $categoryName
     *
     * @return $this
     */
    public function setCategoryName(string $categoryName): Assignment
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCourseName(): string
    {
        return $this->courseName;
    }

    /**
     * @param string $courseName
     *
     * @return $this
     */
    public function setCourseName(string $courseName): Assignment
    {
        $this->courseName = $courseName;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDueDate(): \DateTime
    {
        return $this->dueDate;
    }

    /**
     * @param \DateTime $dueDate
     *
     * @return $this
     */
    public function setDueDate(\DateTime $dueDate): Assignment
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCutoffDate(): \DateTime
    {
        return $this->cutoffDate;
    }

    /**
     * @param \DateTime $cutoffDate
     *
     * @return $this
     */
    public function setCutoffDate(\DateTime $cutoffDate): Assignment
    {
        $this->cutoffDate = $cutoffDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getOpenedDate(): \DateTime
    {
        return $this->openedDate;
    }

    /**
     * @param \DateTime $openedDate
     *
     * @return $this
     */
    public function setOpenedDate(\DateTime $openedDate): Assignment
    {
        $this->openedDate = $openedDate;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSubmitted(): bool
    {
        return $this->submitted;
    }

    /**
     * @param bool $submitted
     *
     * @return $this
     */
    public function setSubmitted(bool $submitted): Assignment
    {
        $this->submitted = $submitted;

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getDeadlineIndicatorColor(): string
    {
        $deadlineIndicatorColor = 'white';
        $greenColor             = '#0f0';
        $pinkColor              = '#f0d';
        $redColor               = '#f03';
        $yellowColor            = '#ffe200';

        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $nowTimestamp = $now->getTimestamp();
        $dueDateTimestamp = $this->getDueDate()->getTimestamp();

        $daysDifference = (($dueDateTimestamp - $nowTimestamp) / 86400);
        if ($daysDifference <= 1) {
            $deadlineIndicatorColor = $pinkColor;
        } elseif ($daysDifference <= 2) {
            $deadlineIndicatorColor = $redColor;
        } elseif ($daysDifference <= 3) {
            $deadlineIndicatorColor = $yellowColor;
        }

        if ($this->isSubmitted()) {
            $deadlineIndicatorColor = $greenColor;
        }


        return $deadlineIndicatorColor;
    }
}
