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

namespace StevenFoncken\AssignmentsViewerForMoodle\API;

/**
 * Wrapper class for the Moodle Mobile Web Service API.
 *
 * @since  1.0.0
 * @author Steven Foncken <dev[at]stevenfoncken[dot]de>
 */
class MoodleMobileWebServiceAPI implements MoodleMobileWebServiceAPIInterface
{
    protected const string AUTHENTICATION_ENDPOINT        = '/login/token.php';
    protected const string REST_ENDPOINT                  = '/webservice/rest/server.php';
    protected const string GET_SITE_INFO_FUNCTION         = 'core_webservice_get_site_info';
    protected const string GET_COURSES_BY_FIELD_FUNCTION  = 'core_course_get_courses_by_field';
    protected const string GET_ASSIGNMENTS_FUNCTION       = 'mod_assign_get_assignments';
    protected const string GET_SUBMISSION_STATUS_FUNCTION = 'mod_assign_get_submission_status';

    /**
     * Base URL of Moodle Server.
     *
     * @var string
     */
    protected string $baseUrl = '';

    /**
     * Username of Moodle User.
     *
     * @var string
     */
    protected string $username = '';

    /**
     * Password of Moodle User.
     *
     * @var string
     */
    protected string $userPassword = '';

    /**
     * Auth Token of Moodle User.
     *
     * @var string
     */
    protected string $userAuthToken = '';



    /**
     * @return string
     */
    protected function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     *
     * @return $this
     */
    protected function setBaseUrl(string $baseUrl): MoodleMobileWebServiceAPI
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @return string
     */
    protected function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    protected function setUsername(string $username): MoodleMobileWebServiceAPI
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    protected function getUserPassword(): string
    {
        return $this->userPassword;
    }

    /**
     * @param string $userPassword
     *
     * @return $this
     */
    protected function setUserPassword(string $userPassword): MoodleMobileWebServiceAPI
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * @return string
     */
    protected function getUserAuthToken(): string
    {
        return $this->userAuthToken;
    }

    /**
     * @param string $userAuthToken
     *
     * @return $this
     */
    protected function setUserAuthToken(string $userAuthToken): MoodleMobileWebServiceAPI
    {
        $this->userAuthToken = $userAuthToken;

        return $this;
    }



    /**
     * @param string $baseUrl
     * @param string $username
     * @param string $userPassword
     * @param string $userAuthToken
     */
    public function __construct(
        string $baseUrl,
        string $username,
        string $userPassword,
        string $userAuthToken = ''
    ) {
        $this->baseUrl       = $baseUrl;
        $this->username      = $username;
        $this->userPassword  = $userPassword;
        $this->userAuthToken = $userAuthToken;

        $this->login();
    }

    /**
     * @param string|null $apiFunction
     * @param string      $endPoint
     * @param array       $params
     *
     * @return array
     */
    protected function apiCurlRequest(
        string $apiFunction = null,
        string $endPoint = self::REST_ENDPOINT,
        array $params = []
    ): array {
        $staticParams = [
            'moodlewsrestformat' => 'json',
            'wstoken'            => $this->getUserAuthToken(),
            'wsfunction'         => $apiFunction,
        ];
        $params = array_merge($params, $staticParams);

        $curl = curl_init();

        $curlOptions = [
            CURLOPT_URL            => $this->getBaseUrl() . $endPoint,
            CURLOPT_POSTFIELDS     => $params,
            CURLOPT_RETURNTRANSFER => true,
        ];
        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);
        curl_close($curl);


        return $responseJSON = (json_decode($response, true) ?? []);
    }

    /**
     * @return void
     */
    protected function login(): void
    {
        if (empty($this->getUserAuthToken())) {
            $params = [
                'username' => $this->getUserName(),
                'password' => $this->getUserPassword(),
                'service'  => 'moodle_mobile_app',
            ];

            $authToken = $this->apiCurlRequest(endPoint: self::AUTHENTICATION_ENDPOINT, params: $params)['token'];
            $this->setUserAuthToken($authToken);
        }
    }

    /**
     * @return array
     */
    public function getSiteInfo(): array
    {
        return $this->apiCurlRequest(apiFunction: self::GET_SITE_INFO_FUNCTION);
    }

    /**
     * @param string $fieldName
     * @param string $fieldValue
     *
     * @return array
     */
    public function getCoursesByField(string $fieldName, string $fieldValue): array
    {
        $params = [
            'field' => $fieldName,
            'value' => $fieldValue,
        ];


        return $this->apiCurlRequest(apiFunction: self::GET_COURSES_BY_FIELD_FUNCTION, params: $params);
    }

    /**
     * @return array
     */
    public function getAssignments(): array
    {
        return $this->apiCurlRequest(apiFunction: self::GET_ASSIGNMENTS_FUNCTION);
    }

    /**
     * @param int $assignmentId
     *
     * @return array
     */
    public function getSubmissionStatus(int $assignmentId): array
    {
        $params = ['assignid' => $assignmentId];


        return $this->apiCurlRequest(apiFunction: self::GET_SUBMISSION_STATUS_FUNCTION, params: $params);
    }
}
