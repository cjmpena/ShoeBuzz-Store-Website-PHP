<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: March 19 2023
    Description: The index file for my final Project.
****************/

require('connect.php');
require('authenticate.php');

if($_POST && isset($_POST['name']) && isset($_POST['comment']) && isset($_POST['id'])){
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $name       = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comment    = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id         = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Delete
    if($_POST['command'] == "Delete"){
        $query    = "DELETE FROM review WHERE id = :id";
        $statment = $db->prepare($query);
        $statment->bindValue(':id', $id, PDO::PARAM_INT);
        $statment->execute();
    
        // Redirect after delete.
        header("Location: index.php#reviews");
        exit;
    }
}
 
if(isset($_GET['id'])){
    // Sanitize the id. Like above but this time from INPUT_GET.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    // Build the parametrized SQL query using the filtered id.
    $query = "SELECT * FROM review WHERE id = :id";
    $statment = $db->prepare($query);
    $statment->bindValue(':id', $id, PDO::PARAM_INT);
    
    // Execute the SELECT and fetch the single row returned.
    $statment->execute();
    $reviews = $statment->fetch();
}
else{
    $id = false; // False if we are not UPDATING
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/buzzicon.png" type="image/x-icon">
    <link href="css/stylesheet/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <title>Review Edit</title>
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
    <div>
        <form action="reviewadmin.php" method="post">
            <fieldset>
                <legend><h1>Customer Reviews</h1></legend>
                <p>
                    <label for="name">Name</label>
                    <input name="name" id="name" value="<?= $reviews['name'] ?>">
                </p>
                <p>
                    <label for="comment">Comment</label>
                    <textarea name="comment" id="comment"><?= $reviews['comment'] ?></textarea>
                </p>
                <p>
                    <input type="hidden" name="id" value="<?= $reviews['id'] ?>" />
                    <button type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" >Delete</button>
                </p>
            </fieldset>
        </form>
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