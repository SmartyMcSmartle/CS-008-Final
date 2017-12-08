<!-- Recipe Form !-->

<?php
include('../top.php');
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// We print out the post array so that we can see our form is working.
// if ($debug){ // later you can uncomment the if statement
//print '<p>Post Array:</p><pre>';
//print_r($_POST);
//print '</pre>';
// }
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^
//
// SECTION: 1b Security
$thisURL = $domain . $phpSelf;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^
//
// SECTION: 1c form variables
$email = "";
$subscribeYes = true;
$recipeName = "";
$recipeInfo = "";
$recipeType = "";
$recipeRegion = "";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^
//
// SECTION: 1d form error flags
$emailERROR = false;
$subscribeERROR = false;
$totalCheckedSubscribe = 0;
$recipeNameERROR = false;
$recipeInfoERROR = false;
$recipeTypeERROR = false;
$recipeRegionERROR = false;

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
    // form. Note it is best to follow the same order as declared in section 1c
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;

    if (isset($_POST["chkSubsribeYes"])){
        $subscribeYes=true;
        $totalCheckedSubscribe++;
    }else{
        $subscribeYes = false;
    }    
    $dataRecord[] = $subscribeYes;

    $recipeName = htmlentities($_POST["txtRecipeName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $recipeName;

    $recipeInfo = htmlentities($_POST["txtRecipeInfo"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $recipeInfo;
    
    $recipeType = htmlentities($_POST["lstRecipeType"],ENT_QUOTES,"UTF-8");    
    $dataRecord[] = $recipeType;
    
    $recipeRegion = htmlentities($_POST["radRecipeRegion"],ENT_QUOTES,"UTF-8");    
    $dataRecord[] = $recipeRegion;   
    
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
   // SECTION: 2c Validation
    if ($email == ""){
        $errorMsg[] = 'Please enter your email address';
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = 'Your email address appears to be incorrect.';
        $emailERROR = true;
    }

     if ($recipeName == "") {
        $errorMsg[] = 'Please enter a name for the recipe';
        $recipeNameERROR = true;
    }
    
    if ($recipeInfo != "") {
        if (!verifyAlphaNum($recipeInfo)) {
            $errorMsg[] = "Your comment appears to have extra characters that are not allowed.";
            $recipeInfoERROR = true;
        }
    }
    
    if ($recipeType == "") {
        $errorMsg[] = 'Please choose what type of recipe this is';
        $recipeTypeERROR = true;
    }
    
    if ($recipeRegion != "China" AND $recipeRegion != "France" AND $recipeRegion != "India" AND $recipeRegion != "Japan" AND $recipeRegion != "Mexico" AND $recipeRegion != "US"){
        $errorMsg[] = "Please choose a region";
        $recipeRegionERROR = true;
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    }
    //
   // SECTION: 2d Process Form - Passed Validation
    if (!$errorMsg) {
        if ($debug)
            print PHP_EOL . '<p>Form is valid</p>';

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        // 
        // SECTION: 2e Save Data
        $myFolder = '../';

        $myFileName = 'form';

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
        $bcc = 'ebambury@uvm.edu';

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
    <h2>Have a recipe you want to share with us? Please fill out this form to tell us about it!</h2>
        <form action="<?php print $phpSelf; ?>"
              id="frmRegister"
              method="post">       
            <fieldset class="contact">                  
                <p>
                    <label class="required" for="txtEmail">Email</label>
                    <input
                    <?php if ($emailERROR) print 'class="mistake"'; ?>
                        id="txtEmail"
                        maxlength="45"
                        name="txtEmail"
                        onfocus="this.select()"
                        placeholder=""
                        tabindex="120"
                        type="text"
                        value="<?php print $email; ?>"
                        >
                </p>
            </fieldset><!-- ends contact -->
   
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
            </fieldset>
            
            <fieldset class="name">
                <legend>Recipe Name</legend>                   
                <p>
                    <label class="required" for="txtRecipeName"></label>
                    <input
                    <?php if ($recipeNameERROR) print 'class="mistake"'; ?>
                        id="txtRecipeName"
                        maxlength="45"
                        name="txtRecipeName"
                        onfocus="this.select()"
                        placeholder=""
                        tabindex="120"
                        type="text"
                        value="<?php print $recipeName; ?>"
                        >
                </p>
            </fieldset>
            
            <fieldset class="info">
                <p>
                    <label  class="required" for="txtRecipeInfo">Recipe Ingredients and Instructions</label>
                </p>
                <p>    
                    <textarea <?php if ($recipeInfoERROR) print 'class="mistake"'; ?>
                        id="txtRecipeInfo" 
                        name="txtRecipeInfo" 
                        onfocus="this.select()" 
                        tabindex="200"
                        rows="4"
                        cols="75"><?php print $recipeInfo; ?></textarea>
                </p>
            </fieldset>
            
            <fieldset class="listbox <?php if ($recipeTypeERROR) print 'mistake'; ?>">
                <legend>What type of recipe is this?</legend>
                    <p>
                        <select id="lstRecipeType"
                                name="lstRecipeType"
                                tabindex="520">
                            <option <?php if($recipeType=="Breakfast") print "selected"; ?>
                                value="Breakfast">Breakfast</option>
                            <option <?php if($recipeType=="Lunch") print "selected"; ?>
                                value="Lunch">Lunch</option>
                            <option <?php if($recipeType=="Dinner") print "selected"; ?>
                                value="Dinner">Dinner</option>
                            <option <?php if($recipeType=="Appetizer") print "selected"; ?>
                                value="Appetizer">Appetizer</option>
                            <option <?php if($recipeType=="Dessert") print "selected"; ?>
                                value="Dessert">Dessert</option>
                            <option <?php if($recipeType=="Snack") print "selected"; ?>
                                value="Snack">Snack</option>
                            <option <?php if($recipeType=="Other") print "selected"; ?>
                                value="Other">Other</option>
                        </select>
                </p>
            </fieldset>
            
            <fieldset class="radio <?php if ($recipeRegionERROR) print 'mistake'; ?>">
                    <legend>What region is your recipe from?</legend>
                    <p>
                        <label class="radio-field">
                            <input type="radio"
                                   id="radRecipeRegionChina"
                                   name="radRecipeRegion"
                                   value="China"
                                   tabindex="572"
                                   <?php if ($recipeRegion == "China") echo ' checked="checked" '; ?>>
                            China</label>
                    </p>                   
                    <p>
                        <label class="radio-field">
                            <input type="radio"
                                   id="radRecipeRegionFrance"
                                   name="radRecipeRegion"
                                   value="France"
                                   tabindex="572"
                                   <?php if ($recipeRegion == "France") echo ' checked="checked" '; ?>>
                            France</label>
                    </p>
                    <p>
                        <label class="radio-field">
                            <input type="radio"
                                   id="radRecipeRegionIndia"
                                   name="radRecipeRegion"
                                   value="India"
                                   tabindex="572"
                                   <?php if ($recipeRegion == "India") echo ' checked="checked" '; ?>>
                            India</label>
                    </p>
                    <p>
                        <label class="radio-field">
                            <input type="radio"
                                   id="radRecipeRegionJapan"
                                   name="radRecipeRegion"
                                   value="Japan"
                                   tabindex="572"
                                   <?php if ($recipeRegion == "Japan") echo ' checked="checked" '; ?>>
                            Japan</label>
                    </p>                    
                    <p>
                        <label class="radio-field">
                            <input type="radio"
                                   id="radRecipeRegionMexico"
                                   name="radRecipeRegion"
                                   value="Mexico"
                                   tabindex="572"
                                   <?php if ($recipeRegion == "Mexico") echo ' checked="checked" '; ?>>
                            Mexico</label>
                    </p>
                    <p>
                        <label class="radio-field">
                            <input type="radio"
                                   id="radRecipeRegionUS"
                                   name="radRecipeRegion"
                                   value="US"
                                   tabindex="572"
                                   <?php if ($recipeRegion == "US") echo ' checked="checked" '; ?>>
                            US</label>
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
