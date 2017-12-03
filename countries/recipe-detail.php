<?php
$recipe = "";
if (isset($_GET['recipe'])) {
    $recipe = htmlentities($_GET['recipe'], ENT_QUOTES, "UTF-8");
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

$image_src = "../images/" . $recipe . ".jpg";
include('../top.php');
?>
        <article>
            <h2><?php print $recipe ?></h2>
            <figure class="img-right">
                <img alt="Recipe" src=<?php print $image_src ?>>
                <figcaption>Source</figcaption>
            </figure>
            <h3>Ingredients</h3>
            <ul>
                <li>Ingredient</li>
                <li>Ingredient</li>
                <li>Ingredient</li>
                <li>Ingredient</li>
            </ul>
            <h3>Instructions</h3>
            <ol>
                <li>First step</li>
                <li>Second step</li>
                <li>Third step</li>
            </ol>
        </article>
    </body>
</html>
<?php
include('../footer.php');
?>