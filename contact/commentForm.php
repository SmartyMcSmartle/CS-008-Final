<!-- Comment Form !-->

<?php
include('../top.php');
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// We print out the post array so that we can see our form is working.
// if ($debug){ // later you can uncomment the if statement
print '<p>Post Array:</p><pre>';
print_r($_POST);
print '</pre>';
// }
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^
//
// SECTION: 1b Security
$thisURL = $domain . $phpSelf;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^
//
// SECTION: 1c form variables
$email = "";
$comments = "";
$function = "";
$style = "";
$hearFriend = true;
$hearSearch = false;
$hearFacebook = false;
$hearAd = false;
$hearOther = false;
$subscribeYes=true;
$subscribeNo=false;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^
//
// SECTION: 1d form error flags
$emailERROR = false;
$commentsERROR = false;
$functionERROR = false;
$styleERROR = false;
$hearERROR = false;
$totalChecked = 0;
$subscribeERROR=false;
$totalCheckedSubscribe=0;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^
//
// SECTION: 1e misc variables
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();
// array used to hold form values that will be written to a CSV file
$dataRecord = array();
// have we mailed the information to the user?
$mailed = false;

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2a Security
      if (!securityCheck($thisURL)) {
      $msg = '<p>Sorry you cannot access this page.';
      $msg .= 'Security breach detected and reported.</p>';
      die($msg);
      }


      //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
      //
      // SECTION: 2b Sanitize (clean) data
      // remove any potential JavaScript or html code from users input on the
      // form. Note it is best to follow the same order as declared in section 1c * */
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;

    $comments = htmlentities($_POST["txtComments"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $comments;

    $function = htlmentities($_POST["radFunction"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $function;

    $style = htlmentities($_POST["radStyle"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $style;

    if (isset($_POST["chkFriend"])) {
        $hearFriend = true;
        $totalChecked++;
    } else {
        $hearFriend = false;
    }
    $dataRecord[] = $hearFriend;
    if (isset($_POST["chkSearch"])) {
        $hearSearch = true;
        $totalChecked++;
    } else {
        $hearSearch = false;
    }
    $dataRecord[] = $hearSearch;
    if (isset($_POST["chFacebook"])) {
        $hearFacebook = true;
        $totalChecked++;
    } else {
        $hearFacebook = false;
    }
    $dataRecord[] = $hearFacebook;
    if (isset($_POST["chkAd"])) {
        $hearAd = true;
        $totalChecked++;
    } else {
        $hearAd = false;
    }
    $dataRecord[] = $hearAd;
    if (isset($_POST["chkOther"])) {
        $hearOther = true;
        $totalChecked++;
    } else {
        $hearOther = false;
    }
    $dataRecord[] = $hearOther;

    
    if (isset($_POST["chkSubsribeYes"])){
        $subscribeYes=true;
        $totalCheckedSubscribe++;
    }else{
        $subscribeYes = false;
    }    
    $dataRecord[] = $subscribeYes;
    
    if (isset($_POST["chkSubsribeNo"])){
        $subscribeNo=true;
        $totalCheckedSubscribe++;
    }else{
        $subscribeNo = false;
    }    
    $dataRecord[] = $subscribeNo;
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
   // SECTION: 2c Validation
    if ($email == "") {
        $errorMsg[] = 'Please enter your email address';
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = 'Your email address appears to be incorrect.';
        $emailERROR = true;
    }

    if ($comments != "") {
        if (!verifyAlphaNum($comments)) {
            $errorMsg[] = "Your comment appears to have extra characters that are not allowed.";
            $commentsERROR = true;
        }
    }

    if ($function != "Very Poor" AND $function != "Poor" AND $function != "Average" AND $function != "Good" AND $function != "Very Good") {
        $errorMsg[] = "Please choose a level";
        $functionERROR = true;
    }

    if ($style != "Very Poor" AND $style != "Poor" AND $style != "Average" AND $style != "Good" AND $style != "Very Good") {
        $errorMsg[] = "Please choose a level";
        $styleERROR = true;
    }

    if ($totalChecked < 1) {
        $errorMsg[] = "Please choose at least one option";
        $hearERROR = true;
    }

    if($totalCheckedSubscribe<1){
        $errorMsg[] = "Please check Yes or No";
        $subscribeERROR=true;
    }
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
   // SECTION: 2d Process Form - Passed Validation
    if (!$errorMsg) {
        if ($debug)
            print PHP_EOL . '<p>Form is valid</p>';

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        // 
        // SECTION: 2e Save Data
        $myFolder = 'final project/';

        $myFileName = 'recipes';

        $fileExt = '.csv';

        $filename = $myFolder . $myFileName . $fileExt;
        if ($debug)
            print PHP_EOL . '<p>filename is ' . $filename;

        // now we just open the file for append
        $file = fopen($filename, 'a');

        // write the forms informations
        fputcsv($file, $dataRecord);
        // close the file

        fclose($file);


        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        $message = '<h2>Your information from Regional Recipes:</h2>';
        foreach ($_POST as $htmlName => $value) {

            $message .= '<p>';
            $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));
            foreach ($camelCase as $oneWord) {
                $message .= $oneWord . '';
            }

            $message .= ' = ' . htmlentities($value, ENT_QUOTES, "UTF-8") . '</p>';
        }

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        // 
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        $to = $email; // the person who filled out the form
        $cc = '';
        $bcc = '';

        $from = 'Regional Recipes <ebambury@uvm.edu>';

        // subject of mail should make sense to your form
        $subject = 'Your Regional Recipes Confirmation: ';

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    }
}

//##############################################################################
//
// SECTION: 3 Display Form
//
?>

<article id='main'>

    <?php
    //#####################################
    //
    // SECTION 3a.
    //
    // If its the first time coming to the form or there are errors we are going
    // to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { //closing of if marked with: end body submit
        print '<h2>Thank you for providing your information.</h2>';

        print'<p>For your records a copy of this data has ';

        if (!$mailed) {
            print "not ";
        }
        print 'been sent:</p>';
        print '<p>To: ' . $email . '</p>';

        //print $message;
    } else {

        //#################################
        //
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form

        if ($errorMsg) {
            print '<div id="errors">' . PHP_EOL;
            print '<h2>Your form has the following mistakes that need to be fixed.</h2>' . PHP_EOL;
            print '<ol>' . PHP_EOL;

            foreach ($errorMsg as $err) {
                print '<li>' . $err . '</li>' . PHP_EOL;
            }

            print '</ol>' . PHP_EOL;
            print '</div>' . PHP_EOL;
        }

        //#################################
        //
        // SECTION: 3c html form
        ?>

        <form action="<?php print $phpSelf; ?>"
              id="frmRegister"
              method="post">       
            <fieldset class="contact">
                <legend>Contact Information</legend>                   
                <p>
                    <label class="required" for="txtEmail">Email</label>
                    <input
                    <?php if ($emailERROR) print 'class="mistake"'; ?>
                        id="txtEmail"
                        maxlength="45"
                        name="txtEmail"
                        onfocus="this.select()"
                        placeholder="Enter a valid email address"
                        tabindex="120"
                        type="text"
                        value="<?php print $email; ?>"
                        >
                </p>
            </fieldset><!-- ends contact -->

            <fieldset class="textarea">
                <p>
                    <label  class="required" for="txtComments">Comments</label>
                    <textarea <?php if ($commentsERROR) print 'class="mistake"'; ?>
                        id="txtComments" 
                        name="txtComments" 
                        onfocus="this.select()" 
                        tabindex="200"><?php print $comments; ?></textarea>
                </p>
            </fieldset>

            <fieldset class="radio <?php if ($functionERROR) print 'mistake'; ?>">
                <legend>How would you rate the functionality of our site?</legend>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radFunctionVeryPoor"
                               name="radFunction"
                               value="Very Poor"
                               tabindex="572"
                               <?php if ($function == "Very Poor") echo ' checked="checked"'; ?>>
                        Very Poor</label>
                </p>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radFunctionPoor"
                               name="radFunction"
                               value="Poor"
                               tabindex="572"
                               <?php if ($function == "Poor") echo ' checked="checked"'; ?>>
                        Poor</label>
                </p>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radFunctionAverage"
                               name="radFunction"
                               value="Average"
                               tabindex="572"
                               <?php if ($function == "Average") echo ' checked="checked"'; ?>>
                        Average</label>
                </p>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radFunctionGood"
                               name="radFunction"
                               value="Good"
                               tabindex="572"
                               <?php if ($function == "Good") echo ' checked="checked"'; ?>>
                        Good</label>
                </p>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radFunctionVeryGood"
                               name="radFunction"
                               value="Very Good"
                               tabindex="572"
                               <?php if ($function == "Very Good") echo ' checked="checked"'; ?>>
                        Very Good</label>
                </p>
            </fieldset>

            <fieldset class="radio <?php if ($styleERROR) print 'mistake'; ?>">
                <legend>How would you rate the style of our site?</legend>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radStyleVeryPoor"
                               name="radStyle"
                               value="Very Poor"
                               tabindex="572"
                               <?php if ($style == "Very Poor") echo ' checked="checked"'; ?>>
                        Very Poor</label>
                </p>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radStylePoor"
                               name="radStyle"
                               value="Poor"
                               tabindex="572"
                               <?php if ($style == "Poor") echo ' checked="checked"'; ?>>
                        Poor</label>
                </p>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radStyleAverage"
                               name="radStyle"
                               value="Average"
                               tabindex="572"
                               <?php if ($style == "Average") echo ' checked="checked"'; ?>>
                        Average</label>
                </p>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radStyleGood"
                               name="radStyle"
                               value="Good"
                               tabindex="572"
                               <?php if ($style == "Good") echo ' checked="checked"'; ?>>
                        Good</label>
                </p>
                <p>
                    <label class="radio-field">
                        <input type="radio"
                               id="radStyleVeryGood"
                               name="radStyle"
                               value="Very Good"
                               tabindex="572"
                               <?php if ($style == "Very Good") echo ' checked="checked"'; ?>>
                        Very Good</label>
                </p>
            </fieldset>

            <fieldset class="checkbox <?php if ($hearERROR) print ' mistake'; ?>">
                <legend>How did you hear about this site? (Please choose at least one and check all that apply)</legend>
                <p>
                    <label class="check-field">
                        <input <?php if ($hearFriend) print "checked"; ?>
                            id="chkFriend"
                            name="chkFriend"
                            tabindex="420"
                            type="checkbox"
                            value="Friend">Friend</label>
                </p>
                <p>
                    <label class="check-field">
                        <input <?php if ($hearSearch) print "checked"; ?>
                            id="chkSearch"
                            name="chkSearch"
                            tabindex="420"
                            type="checkbox"
                            value="Search">Search</label>
                </p>
                <p>
                    <label class="check-field">
                        <input <?php if ($hearFacebook) print "checked"; ?>
                            id="chkFacebook"
                            name="chkFacebook"
                            tabindex="420"
                            type="checkbox"
                            value="Facebook">Facebook</label>
                </p>
                <p>
                    <label class="check-field">
                        <input <?php if ($hearAd) print "checked"; ?>
                            id="chkAd"
                            name="chkAd"
                            tabindex="420"
                            type="checkbox"
                            value="Ad">Ad</label>
                </p>
                <p>
                    <label class="check-field">
                        <input <?php if ($hearOther) print "checked"; ?>
                            id="chkOther"
                            name="chkOther"
                            tabindex="420"
                            type="checkbox"
                            value="Other">Other</label>
                </p>
            </fieldset>
            
            <fieldset class="checkbox <?php if ($subscribeERROR) print 'mistake';?>">
                    <legend>Would you like to subscribe to our Regional Recipes email list?</legend>
                    <p>
                        <label class="check-field">
                            <input <?php if($subscribeYes) print "checked"; ?>
                                id="chkSubscribeYes"
                                name="chkSubscribeYes"
                                tabindex="420"
                                type="checkbox"
                                value="Yes">Yes</label>
                    </p>
                    <p>
                        <label class="check-field">
                            <input <?php if($subscribeNo) print "checked"; ?>
                                id="chkSubscribeNo"
                                name="chkSubscribeNo"
                                tabindex="420"
                                type="checkbox"
                                value="No">No</label>
                    </p>
            </fieldset>
            
            <fieldset class="buttons">
                    <legend></legend>
                    <input class="button" id="btnSubmit" name="btnSubmit" tabindex="900" type="submit" value="Register">
            </fieldset><!-- ends buttons -->
        </form>

        <?php
    } // end body submit
    ?>

</article>
<?php include '../footer.php';?>
</body>
</html>



