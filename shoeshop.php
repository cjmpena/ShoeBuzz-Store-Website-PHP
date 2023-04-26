<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: April 25 2023
    Description: The shoeshop file for my final Project.
****************/
require('connect.php');

// Set the maximum number of search results per page
$results_per_page = 5;

// Determine the current page number
if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}

// Calculate the limit clause for the SQL query
$offset = ($current_page - 1) * $results_per_page;
$limit_clause = "LIMIT $offset, $results_per_page";

// Check if the form has been submitted
if (isset($_GET['order'])) {
    require('authenticate.php');
    $order = $_GET['order'];
    $limit_clause = "LIMIT " . (($current_page - 1) * $results_per_page) . ", $results_per_page";
    $statement = $db->query("SELECT * FROM shoes ORDER BY $order DESC $limit_clause");
} else {
    $offset = ($current_page - 1) * $results_per_page;
    $limit_clause = "LIMIT $offset, $results_per_page";
    $statement = $db->query("SELECT * FROM shoes ORDER BY id DESC $limit_clause");
}
$shoes = $statement->fetchAll();

// Get the total number of search results
$total_results = $db->query("SELECT COUNT(*) FROM shoes")->fetchColumn();

// Calculate the total number of pages
$total_pages = ceil($total_results / $results_per_page);

// Displaying the current selected order of shoes for the user.
$last_selected = isset($_GET['order']) ? $_GET['order'] : 'headline';

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
    <!-- Shoe ordering for admin -->
    <form method="get" class="search-container">
        <label for="order">Sort by</label>
        <select name="order" id="order">
            <option value="headline" <?php if ($last_selected == 'headline') echo 'selected'; ?>>ShoeName</option>
            <option value="date" <?php if ($last_selected == 'date') echo 'selected'; ?>>Date</option>
            <option value="price" <?php if ($last_selected == 'price') echo 'selected'; ?>>Price</option>
            <option value="size" <?php if ($last_selected == 'size') echo 'selected'; ?>>ShoeSize</option>
        </select>
        <input type="hidden" name="page" value="<?= $current_page ?>">
        <input type="submit">
    </form>
    <!-- Display the search results -->
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
            <!-- Display the pagination links -->
            <?php if ($total_pages > 1): ?>
                <br><div>
                    <?php if ($current_page > 1): ?>
                        <h2><a href="?page=<?= $current_page - 1 ?>&order=<?= $_GET['order'] ?>">Prev</a></h2>
                    <?php endif ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $current_page): ?>
                            <h3><?= $i ?></h3>
                        <?php else: ?>
                            <h2><a href="?page=<?= $i ?>&order=<?= $_GET['order'] ?>"><?= $i ?></a></h2>
                        <?php endif ?>
                    <?php endfor; ?>
                    <?php if ($current_page < $total_pages): ?>
                        <h2><a href="?page=<?= $current_page + 1 ?>&order=<?= $_GET['order'] ?>">Next</a></h2>
                    <?php endif ?>
                </div>
            <?php endif ?>
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
