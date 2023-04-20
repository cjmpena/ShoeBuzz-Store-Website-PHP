<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: April 12 2023
    Description: This is to add categories for my final project.
****************/
require('connect.php');
require('authenticate.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //  Build the parameterized SQL query and bind to the above sanitized values.
    $statement = $db->prepare("INSERT INTO shoecategory (name) VALUES (:name)");
    $statement->bindParam(':name', $name);
    $statement->execute();
    
    header("Location: shoecategories.php");
    exit();
}

$query = "SELECT * FROM shoecategory";
$statement = $db->prepare($query);
$statement->execute();

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
  <title>The ShoeBuzz Shop - Create Category</title>
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
    <form action="categories.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h1>Add ShoeCategory</h1></legend>
            <div>
                <label for="nameInput">Name</label>
                <input class="u-full-width" type="text" placeholder="Category Name" name="name">
            </div>
            <br><button class="form-submit-button" type="submit" name="command" value="Create Category" >Create Category</button>
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
</html>
