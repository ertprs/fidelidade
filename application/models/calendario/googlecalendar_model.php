<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

class Googlecalendar_model extends Model
{

    public function __construct()
    {

        parent::__construct();
        // $this->load->library('session');
        // $this->load->library('googleplus');
        
        $this->calendar = new Google_Service_Calendar($this->googleplus->client());

    }


    public function isLogin()
    {


        $token = $this->session
            ->userdata('google_calendar_access_token');

        if ($token) {

            $this->googleplus
                ->client
                ->setAccessToken($token);

        }

        if ($this->googleplus->isAccessTokenExpired()) {

            return false;

        }

        return $token;

    }


    public function loginUrl()
    {

        return $this->googleplus
            ->loginUrl();

    }


    public function login($code)
    {

        $login = $this->googleplus
            ->client
            ->authenticate($code);


        if ($login) {

            $token = $this->googleplus
                ->client
                ->getAccessToken();

            $this->session
                ->set_userdata('google_calendar_access_token', $token);

            return true;

        }

    }


    public function getUserInfo()
    {

        return $this->googleplus->getUser();

    }


    public function getEvents($calendarId = 'primary', $timeMin = false, $timeMax = false, $maxResults = 10)
    {


        if ( ! $timeMin) {

            $timeMin = date("c", strtotime(date('Y-m-d ').' 00:00:00'));

        } else {

            $timeMin = date("c", strtotime($timeMin));

        }


        if ( ! $timeMax) {

            $timeMax = date("c", strtotime(date('Y-m-d ').' 23:59:59'));

        } else {

            $timeMax = date("c", strtotime($timeMax));

        }


        $optParams = array(
            'maxResults'   => $maxResults,
            'orderBy'      => 'startTime',
            'singleEvents' => true,
            'timeMin'      => $timeMin,
            'timeMax'      => $timeMax,
            'timeZone'     => 'Europe/Istanbul',

        );

        $results = $this->googlecalendar->calendar->events->listEvents($calendarId, $optParams);


        $data = array();

        foreach ($results->getItems() as $item) {

            $start = date('d-m-Y H:i', strtotime($item->getStart()->dateTime));

            array_push(

                $data,
                array(

                    'id'          => $item->getId(),
                    'summary'     => $item->getSummary(),
                    'description' => $item->getDescription(),
                    'creator'     => $item->getCreator(),
                    'start'       => $item->getStart()->dateTime,
                    'end'         => $item->getEnd()->dateTime,


                )

            );

        }

        return $data;

    }


    public function addEvent($calendarId = 'primary', $data)
    {


        $event = new Google_Service_Calendar_Event(
            array(
                'summary'     => $data['summary'],
                'description' => $data['description'],
                'start'       => array(
                    'dateTime' => $data['start'],
                    'timeZone' => 'America/Fortaleza',
                ),
                'end'         => array(
                    'dateTime' => $data['end'],
                    'timeZone' => 'America/Fortaleza',
                ),
            )
        );
        $array = array();
        $token_teste = json_decode($this->session->userdata('google_calendar_access_token'));
        // echo '<pre>';
        // print_r($token_teste);
        // die;

        return $this->calendar->events->insert($calendarId, $event, $array, $token_teste);


    }


}