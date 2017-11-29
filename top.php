<?php
$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

$path_parts = pathinfo($phpSelf);
?>
<!-- Top of every page -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Regional Recipes </title>

        <meta charset="utf-8">
        <meta name="author" content="Liz Bambury, Julia Beatty, and Sarah McLaughlin">
        <meta name="description" content="Recipes from around the globe">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" 
              href="//<?php print get_current_user(); ?>.w3.uvm.edu/cs008/finalproject/css.css" 
              type="text/css" 
              media="screen">
        <?php
            
            $debug = false;

            if(isset($_GET["debug"])){
                $debug = true;
            }
            
            //path setup
            $domain = '//';
            $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, 'UTF-8');
            $domain .= $server;
            
            if($debug){
                print '<p>php Self: ' . $phpSelf;
                print '<p>Path Parts<pre>';
                print_r($path_parts);
                print '</pre></p>';
            }
            
            //include all libraries
            print PHP_EOL . '<!-- include libraries -->' . PHP_EOL;
            require_once('contact/lib/security.php');
            
            if($path_parts['filename'] == "form"){
                print PHP_EOL . '<!-- include form libraries -->' . PHP_EOL;
                include 'contact/lib/validation-functions.php';
                include 'contact/lib/mail-message.php';
            }
            
            print PHP_EOL . '<!-- finished including libraries -->' . PHP_EOL;
        ?>
    </head>
<?php
print '<body id="' . $path_parts['filename'] . '">';

print '<!-- Start of Body -->';
include('header.php');
include('nav.php');
?>
