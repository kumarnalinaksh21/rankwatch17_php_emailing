<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title>Email Sending page using PHP and Mandrill</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <script src="js/jquery.js"></script>
    </head>
    <style>
        body{
               background-color: turquoise;
        }
    </style>
    <body align="center">
        <?php
        
        //adding Mandrill api to project
        include ("lib/Mandrill.php");
        $mandrill = new Mandrill('IhqXOqeaVARbruHDCZ0kGw');
        
        /* the api key is working, however the mail would be rejected because the dns, spf & dkim couldn't be verified and added to Gmail, and I have no other domain which  I can register with Mandrill.
        
        The procedure works flawlessly, and the code works too.It can be seen from the fact that the rejected mails from smtp shows on  the rejected statistics of the api
        */
        
        //initialisation of variables
        $senders_name = "";
        $senders_email = "";
        $name_reciever = "";
        $email_receiver = "";
        $type_of_email = "";
        $subject_of_email = "";
        $type_of_message = "";
        $message_box = "";
        
        $message = array();
        $to = array();
        
        if (isset($_POST['senders_email'])) {
            $senders_email = $_POST['senders_email'];
        }
        if (isset($_POST['email_receiver'])) {
            $email_receiver = $_POST['email_receiver'];
        }
        if (isset($_POST['subject_of_email'])) {
            $subject_of_email = $_POST['subject_of_email'];
        }
        if (isset($_POST['type_of_message'])) {
            $type_of_message = $_POST['type_of_message'];
        }
        if (isset($_POST['message_box'])) {
            $message_box = $_POST['message_box'];
        }
        $to[] = array(
            'email' => $email_receiver,
            'name' => $name_reciever, 
            'type' => $type_of_email 
        );
        $message['subject'] = $subject_of_email;
        $message[$type_of_message] = $message_box;
        $message['from_email'] = $senders_email;
        $message['to'] = $to;
        if(isset($to[0]['email']) && $to[0]['email'] !== ""){
        $result = $mandrill->messages->send($message);
        $status = $result[0]['status'];
        }       
        ?>

        <div style="margin-left:35%;" id="main">
            <h1 align="center" style="margin-left:5%;">Email interface<br>Mandrill API Using PHP</h1>
            <div align="center" id="login">
                <h2>Message Box</h2>
                <hr>
                <form action="" method="POST">
                    <h3>From : </h3>
                  <label>Sender's Email Address : </label> <input type="email" name="senders_email" class="senders_email" placeholder="sender@xyz.com"/>
                    <h3>To : </h3>
                    <label>Receiver's Email Address : </label> <input type="email" name="email_receiver" class="email_receiver" placeholder="receriver@abc.com"/>
                 
                    <label>Subject : </label>
                    <input type="text" name="subject_of_email" class="" placeholder="Subject: ...."/>
                    
                    <label>Message : </label> 
                    <input type="radio" name="type_of_message" value="text" checked="checked"/><label>text</label>
                    <input type="radio" name="type_of_message" value="html"/><label>html</label>
                    
                    <textarea name="message_box" rows="10" cols="30">Dear Sir, ............</textarea>
                    <input type="submit" value="Click here too send !" id="submit"/>
                </form>
            </div>

            <div id="note">
                <?php
                if (isset($status)){
                    if($status == "sent") {
                    echo "<script>alert('Message has ben sent successfully!!!')</script>";
                } elseif($status == "rejected") {
                    echo "<script>alert('Sorry!!! Message recieved at MAndrill, but can not be delivered, Please verify your DNS, SPF and DKIM. The key is correct')</script>";
                }
                }
                ?>
            </div>
        </div>
        <script>
  jQuery(document).ready(function() {
                jQuery("#submit").click(function() {
                    var senders_email = jQuery('.senders_email').val();
                    var email_receiver = jQuery('.email_receiver').val();
                    if (senders_email == "") {
                        alert('Empty email of sender !!!!');
                    }
                     if (email_receiver == "") {
                        alert('Empty receriver email : whom shall we sendd?');
                    }
                });
            });
        </script>
    </body>
</html>


