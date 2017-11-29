<!-- Navigation code -->
<!-- there needs to be a link to countries, china, france, india, japan, mexico, us, faq, contact us, and about us -->
<!-- Start of Nav -->
<nav>
    <?php
    if ($path_parts['filename'] == 'index') {
        print 'activePage';
    }
    print '<a href="../general/index.php">Home</a>';

    if ($path_parts['filename'] == 'china') {
        print 'activePage';
    }
    print '<a href="../countries/country-detail.php?country=China">China</a>';

    if ($path_parts['filename'] == 'france') {
        print 'activePage';
    }
    print '<a href="../countries/country-detail.php?country=France">France</a>';

    if ($path_parts['filename'] == 'india') {
        print 'activePage';
    }
    print '<a href="../countries/country-detail.php?country=India">India</a>';

    if ($path_parts['filename'] == 'japan') {
        print 'activePage';
    }
    print '<a href="../countries/country-detail.php?country=Japan">Japan</a>';

    if ($path_parts['filename'] == 'mexico') {
        print 'activePage';
    }
    print '<a href="../countries/country-detail.php?country=Mexico">Mexico</a>';

    if ($path_parts['filename'] == 'us') {
        print 'activePage';
    }
    print '<a href="../countries/country-detail.php?country=USA">USA</a>';

    if ($path_parts['filename'] == 'faq') {
        print 'activePage';
    }
    print '<a href="../countries/country-detail.php?country=FAQ">FAQ</a>';

    if ($path_parts['filename'] == 'contact') {
        print 'activePage';
    }
    print '<a href="../countries/country-detail.php?country=About Us">Contact Us</a>';

    if ($path_parts['filename'] == 'about') {
        print 'activePage';
    }
    print '<a href="../countries/country-detail.php?country=About Us">About Us</a>';
    ?>
</nav>
<!-- End of Nav -->