<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: April 12 2023
    Description: The categories file for my final Project.
****************/
require('connect.php');
require('authenticate.php');

if(isset($_GET['id'])){
    // Sanitize the id. Like above but this time from INPUT_GET.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parametrized SQL query using the filtered id.
    $query = "SELECT * FROM shoecategory WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    // Execute the SELECT and fetch the single row returned.
    $statement->execute();
    $shoecategory = $statement->fetch();
}
else{
    $id = false; // False if we are not UPDATING
}
        
if($_POST && isset($_POST['name']) && isset($_POST['shoecategory'])) {
    $name_sanitize = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $shoecategory_sanitize = filter_input(INPUT_POST, 'shoecategory', FILTER_SANITIZE_NUMBER_INT);

    if ($_POST['command'] === 'Update Category') {
        $query = "UPDATE shoecategory SET name = :name WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindParam(':name', $name_sanitize);
        $statement->bindParam(':id', $shoecategory_sanitize, PDO::PARAM_INT);
        $statement->execute();

        // Redirect after update.
        header("Location: shoecategories.php");
        exit;
    }

     // Delete
     if($_POST['command'] == "Delete Category") {
        $query = "DELETE FROM shoecategory WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $shoecategory_sanitize, PDO::PARAM_INT);
        $statement->execute();

        // Redirect after delete.
        header("Location: shoecategories.php");
        exit;
    }
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
  <title>The ShoeBuzz Shop - Edit Category</title>
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
    <form class="container form-container" action="edit_category.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h1>Edit Category - <?= $shoecategory['name'] ?? '' ?></h1></legend>
            <div>
            <label for="nameInput">Name</label>
            <input class="u-full-width" type="text" placeholder="Category Name" name="name" value="<?= $shoecategory['name'] ?? '' ?>">
            <input type="hidden" name="shoecategory" value="<?= $shoecategory['id'] ?? '' ?>">
            </div>
            <br><button class="update-btn" type="submit" name="command" value="Update Category" >Update</button>
            <button type="submit" name="command" value="Delete Category" onclick="return confirm('Are you sure you wish to delete this category?')" >Delete</button>
        </fieldset>
    </form>
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