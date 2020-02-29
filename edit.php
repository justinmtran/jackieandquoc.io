<!DOCTYPE html>
<html lang="en">

<?php 
	require "config.php"; 
	require "modules.php";
    
    // update party's meal and attending options 
    $party = $_POST["party_option"]; 

    foreach($party as $guest){
        if(!empty($guest["AttendeeInfoId"])){
            $attendeeInformationId = $guest["AttendeeInfoId"]; 
    
            if(isset($guest["MealId"]))
                updateMeal($guest["MealId"], $attendeeInformationId); 
            if(isset($guest["AttendingStatusId"]))
                updateAttendingStatus($guest["AttendingStatusId"], $attendeeInformationId); 
        }
    }

    // update party's dietary restriction
    $dietaryRestriction = $_POST["dietaryRestriction"]; 
    $attendeeId = $_POST["attendeeId"]; 

    if(!empty($dietaryRestriction) && !empty($attendeeId)){
        updateDietaryRestriction($attendeeId, $dietaryRestriction); 
    }
?> 