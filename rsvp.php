<?php 
	require "modules.php";
?>

<?php
	if(isset($_POST['passcode']) && validatePasscode($_POST['passcode'])){
        $passcode = $_POST['passcode'];
        $attendeeId = getAttendeeId($passcode); 

        error_log($attendeeId); 

        $dietaryRestrction = getDietaryRestrction($passcode); 

        $rsvp_form_status = '
            <div class="wow fadeIn">
                <a style="margin-bottom: 20px;" onClick="window.location.reload();" class="btn btn-warning"><i class="fa fa-undo"></i> BACK</a>
                <form id="rsvp-form-status" class="form validate-rsvp-form row">
                    <input hidden name="attendeeId" value="' . $attendeeId . '" />
                    <div class="container">
                        <div class="row">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th hidden>Attendence Information Id</th>
                                        <th>First</th>
                                        <th>Last</th>
                                        <th>Attending</th>
                                        <th>Meal Choice</th>
                                    </tr>
                                </thead>
                                <tbody>';
        $rsvp_form_status .= getPartyOptions($passcode); 
        $rsvp_form_status .= '
                                </tbody>
                            </table>
                            <div class="col col-sm-12">
                                <textarea class="form-control" name="dietaryRestriction" placeholder="Please list any dietary restrctions your party may have here...">' . $dietaryRestrction . '</textarea>
                            </div>		
                            <div class="col col-sm-12 submit-btn">
                                <button class="submit-btn">UPDATE</button>
                                <span id="loader"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></span>
                            </div>
                            <div class="col col-md-12 success-error-message">
                                <div id="success">Thank you</div>
                                <div id="error"> Error occurred while trying to update your RSVP. Please try again later. </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>'; 
        echo $rsvp_form_status; 
    }
?> 