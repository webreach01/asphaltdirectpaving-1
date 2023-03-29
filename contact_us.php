<?php
//include 'MailConfig.php';

if(isset($_POST['submit'])){
//print_r($_POST);exit;
  $fname= $_POST['name'];
  $email= $_POST['email'];
  $phone= $_POST['mobile'];
  $msg = $_POST['message'];
  $subject_message = $_POST['subject'];

    $to = 'hetal.r@msp-group.co.uk';
    //$to = 'jayesh.m@msp-group.co.uk';
   // $to = 'nainajain3192@gmail.com';
    $subject = 'Contact Form';           
    $message = '<HTML>
        <body>
        <div style="font-size:15px">
          <div bgcolor="#e5e5e1" style="margin:0;padding:0">
          <p>Dear Naina,</p>
          <table style="border-collapse: separate; border-spacing: 0; color: #4a4a4d; width: 100%; max-width: 600px; font: 14px/1.4 , Helvetica, Arial, sans-serif;border-collapse: separate; border-spacing: 0; color: #4a4a4d; width: 100%; max-width: 600px; font-size: 14px/1.4 , Helvetica, Arial, sans-serif; border: 1px solid #3669a0;">
          <tbody>
          <tr>
              <td colspan="3" style="text-align:center;border-bottom:1px solid #3669a0;background: #3669a0; color: #fff;font-weight:bold;font-size:20px;">Contact Details</td>
          </tr>
          <tr>
          <th style="padding: 10px 15px; vertical-align: middle; font-weight: bold; border-bottom: 1px solid #3669a0; border-right: 1px solid #3669a0; text-align: left;" colspan="2" scope="col">Name</th>
          <td style="padding: 10px 15px; vertical-align: middle; border-bottom: 1px solid #3669a0;" scope="col">'. $fname.'</td>
          </tr>
          <tr>
          <th style="padding: 10px 15px; vertical-align: middle; font-weight: bold; border-bottom: 1px solid #3669a0; border-right: 1px solid #3669a0; text-align: left;" colspan="2" scope="col">Email</th>
          <td style="padding: 10px 15px; vertical-align: middle; border-bottom: 1px solid #3669a0;" scope="col">'. $email.'</td>
          </tr>         
          <tr>
          <th style="padding: 10px 15px; vertical-align: middle; font-weight: bold; border-bottom: 1px solid #3669a0; border-right: 1px solid #3669a0; text-align: left;" colspan="2" scope="col">Mobile</th>
          <td style="padding: 10px 15px; vertical-align: middle; border-bottom: 1px solid #3669a0;" scope="col">'.$phone.'</td>
          </tr>
          <tr>
          <th style="padding: 10px 15px; vertical-align: middle; font-weight: bold; border-bottom: 1px solid #3669a0; border-right: 1px solid #3669a0; text-align: left;" colspan="2" scope="col">Subject</th>
          <td style="padding: 10px 15px; vertical-align: middle; border-bottom: 1px solid #3669a0;" scope="col">'.$subject_message.'</td>
          </tr>
          <tr>
          <th style="padding: 10px 15px; vertical-align: middle; font-weight: bold; border-bottom: 1px solid #3669a0; border-right: 1px solid #3669a0; text-align: left;" colspan="2" scope="col">Message</th>
          <td style="padding: 10px 15px; vertical-align: middle; border-bottom: 1px solid #3669a0;" scope="col">'.$msg.'</td>
          </tr>
          </tbody>
          </table>
          <p>Thank you</p>
          </div>
        </div>
        </body>
        </html>';

         $status = email("Nainayoga",$to,$message,$subject,"","","");
          
        echo json_encode(['success'=>$status]);
         exit;
      
    }
   // email("","jitendra.p@msp-group.co.uk","dgdfg","","","",""); 
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

// // Load Composer's autoloader

//use PHPMailer\PHPMailer\PHPMailer;

// Instantiation and passing `true` enables exceptions
function email($name,$to,$message,$subject,$customer='',$mail_cc='',$attachment='')
{
    //echo "SDfsdf";
//     echo getcwd();
// exit;

// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
    // include 'PHPMailer/vendor/autoload.php';
  require(getcwd()."/PHPMailer/src/PHPMailer.php");
  require(getcwd()."/PHPMailer/src/SMTP.php");

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

		//$mail = new PHPMailer(true);
  // exit;

    try {
        if(!empty($mail_cc)){
            $ccs = explode(',',$mail_cc);
        }
        else{
            $ccs = '';
        }
        
        $from_name  = 'Test';
        $from       = 'jitendra.p@msp-group.co.uk';
       // $from = 'info@nainayoga.in';
        $to_name = $name;
        
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.ionos.co.uk';                    // Set the SMTP server to send through
		    $mail->SMTPDebug  = 0;							// enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'jitendra.p@msp-group.co.uk';                     // SMTP username
        $mail->Password   = 'M$p@2022';                               // SMTP password
        $mail->SMTPSecure = "tls";
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;    

                                   // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom($from, $from_name);
        $mail->addAddress($to, $to_name);     // Add a recipient
      
        if(isset($ccs) && $ccs!='')
        {
            foreach($ccs as $cc)
            {
               $mail->AddCC($cc, $to_name);
            }
        }
        if(!empty($attachment)){
            //$filePath = dirname(__FILE__);
            $attachments = explode(',',$attachment);
            foreach($attachments as $attachment){
                $mail->AddAttachment($attachment);
            }
        }

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
       //  echo 'Message has been sent';
       return 1;
    } catch (PHPMailer\PHPMailer\Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return 0;
    }
}