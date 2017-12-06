<!-- Navigation code -->
<!-- there needs to be a link to countries, china, france, india, japan, mexico, us, faq, contact us, and about us -->
<!-- Start of Nav -->
<nav>
    <?php
    print '<a class="mainlinks" href="../general/index.php">Home</a>';
    
    print '<a class="mainlinks" href="../countries/countries.php">Countries</a>';
    
    print '<a class="sublinks" href="../countries/country-detail.php?country=China">China</a>';

    print '<a class="sublinks" href="../countries/country-detail.php?country=France">France</a>';

    print '<a class="sublinks" href="../countries/country-detail.php?country=India">India</a>';

    print '<a class="sublinks" href="../countries/country-detail.php?country=Japan">Japan</a>';

    print '<a class="sublinks" href="../countries/country-detail.php?country=Mexico">Mexico</a>';

    print '<a class="sublinks" href="../countries/country-detail.php?country=USA">USA</a>';

    print '<a class="mainlinks" href="../general/faq.php">FAQ</a>';

    print '<a class="mainlinks" href="../contact/contact.php">Contact Us</a>';

    print '<a class="sublinks" href="../contact/recipeForm.php">Add a Recipe</a>';
    
    print '<a class="sublinks" href="../contact/subscriptionForm.php">Subscribe</a>';

    print '<a class="sublinks" href="../contact/commentForm.php">Comments</a>';

    print '<a class="mainlinks" href="../general/about.php">About Us</a>';
    ?>
</nav>
<!-- End of Nav -->