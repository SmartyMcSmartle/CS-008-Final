<?php
$country = "";
if (isset($_GET['country'])) {
    $country = htmlentities($_GET['country'], ENT_QUOTES, "UTF-8");
}
// *** Open data *** //
$debug = false;
if (isset($_GET["debug"])) {
    $debug = true;
}

$myFolder = '../';
$myFileName = 'recipes';
$fileExt = '.csv';
$filename = $myFolder . $myFileName . $fileExt;

if ($debug)
    print '<p>filename is ' . $filename;

$file = fopen($filename, "r");

if ($debug) {
    if ($file) {
        print '<p>File Opened Succesful.</p>';
    } else {
        print '<p>File Open Failed.</p>';
    }
}

// *** Read Data *** //
if ($file) {
    if ($debug)
        print '<p>Begin reading data into an array.</p>';

    // read the header row, copy the line for each header row
    // you have.
    $headers[] = fgetcsv($file);

    if ($debug) {
        print '<p>Finished reading headers.</p>';
        print '<p>My header array</p><pre>';
        print_r($headers);
        print '</pre>';
    }

    // read all the data
    while (!feof($file)) {
        $recipeDetails[] = fgetcsv($file);
    }

    if ($debug) {
        print '<p>Finished reading data. File closed.</p>';
        print '<p>My data array<p><pre> ';
        print_r($recipeDetails);
        print '</pre></p>';
    }
} // ends if file was opened 

fclose($file);
include('../top.php');
?>
<article id="recipes">
    <h2><?php print $country;?> Recipes</h2>
    <?php
        foreach ($recipeDetails as $recipeDetail) {
            if ($country == str_replace(' ', '', $recipeDetail[1])) {
                print '<figure class="recipe"><a class="recipe-link" href="recipe-detail.php?recipe=';
                print str_replace(' ', '', $recipeDetail[0]);
                print '">';
                print '<img class="recipe-link" alt="' . $recipeDetail[0];
                print '" src="../images/' . str_replace(' ', '', $recipeDetail[0]);
                print '.jpg">';
                print '</a><figcaption>' . $recipeDetail[0];
                print '</figcaption></figure>';
            }
        }   
    ?>
</article>
<?php
include('../footer.php');
?>
</body>
</html>

