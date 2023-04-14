<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: April 10 2023
    Description: The thank you page file for my final Project after user submits message.
****************/

if(isset($_POST['fullname'])){
    $fullname = "Thanks for reaching out to BuzzStaff, {$_POST['fullname']}";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="css/stylesheet/style.css" rel="stylesheet">
    <title>BuzzStaff Thanks you!</title>
</head>
<body>
    <header id="header" class="fixed-top header-inner-pages">
        <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="index.php">John's ShoeBuzz Shop</a></h1>
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
                <li class="dropdown"><a href="#"><span>Admin</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                    <li><a href="post.php">Post For ShoeShop</a></li>
                    <li><a href="categories.php">Add ShoeCategories</a></li>
                    </ul>
                </li>
                </ul>
            </nav>
        </div>
    </header>
    <h1><?= $fullname ?></h1>
    <h2>Summary Information</h2>
        <h2>The Subject:</h2>
        <h4><?= $_POST['subject'] ?></h4>
        <h2>Email Used:</h2>
        <h4><?= $_POST['email'] ?></h4>
        <h2>Message:</h2>
        <p><?= $_POST['message'] ?><p>
    <h1>BuzzStaff will contact you within 3-5 business days.</h1>

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