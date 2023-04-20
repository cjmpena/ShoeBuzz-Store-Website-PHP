<?php

/*******w******** 
    
    Name: Carla Manansala
    Date: April 13 2023
    Description: The edit page for the user to make changes within the ShoeShop page.

****************/
require('connect.php');
require('authenticate.php');

$query = "SELECT * FROM shoecategory";
$statement = $db->prepare($query);
$statement->execute();

if($_POST && isset($_POST['headline']) && isset($_POST['shoecategory']) && isset($_POST['price']) && isset($_POST['content']) && isset($_POST['id'])){
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $headline   = filter_input(INPUT_POST, 'headline', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category   = filter_input(INPUT_POST, 'shoecategory', FILTER_SANITIZE_NUMBER_INT);
    $price      = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
    $price      = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
    $size       = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_NUMBER_FLOAT);
    $size       = filter_input(INPUT_POST, 'size', FILTER_VALIDATE_FLOAT);
    $content    = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id         = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    // Checks if length of headline and content is above 1 character if not form exits.
    if (empty(trim($headline)) || empty(trim($content)) || empty(trim($price))) {
        // Directs user to error page.
        header("Location: error.php");
        exit;
    }

    // Update
    if($_POST['command'] == "Update"){
        $query    = "UPDATE shoes SET headline = :headline, category_id = :shoecategory, price = :price, size = :size, content = :content WHERE id = :id";
        $statment = $db->prepare($query);
        $statment->bindValue(':headline', $headline);
        $statment->bindParam(':shoecategory', $category); 
        $statment->bindValue(':price', $price);
        $statment->bindValue(':size', $size); 
        $statment->bindValue(':content', $content);
        $statment->bindValue(':id', $id, PDO::PARAM_INT);
        $statment->execute();
        
        // Redirect after update.
        header("Location: shoeshop.php?id={$id}");
        exit;
    }
    // Delete
    if($_POST['command'] == "Delete"){
        $query    = "DELETE FROM shoes WHERE id = :id";
        $statment = $db->prepare($query);
        $statment->bindValue(':id', $id, PDO::PARAM_INT);
        $statment->execute();
    
        // Redirect after delete.
        header("Location: shoeshop.php");
        exit;
    }
}
 
if(isset($_GET['id'])){
    // Sanitize the id. Like above but this time from INPUT_GET.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    // Build the parametrized SQL query using the filtered id.
    $query = "SELECT * FROM shoes WHERE id = :id";
    $statment = $db->prepare($query);
    $statment->bindValue(':id', $id, PDO::PARAM_INT);
    
    // Execute the SELECT and fetch the single row returned.
    $statment->execute();
    $shoess = $statment->fetch();
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
    <title>Edit Mode!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
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
        <form action="edit.php" method="post">
            <fieldset>
                <legend><h1>Edit ShoeBuzz Posts</h1></legend>
                <p>
                    <label for="headline">Headline</label>
                    <input name="headline" id="headline" value="<?= $shoess['headline'] ?>">
                </p>
                <p>
                    <label for="price">Price</label>
                    <input name="price" id="price" value="<?= $shoess['price'] ?>">
                </p>
                <p>
                    <label for="size">Size</label>
                    <input name="size" id="size" step="0.1" value="<?= $shoess['size'] ?>">
                </p>
                <div class="row">
                    <label for="categoryInput">Category</label>
                    <select class="u-full-width" name="shoecategory" id="categoryInput">
                        <option value="">Shoe Category</option>
                        <?php while($row = $statement->fetch()): ?>
                            <?php if ($row['id'] === $shoess['category_id']): ?>
                                <option selected="selected" value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                            <?php else: ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                            <?php endif ?>
                        <?php endwhile ?>
                    </select>
                </div>
                <p>
                    <label for="content">Content</label>
                    <textarea name="content" id="content"><?= $shoess['content'] ?></textarea>
                </p>
                <p>
                    <input type="hidden" name="id" value="<?= $shoess['id'] ?>" />
                    <button class="update-btn" type="submit" name="command" value="Update" >Update</button>
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