<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: April 14 2023
    Description: The search file for my final Project.
****************/
require('connect.php');

// Start the session
session_start();

// Set the maximum number of search results per page
$results_per_page = 5;

// Determine the current page number
if (isset($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}

$keyword  = filter_input(INPUT_GET, 'keyword', FILTER_SANITIZE_STRING);
$shoecategory = filter_input(INPUT_GET, 'shoecategory', FILTER_VALIDATE_INT);

$query = "SELECT COUNT(*) FROM shoe WHERE name LIKE :keyword";
$params = array(':keyword' => "%$keyword%");

// Store the search parameters in session variables
if (!empty($keyword)) {
    $_SESSION['keyword'] = $keyword;
} else {
    $_SESSION['keyword'] = '';
}

if (!empty($shoecategory)) {
    $_SESSION['shoecategory'] = $shoecategory;
} else {
    $_SESSION['shoecategory'] = '';
}

// Retrieve the search parameters from the session
$keyword_session = $_SESSION['keyword'];
$shoecategory_session = $_SESSION['shoecategory'];

// Calculate the limit clause for the SQL query
$offset = ($current_page - 1) * $results_per_page;
$limit_clause = "LIMIT $offset, $results_per_page";

if (!empty($shoecategory_session)) {
    $query = "SELECT * FROM shoes WHERE category_id = '$shoecategory_session' AND headline LIKE '%{$keyword_session}%' ORDER BY price DESC";
} else {
    $query = "SELECT * FROM shoes WHERE headline LIKE '%{$keyword_session}%'  ORDER BY price DESC";
}

$statement = $db->prepare($query . " $limit_clause");
$statement->execute();

// Get the total number of search results
$total_results = $db->query($query)->rowCount();
// Calculate the total number of pages
$total_pages = ceil($total_results / $results_per_page);

/*
echo "Current page: " . $current_page . "<br>";
echo "Shoe category: " . $shoecategory_session . "<br>";
echo "Keyword: " . $keyword_session . "<br>";*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="css/stylesheet/style.css" rel="stylesheet">
  <title>The ShoeBuzz Shop - Shoe Search Results</title>
</head>
<body>
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
            </ul>
        </nav>
        </div>
    </header>
    <div class="section-title">
        <?php if ($statement->rowCount() > 0): ?>
            <?php if ($keyword !== ""): ?>
                <h1>Search "<?= $keyword ?>" has <?= $total_results ?> result(s).</h1>
            <?php else: ?>
                <h1>Search has <?= $total_results ?> result(s).</h1>
            <?php endif ?>
            <?php while($row = $statement->fetch()): ?>
                <br><h2><a href="edit.php?id=<?= $row['id'] ?>"><?= $row['headline'] ?></a></h2>
                <h3>$<?= $row['price'] ?></h3>
                <h4>Size <?= $row['size'] ?></h4>
                <div>
                    <?php if(!empty($row['image'])): ?>
                        <div class="thumbnail-container">
                            <img class="shoe-thumbnail" src="uploads/<?= $row['image'] ?>" alt="<?= $row['headline'] ?>">
                        </div>
                    <?php endif ?>
                    <?php $truncated_content = substr($row['content'], 0, 200) . '...'; ?>
                    <?php if(strlen($row['content']) > 200 ): ?>
                        <p><?= $truncated_content ?></p><h2><a href= "fullpost.php?id=<?= $row['id'] ?>">Full Post</a></h2>
                    <?php else: ?>
                        <p><?= $row['content'] ?></p>
                        <small>
                            Posted at: <?= date("F d, Y, g:i a", strtotime($row['date'])) ?>
                        </small><br>
                    <?php endif ?>
                </div>
            <?php endwhile ?>
            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($current_page > 1): ?>
                        <br><h2><a href="?page=<?= $current_page - 1 ?>&shoecategory=<?= $shoecategory_session ?>&keyword=<?= $keyword_session ?>">Prev</a></h2>
                    <?php endif ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $current_page): ?>
                            <h3><span class="current-page"><?= $i ?></span></h3>
                        <?php else: ?>
                            <h2><a href="?page=<?= $i ?>&shoecategory=<?= $shoecategory_session ?>&keyword=<?= $keyword_session ?>"><?= $i ?></a></h2>
                        <?php endif ?>
                    <?php endfor ?>
                    <?php if ($current_page < $total_pages): ?>
                        <h2><a href="?page=<?= $current_page + 1 ?>&shoecategory=<?= $shoecategory_session ?>&keyword=<?= $keyword_session ?>">Next</a></h2>
                    <?php endif ?>
                </div>
            <?php endif ?>
            <?php else: ?>
                <p>No results found.</p>
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