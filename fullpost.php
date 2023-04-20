<?php

/*******w******** 
    
    Name: Carla Manansala
    Date: March 23 2023
    Description: The fullpost php file for the final project this page is displayed when you click a 
    read more link if post content is more than 200 characters.

****************/

require('connect.php');
// Use the $db object to query the blog table
$post_id = $_GET['id'];
$statement = $db->prepare("SELECT * FROM shoes WHERE id = :id");
$statement->execute(array(':id' => $post_id));
$shoes = $statement->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="icon" href="images/buzzicon.png" type="image/x-icon">
<link href="css/stylesheet/style.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<title>The ShoeBuzz Shop</title>
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
    <div class="section-title">
        <?php if(empty($shoes)): ?>
            <h4>No content submitted</h4>
        <?php else: ?>
        <div class="blog_post">
            <br><h2><a href="edit.php?id=<?= $shoes['id'] ?>"><?= $shoes['headline'] ?></a></h2>
            <h3>$<?= $shoes['price'] ?></h3>
            <h4>Size <?= $shoes['size'] ?></h4>
            <?php if(!empty($shoes['image'])): ?>
                <div class="thumbnail-container">
                    <img class="shoe-thumbnail" src="uploads/<?= $shoes['image'] ?>" alt="<?= $shoes['headline'] ?>">
                </div>
            <?php endif ?> 
            <p>
                <small>
                    Posted at: <?= date("F d, Y, g:i a", strtotime($shoes['date'])) ?>
                </small>
            </p>
            <div class='blog_content'><?= $shoes['content'] ?></div>
        </div>
        <?php endif ?>
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