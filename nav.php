<!-- Navigation code --!>
<!-- there needs to be a link to countries, china, france, india, japan, mexico, us, faq, contact us, and about us --!>
<!-- Start of Nav -->
<nav>
    <ol>
        <?php
        if ($path_parts['filename'] == 'China') {
            print 'activePage';
        }
        print '<a href="countries/china/china.php">China</a>';

        if ($path_parts['filename'] == 'France') {
            print 'activePage';
        }
        print '<a href="countries/france/france.php">France</a>';

        if ($path_parts['filename'] == 'India') {
            print 'activePage';
        }
        print '<a href="countries/india/india.php">India</a>';

        if ($path_parts['filename'] == 'Japan') {
            print 'activePage';
        }
        print '<a href="countries/japan/japan.php">Japan</a>';

        if ($path_parts['filename'] == 'Mexico') {
            print 'activePage';
        }
        print '<a href="countries/mexico/mexico.php">Mexico</a>';

        if ($path_parts['filename'] == 'USA') {
            print 'activePage';
        }
        print '<a href="countries/us/us.php">USA</a>';

        if ($path_parts['filename'] == 'FAQ') {
            print 'activePage';
        }
        print '<a href="faq.php">FAQ</a>';

        if ($path_parts['filename'] == 'Contact Us') {
            print 'activePage';
        }
        print '<a href="contact/contact.php">Contact Us</a>';

        if ($path_parts['filename'] == 'About Us') {
            print 'activePage';
        }
        print '<a href="about.php">About Us</a>';
        ?>
    </ol>
</nav>
<!-- End of Nav -->