<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: March 23 2023
    Description: This file creates the post to the John's Shoe Store content.

****************/

require('connect.php');

if ($_POST && isset($_POST['name']) && isset($_POST['comment'])) {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // Checks to see if the title and content has at least 1 character.
    if(strlen($name) < 1 || strlen($comment) < 1){
        // directs user to error page 
        header("location: error.php");
        exit;
    }

  // Checks to see if the title and content have at least 1 character.
  if (empty(trim($name)) || empty(trim($comment))) {
    // Directs user to error page.
    header("Location: error.php");
    exit;
  }

  // If submit is executed the content will be put into the database and posted on the index page.
  if ($_POST['command'] == "Submit Post") {
    //  Build the parameterized SQL query and bind to the above sanitized values.
    $statement = $db->prepare("INSERT INTO review (name, comment, date) VALUES (:name, :comment, NOW())");
    $statement->bindParam(':name', $name);
    $statement->bindParam(':comment', $comment);
    $statement->execute();

    header("Location: index.php#reviews");
    exit();
    }
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="smoothscroll.js"></script>
    <title>The ShoeBuzz Shop - Review</title>
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
    <div id="content">
        <form action="review.php" method="post">
          <fieldset>
            <legend><h1>Leave a Review!</h1></legend>
            <p>
              <label for="name">Name</label>
              <input type="text" id="name" name="name" required>
            </p>
            <p>
              <label for="comment">Comment</label>
              <textarea name="comment" id="comment" required></textarea>
            </p>
            <p>
              <button type="submit" name="command" value="Submit Post">Submit</button>
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