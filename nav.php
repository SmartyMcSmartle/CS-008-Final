<!-- Navigation code --!>
<!-- there needs to be a link to countries, china, france, india, japan, mexico, us, faq, contact us, and about us --!>
<!-- Start of Nav -->
<nav>
    <?php
    if ($path_parts['filename'] == 'china') {
        print 'activePage';
    }
    print '<a href="countries/china/china.php">China</a>';

    if ($path_parts['filename'] == 'france') {
        print 'activePage';
    }
    print '<a href="countries/france/france.php">France</a>';

    if ($path_parts['filename'] == 'india') {
        print 'activePage';
    }
    print '<a href="countries/india/india.php">India</a>';

    if ($path_parts['filename'] == 'japan') {
        print 'activePage';
    }
    print '<a href="countries/japan/japan.php">Japan</a>';

    if ($path_parts['filename'] == 'mexico') {
        print 'activePage';
    }
    print '<a href="countries/mexico/mexico.php">Mexico</a>';

    if ($path_parts['filename'] == 'us') {
        print 'activePage';
    }
    print '<a href="countries/us/us.php">USA</a>';

    if ($path_parts['filename'] == 'faq') {
        print 'activePage';
    }
    print '<a href="faq.php">FAQ</a>';

    if ($path_parts['filename'] == 'contact') {
        print 'activePage';
    }
    print '<a href="contact/contact.php">Contact Us</a>';

    if ($path_parts['filename'] == 'about') {
        print 'activePage';
    }
    print '<a href="about.php">About Us</a>';
    ?>
</nav>
<!-- End of Nav -->