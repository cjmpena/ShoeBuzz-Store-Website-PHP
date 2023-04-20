<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: March 23 2023
    Description: This file creates the post to the John's Shoe Store content.

****************/

require('connect.php');
require('authenticate.php');

// Ordering the list in the order by name.
$query = "SELECT * FROM shoecategory";

$statement = $db->prepare($query);

$statement->execute();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $headline = filter_input(INPUT_POST, 'headline', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'shoecategory', FILTER_SANITIZE_NUMBER_INT);
    $price    = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
    $price    = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
    $size     = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_NUMBER_FLOAT);
    $size     = filter_input(INPUT_POST, 'size', FILTER_VALIDATE_FLOAT);
    $content  = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
        $current_folder = dirname(__FILE__);
        $path_segments  = [$current_folder, $upload_subfolder_name, basename($original_filename)];
        return join(DIRECTORY_SEPARATOR, $path_segments);
    }
        
    function file_is_an_image($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/jpeg', 'image/png'];
        $allowed_file_extensions = ['jpg', 'jpeg', 'png'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = getimagesize($temporary_path)['mime'];
        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
    }
        
    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
        
    if ($image_upload_detected) {
        $image_filename       = $_FILES['image']['name'];
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $new_image_path       = file_upload_path($image_filename);
        
        if (file_is_an_image($temporary_image_path, $new_image_path)) {
            move_uploaded_file($temporary_image_path, $new_image_path);
        }
    }

    // Checks to see if the title and content have at least 1 character.
    if (empty(trim($headline)) || empty(trim($content)) || empty(trim($price))) {
        // Directs user to error page.
        header("Location: error.php");
        exit;
    }
    
    //  Build the parameterized SQL query and bind to the above sanitized values.
    $statement = $db->prepare("INSERT INTO shoes (headline, category_id, price, image, size, content, date) VALUES (:headline, :shoecategory, :price, :image, :size, :content, NOW())");
    $statement->bindParam(':headline', $headline);
    $statement->bindParam(':shoecategory', $category);
    $statement->bindParam(':price', $price);
    $statement->bindParam(':image', $image_filename);
    $statement->bindParam(':size', $size);
    $statement->bindParam(':content', $content);
    $statement->execute();

    header("location: shoeshop.php");
    exit;
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
    <title>The Post Area</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
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
    <div>
        <form action="post.php" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend><h1>Post ShoeShop</h1></legend>
                    <p>
                        <label for="headline">Headline</label>
                        <input type="text" id="headline" name="headline" required>
                    </p>
                    <label for="categoryInput">Category</label>
                    <select class="u-full-width" name="shoecategory" id="category">
                        <option value="">Categories</option>
                        <?php while($row = $statement->fetch()): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php endwhile ?>
                    </select>
                    <p>
                        <label for="price">Price</label>
                        <input type="number" id="price" name="price" required>
                    </p>
                    <p>
                        <label for="size">Size</label>
                        <input type="number" step="0.1" id="size" name="size" required>
                    </p>
                    <p>
                        <label for="content">Description Content</label>
                        <textarea name="content" id="content" required></textarea>
                    </p>
                    <p>
                        <div class="file-container">
                            <div class="file-input">
                                <label for="inputImage">Upload Image</label>
                                <input class="file" id="inputImage" type="file" name="image">
                            </div>
                            <button type="submit" name="command" value="Submit Post">Submit</button>
                        </div>
                    </p>
                </fieldset>
        </form>
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