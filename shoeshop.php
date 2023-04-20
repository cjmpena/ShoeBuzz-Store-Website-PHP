<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: April 12 2023
    Description: The shoeshop file for my final Project.
****************/

require('connect.php');

$statement = $db->query("SELECT * FROM shoes ORDER BY id DESC LIMIT 20");
$shoes = $statement->fetchAll();

// Check if the form has been submitted
if (isset($_GET['order'])) {
    $order = $_GET['order'];
    $statement = $db->query("SELECT * FROM shoes ORDER BY $order DESC LIMIT 20");
} else {
    $statement = $db->query("SELECT * FROM shoes ORDER BY id DESC LIMIT 20");
}
$shoes = $statement->fetchAll(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/stylesheet/style.css" rel="stylesheet">
    <link rel="icon" href="images/buzzicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="smoothscroll.js"></script>
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
    <form method="get" class="search-container">
        <label for="order">Sort by:</label>
        <select name="order" id="order">
            <option value="headline">ShoeName</option>
            <option value="date">Date</option>
            <option value="price">Price</option>
            <option value="size">ShoeSize</option>
        </select>
        <input type="submit">
    </form>
    <?php if(empty($shoes)): ?>
        <h4>No content submitted.</h4>
    <?php else: ?>
        <div class="section-title">
            <?php foreach($shoes as $shoess): ?>
                <br><h2><a href="edit.php?id=<?= $shoess['id'] ?>"><?= $shoess['headline'] ?></a></h2>
                <h3>$<?= $shoess['price'] ?></h3>
                <h4>Size <?= $shoess['size'] ?></h4>
                <div>
                    <?php if(!empty($shoess['image'])): ?>
                        <div class="thumbnail-container">
                            <img class="shoe-thumbnail" src="uploads/<?= $shoess['image'] ?>" alt="<?= $shoess['headline'] ?>">
                        </div>
                    <?php endif ?>
                    <?php $truncated_content = substr($shoess['content'], 0, 200) . '...'; ?>
                    <?php if(strlen($shoess['content']) > 200 ): ?>
                        <p><?= $truncated_content ?></p><h2><a href= "fullpost.php?id=<?= $shoess['id'] ?>">Full Post</a></h2>
                    <?php else: ?>
                        <p><?= $shoess['content'] ?></p>
                        <small>
                            Posted at: <?= date("F d, Y, g:i a", strtotime($shoess['date'])) ?>
                        </small>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    <!-- ======= Footer ======= -->
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
