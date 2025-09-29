<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSS Link  -->
     <link rel="stylesheet" href="Styles/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Header Section  -->

    <section id="MainSec">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="index.php"><img src="Img/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav m-auto">
                    <li class="nav-item active">
                      <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="about.php">About Us</a>
                      </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Shop</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categories
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Organic Foods</a>
                        <a class="dropdown-item" href="#">Sea Foods</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Fast Foods</a>
                      </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="contact.php">Contact</a>
                    </li>                    
                  </ul>
                  <div class="navButton">
                    <a href="login.html" class="btn btn-primary login">Log In</a>
                    <a href="register.html" class="btn btn-primary signup">Sign Up</a>
                  </div>
                </div>
              </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="mainTextBox">
                        <h1>
                            Crafting your <br>Exceptional Dining <br> <span>Reservations</span>
                        </h1>
                        <p>
                            Reservation is a step into a world of gastronomic wonder. Reserve your table
                            today and let us paint your culinary dreams into reality.
                        </p>
                    </div>
                    <div class="mainButtonBox">
                        <a href="#featuredProductsSec" class="btn btn-primary">Explore Menu</a>
                    </div>
                    
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
    </section>

      <!-- Header Section End  -->
       <!-- Categories Section Start -->
<section id="categoriesSec">
  <div class="container">
    <div class="row">      
      <h1>Our Categories</h1>
    </div>
      <div class="row ">
          <div class="col-md-4">
              <div class="categoryBox text-center">
                  <img src="Img/organic.png" alt="Organic Foods Icon" class="categoryIcon">
                  <h3 class="categoryTitle">Organic Foods</h3>
                  <p class="categoryDesc">Discover the freshest and healthiest organic foods for a balanced diet.</p>
              </div>
          </div>
          <div class="col-md-4">
              <div class="categoryBox text-center">
                  <img src="Img/seafoods.png" alt="Sea Foods Icon" class="categoryIcon">
                  <h3 class="categoryTitle">Sea Foods</h3>
                  <p class="categoryDesc">Dive into a variety of delicious and sustainable sea foods.</p>
              </div>
          </div>
          <div class="col-md-4">
              <div class="categoryBox text-center">
                  <img src="Img/fastfoods.png" alt="Fast Foods Icon" class="categoryIcon">
                  <h3 class="categoryTitle">Fast Foods</h3>
                  <p class="categoryDesc">Indulge in quick and tasty fast food options for your busy lifestyle.</p>
              </div>
          </div>
      </div>
  </div>
</section>
<!-- Categories Section End -->
 <!-- Promo banner starts  -->
  <section id="promoBanner">
    <div class="container">
      <div class="row promoBox">
        <div class="col-md-6">
          <img src="Img/burger.png" alt="Burger" class="promoImg">
        </div>
        <div class="col-md-6">
          <img src="Img/chickenBurger.png" alt="" class="promoImg">
        </div>
      </div>
    </div>
  </section>
  <!-- Promo Banner Ends  -->

 <!-- Featured Products Section Start -->
<section id="featuredProductsSec">
    <div class="container">
        <div class="row">      
            <h1>Featured Products</h1>
        </div>
        <div class="row">

            <?php
            // Include database connection
            include 'db_connect.php';

            // Query to fetch products
            $query = "SELECT * FROM menu_items LIMIT 6"; // Limit to 6 products for example
            $result = $conn->query($query);

            // Loop through fetched products
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4">';
                echo '<div class="productBox text-center">';
                echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="Product Image" class="productImage">'; // Display product image
                echo '<h3 class="productTitle">' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p class="productDesc">' . htmlspecialchars($row['description']) . '</p>';
                echo '<p class="productPrice">$' . htmlspecialchars($row['price']) . '</p>';
                echo '<div class="productButtonBox">';
                echo '<a href="product.php?product_id=' . $row['item_id'] . '" class="btn btn-primary">View Details</a>'; // Link to product details page
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            // Close database connection
            $conn->close();
            ?>

        </div>
    </div>
</section>
<!-- Featured Products Section End -->
 <!-- Newsletter Section Start -->
<section id="newsletterSec">
  <div class="container text-center">
      <h2 class="newsletterTitle">Subscribe to Our Newsletter</h2>
      <p class="newsletterDesc">Stay updated with the latest news, special offers, and exclusive content. Join our community today!</p>
      <form class="newsletterForm">
          <input type="email" class="form-control emailInput" placeholder="Enter your email" required>
          <button type="submit" class="btn btn-primary submitButton">Subscribe</button>
      </form>
  </div>
</section>
<!-- Newsletter Section End -->




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>