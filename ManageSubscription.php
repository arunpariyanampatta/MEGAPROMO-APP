<?php
error_reporting(E_ALL);

require_once 'RenewalServices.php';

use com\greentelecom\trivia\Renewal;

$request = file_get_contents("php://input");



$requestArray = json_decode($request,TRUE);



$service        = $requestArray['serviceID'];
$msisdn         = $requestArray['msisdn'];
$activityType   = $requestArray['activityType'];





if($service ==="SOKA_RENEWAL"){

$service = "SOKA";

}


$renewalServices = new Renewal\RenewalServices();


if($service==="ZALI"){
if($activityType==="SUBSCRIPTION"){
    $isEmpty = $renewalServices->getSubscriberDetails($msisdn, $service);


    if(empty($isEmpty)){//add to subscription
        $subscriptionArray = [];
        $subscriptionArray['MSISDN'] = $msisdn;
        $subscriptionArray['RENEWAL_STATUS'] = 'ACTIVE';
        $subscriptionArray['ACTIVITY_STATUS'] = 'ACTIVE';
        $subscriptionArray['RETRY_STATUS'] = 'ON';
        $subscriptionArray['SERVICE_ID'] = $service;
        $subscriptionArray['DND_STATUS'] = 'OFF';
       $renewalServices->_recordData("tbl_renewal_middleware", $subscriptionArray);
    }
    else{//update subscription mark active
    $renewalArray = [];
    $renewalArray['RENEWAL_STATUS'] = 'ACTIVE';
    $renewalArray['ACTIVITY_STATUS'] = 'ACTIVE';
    $renewalArray['DND_STATUS'] = 'OFF';
    $where = "MSISDN";
    $value = $msisdn;
    $serviceID = $service;
    $renewalServices->_updateSubscription("tbl_renewal_middleware",$where, $value, $serviceID,$renewalArray);
    }


   $renewalServices->closeDB();
    
    
}    
    
}

if($activityType==="UNSUBSCRIPTION"){


    $renewalArray = [];

    $renewalArray['RENEWAL_STATUS'] = 'INACTIVE';
    $renewalArray['ACTIVITY_STATUS'] = 'INACTIVE';
    $renewalArray['DND_STATUS'] = 'ON';
    $where = "MSISDN";
    $value = $msisdn;
    $serviceID = $service;

    $renewalServices->_updateSubscription("tbl_renewal_middleware",$where, $value, $serviceID,$renewalArray);
    $renewalServices->closeDB();
}

if($activityType==="SUBSCRIPTION"){
    $isEmpty = $renewalServices->getSubscriberDetails($msisdn, $service);


    if(empty($isEmpty)){//add to subscription
        $subscriptionArray = [];
        $subscriptionArray['MSISDN'] = $msisdn;
        $subscriptionArray['RENEWAL_STATUS'] = 'ACTIVE';
        $subscriptionArray['ACTIVITY_STATUS'] = 'ACTIVE';
        $subscriptionArray['RETRY_STATUS'] = 'ON';
        $subscriptionArray['SERVICE_ID'] = $service;
        $subscriptionArray['DND_STATUS'] = 'OFF';
       $renewalServices->_recordData("tbl_renewal_middleware", $subscriptionArray);
    }
    else{//update subscription mark active
    $renewalArray = [];
    $renewalArray['RENEWAL_STATUS'] = 'ACTIVE';
    $renewalArray['ACTIVITY_STATUS'] = 'ACTIVE';
    $renewalArray['DND_STATUS'] = 'OFF';
    $where = "MSISDN";
    $value = $msisdn;
    $serviceID = $service;
    $renewalServices->_updateSubscription("tbl_renewal_middleware",$where, $value, $serviceID,$renewalArray);

    }


   $renewalServices->closeDB();
}