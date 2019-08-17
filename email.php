<?php 
	if(isset($_POST["email"])){
         $to_email = $_POST["email"]; 
         $subject = $_POST["subject"]; 
         $body = $_POST["body"];
         $headers = "From: jackienha@jandqsayido.com";
         $from = "jackienha@jandqsayido.com"; 

         if(mail($to_email, $subject, $body, $headers, '-f'.$from))
            echo "Email sent successfully"; 
         else
             echo "Email sending failed";  
    }
?>