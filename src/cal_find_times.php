<?php

// After receiving which calendar user wants to use, pull out free/busy info.

include_once 'gcal.php';

//This is a terrible way of doing this.
$selCalPost = explode(';', $_POST['cal']); 
$id = $selCalPost[0];
$timeZone = $selCalPost[1];

// minTime starts today
$today = new DateTime();
$today->setTimezone(new DateTimeZone($timeZone));

// Will set maxTime to 7 days from now (change this later if desired)
// This will be the farthest we look on the user's calendar
// Have to do $today all over again because datetime.add() changes object value
$maxTime = new DateTime();
$maxTime->setTimezone(new DateTimeZone($timeZone));
$maxTime->add(new DateInterval('P7D'));

// Freebusy query
$freeReq = new Google_Service_Calendar_FreeBusyRequest;
// how am I supposed to format a datetime string for use with this function?
$freeReq->setTimeMin($today);
$freeReq->setTimeMax($maxTime);
$freeReq->setTimeZone($timeZone);

$freeRsrc = $cal->freebusy;
$freeResp = $freeRsrc->query($freeReq);
$freeCal = $freeResp->getCalendars();
//how to grab free and busy from TimePeriod?
?>