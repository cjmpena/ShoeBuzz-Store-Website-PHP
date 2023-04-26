<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: April 25 2023
    Description: The error page for when the user didnt input at least 1 character for the postings.

****************/
require('connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ERROR DURING SUBMISSION</title>
    <link rel="icon" href="images/buzzicon.png" type="image/x-icon">
    <link href="css/stylesheet/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
    <header id="header" class="fixed-top header-inner-pages">
        <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="index.php">The ShoeBuzz Shop</a></h1>
            <nav id="navbar" class="navbar">
                <ul class="nav-menu">
                <li><a href="index.php">Main BuzzPage</a></li>
                <li class="dropdown"><a href="#"><span>ShoeShop</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                    <li><a href="shoeshop.php">ShoeShop Page</a></li>
                    <li><a href="shoecategories.php">Categories</a></li>
                    <li><a href="sizing.php">Sizing Comparison</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#"><span>BuzzFeedback</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                    <li><a href="index.php#reviews">Reviews and Comments</a></li>
                    <li><a href="review.php">Leave a Review or Comment!</a></li>
                    </ul>
                </li>
                <li><a href="index.php#contact">Questions? Send us A Message!</a></li>
                <li><a href="#footer">BuzzStaff Contact Information</a></li>
                <li class="dropdown"><a href="#"><span>Admin</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                    <li><a href="post.php">Post For ShoeShop</a></li>
                    <li><a href="categories.php">Add ShoeCategories</a></li>
                    </ul>
                </li>
                <li><a href="#"></li>
                <li><div class="header-nav"><?php require('header.php') ?></div></li>
                </ul>
            </nav>
        </div>
    </header>
    <div>
        <h2>An error occured while processing your post.</h2>
        <h4>Everything needs to be at least 1 character.</h4>
        <h4>Price and Size must have a value</h4>
        <h4>A Category needs to be chosen.</h4>
        <a href="index.php">Return Home</a>
        <br><a href="shoeshop.php">Return ShoeBuzz Shop</a>
    </div> 
    <footer id="footer">
        <div class="footer-top">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 footer-contact">
                                <h4>Contact BuzzStaff</h4>
                                <p>
                                123 Exchange Street <br>
                                Winnipeg, M.B <br>
                                Canada <br><br>
                                <strong>Phone:</strong> +123 456 7891<br>
                                <strong>Email:</strong> info@john.com<br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>