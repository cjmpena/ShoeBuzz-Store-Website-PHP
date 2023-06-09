<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: April 14 2023
    Description: The fullpage file for my final Project.
****************/
require('connect.php');

$query = "SELECT * FROM shoes ORDER BY headline LIMIT 5";
$statement = $db->prepare($query);
$statement->execute();

if (isset($_GET['shoecategory'])) {
  $category_id = $_GET['shoecategory'];
  $query = "SELECT * FROM shoes WHERE category_id = :category_id";
  $statement = $db->prepare($query);
  $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
  $statement->execute();

   // Fetch the category name
   $category_query = "SELECT name FROM shoecategory WHERE id = :category_id";
   $category_statement = $db->prepare($category_query);
   $category_statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
   $category_statement->execute();
   $shoecategory = $category_statement->fetch();
} else {
  // Redirect to the shoecategory.php page if no category is selected
  header("Location: shoecategory.php");
  exit();
}

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
                </ul>
            </nav>
        </div>
    </header>
    <div class="section-title">
        <h1>Shoes In Category - <?= $shoecategory['name'] ?></h1>
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
