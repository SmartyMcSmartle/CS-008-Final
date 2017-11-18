<!-- Navigation code --!>
<!-- there needs to be a link to countries, china, france, india, japan, mexico, us, faq, contact us, and about us --!>
<!-- Start of Nav -->
<nav>
    <ol id="plain">
        <?php
            print '<li class = "';
            if($path_parts['filename'] == 'countries'){
                print 'activePage';
            }
            print '">';
            print '<a href="countries.php">Countries</a>';
            print '</li>';
            
            print '<li class = "';
            if($path_parts['filename'] == 'countries'){
                print 'activePage';
            }
            print '">';
            print '<a href="countries.php">Countries</a>';
            print '</li>';
        ?>
    </ol>
</nav>
<!-- End of Nav -->