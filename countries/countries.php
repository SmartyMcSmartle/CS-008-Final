<?php
// *** Open country data *** //
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

// *** Read country Data *** //
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
        $countryDetails[] = fgetcsv($file);
    }

    if ($debug) {
        print '<p>Finished reading data. File closed.</p>';
        print '<p>My data array<p><pre> ';
        print_r($countryDetails);
        print '</pre></p>';
    }
} // ends if file was opened 

fclose($file);
include('../top.php');
?>
<article id="countries">
    <h2>Countries</h2>
        <?php
        $lastCountry = "";
        foreach ($countryDetails as $countryDetail) {
            if ($lastCountry != $countryDetail[1]) {
                print '<figure class="country"><a class="country-link" href="country-detail.php?country=';
                print str_replace('_', ' ', $countryDetail[1]);
                print '">';
                print '<img class="country-link" alt="'. $countryDetail[1];
                print '" src="../images/';
                print str_replace(' ', '_', $countryDetail[1]);
                print '.jpg">';
                print '</a>';
                print '<figcaption>';
                $countryimgsource;
                if($countryDetail[1] == 'China') {
                    $countryimgsource = "https://yullow.files.wordpress.com/2015/02/cropped-6797128-great-wall-of-china-wallpaper.jpg";
                }
                else if($countryDetail[1] == 'France'){
                    $countryimgsource = "https://2.bp.blogspot.com/-YNpI71_jAPY/WgADv8HHd0I/AAAAAAAABTI/-WIB965enN8YR4EyxS1Z2oZaV0e8D1XXACPcBGAYYCw/s1600/eiffel.jpg";
                }
                else if($countryDetail[1] == 'India'){
                    $countryimgsource = "http://pic.qyer.com/album/user/1170/55/QEhSQh8CZE0/index/680x";
                }
                else if($countryDetail[1] == 'Japan'){
                    $countryimgsource = "https://travel.gaijinpot.com/wp-content/uploads/sites/6/2016/01/Wakayama.jpg";
                }
                else if($countryDetail[1] == 'Mexico'){
                    $countryimgsource = "https://hypb.imgix.net/image/2017/06/mexico-city-0.jpg?q=90&amp%3Bauto=compress%2Cformat";
                }
                else if($countryDetail[1] == 'USA'){
                    $countryimgsource = "https://mickeysdreamvacationsbylissy.files.wordpress.com/2016/02/adventures-by-disney-north-america-san-francisco-long-weekend-hero-01-golden-gate-bridge.jpg?w=611";
                }
                print $countryDetail[1];
                print '</br><span>' . $countryimgsource . '</span>';
                print '</figcaption></figure>';
                $lastCountry = $countryDetail[1];
            }
        }
        ?>
</article>
<?php
include('../footer.php');
?>
</body>
</html>

