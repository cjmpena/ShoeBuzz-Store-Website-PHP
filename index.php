<?php
/*******w******** 
    
    Name: Carla Manansala
    Date: April 12 2023
    Description: The index file for my final Project.
****************/

require('connect.php');

$statement = $db->query("SELECT * FROM review ORDER BY id DESC LIMIT 5");
$review = $statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>The ShoeBuzz Store</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/buzzicon.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="css/stylesheet/style.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="smoothscroll.js"></script>
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-inner-pages">
    <div class="container d-flex align-items-center justify-content-between">
      <h1 class="logo"><a href="index.php">The ShoeBuzz Shop</a></h1>
      <nav id="navbar" class="navbar">
        <ul class="nav-menu">
          <li><a href="index.php" class='active'>Main BuzzPage</a></li>
          <li class="dropdown"><a href="#"><span>ShoeShop</span> <i class="bi bi-chevron-right"></i></a>
            <ul>
              <li><a href="shoeshop.php">ShoeShop Page</a></li>
              <li><a href="shoecategories.php">Categories</a></li>
              <li><a href="sizing.php">Sizing Comparison</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>BuzzFeedback</span> <i class="bi bi-chevron-right"></i></a>
            <ul>
              <li><a href="#reviews">Reviews and Comments</a></li>
              <li><a href="review.php">Leave a Review or Comment!</a></li>
            </ul>
          </li>
          <li><a href="#contact">Questions? Send us A Message!</a></li>
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
  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
      <div class="carousel-inner" role="listbox">
        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url(css/img/slide/slide1.jpg)">
          <div class="carousel-container">
            <div class="container">
              <h2>Welcome to the <span>ShoeBuzz Shop</span></h2>
              <h3>By: Carla Jane Manansala</h3>
              <p>In the heart of downtown Winnipeg, this shop is for shoe lovers and shoe collectors who want to connect with other sneaker heads in the community.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="reviews">
      <div class="section-title">
      <h3>Reviews and Comments from the <span>Buzz</span>Customers</h3>
      <?php foreach($review as $reviews): ?>
          <br><h2><a href="reviewadmin.php?id=<?= $reviews['id'] ?>"> From BuzzCustomer: <?= $reviews['name'] ?></a></h2>
          <div>
            <p><?= $reviews['comment'] ?></p>
          </div>
          <small>
            <?= date("F d, Y, g:i a", strtotime($reviews['date'])) ?>
          </small>
          <br>
        <?php endforeach ?>
      </div>
  </section>

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact section-bg">
      <div class="container-fluid">

        <div class="section-title">
          <h2>Contact</h2>
          <h3>Get In Touch With The <span>Buzz</span></h3>
          <p>For in-person purchases and questions about any shoes, please fill out form a form or call the store.</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-xl-10">
            <div class="row">

              <div class="col-lg-6">

                <div class="row justify-content-center">

                  <div class="col-md-6 info d-flex flex-column align-items-stretch">
                    <i class="bx bx-map"></i>
                    <h4>Address</h4>
                    <p>123 Exchange Street,<br>Winnipeg, M.B</p>
                  </div>
                  <div class="col-md-6 info d-flex flex-column align-items-stretch">
                    <i class="bx bx-phone"></i>
                    <h4>Call Us</h4>
                    <p>+123 456 7891</p>
                  </div>
                  <div class="col-md-6 info d-flex flex-column align-items-stretch">
                    <i class="bx bx-envelope"></i>
                    <h4>Email Us</h4>
                    <p>contact@John.com<br>info@John.com</p>
                  </div>
                  <div class="col-md-6 info d-flex flex-column align-items-stretch">
                    <i class="bx bx-time-five"></i>
                    <h4>Working Hours</h4>
                    <p>Mon - Fri: 12PM to 9PM</p>
                  </div>
                </div>

              </div>
            <div class="col-lg-6">
                <form class="php-email-form center-form" action="thankyou.php" method="post">
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="fullname">Your Name</label>
                      <input type="text" name="fullname" class="form-control" id="fullname" required>
                    </div>
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                      <label for="email">Your Email</label>
                      <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                  </div>
                  <div class="form-group mt-3">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control" name="subject" id="subject" required>
                  </div>
                  <div class="form-group mt-3">
                    <label for="message">Message</label>
                    <textarea class="form-control" name="message" rows="8" required></textarea>
                  </div>
                  <div class="text-center"><button type="submit">Send Message</button></div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

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