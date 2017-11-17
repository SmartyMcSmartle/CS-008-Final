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

        <link rel="stylesheet" href="css.css" type="text/css" media="screen">
    </head>
<?php
print '<body id="' . $path_parts['filename'] . '">';

print '<!-- Start of Body -->';
include('header.php');
include('nav.php');
?>
