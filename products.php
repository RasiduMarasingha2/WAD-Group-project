<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$conn = getDB();
$result = $conn->query("SELECT id, name, description, content, price, link FROM products");
$products = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>


<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SkillSprint</title>
  <link rel="stylesheet" href="products.css" />
  <link rel="icon" href="images/logo1.png" type="image/png" style="width: auto;height: inherit;">
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="logo" style="color:#636ae8  ;"> SkillSprint<span></span></div>
   
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a  href="index.php#about-us" >About Us</a></li>
        <li><a href="products.php" class="active">Courses</a></li>
        <li><a href= "index.php#contact-us">Contact</a></li>
      </ul>
    </nav>
  </header>


  <section class="hero">
    <h1>Explore Our Courses..</h1>
    <p>Upgrade your skills. Transform your future with SkillSprint.</p>
  </section>


  <section class="featured">
    <img src="images/logo1.png" alt="Featured Image" class="featured-img" />
    <div class="featured-content">
      <span class="tag">Featured Post</span>
      <h2>Unlocking the Future: AI in Everyday Applications</h2>
      <p>Explore how artificial intelligence is seamlessly integrating into our daily lives, from smart home devices to personalized recommendations, revolutionizing convenience and efficiency.</p>
      <p class="meta">📅 2024-03-15 &nbsp; | &nbsp; ⏱ 7 min read</p>
      <button class="read-more"><a href="#" style="text-decoration: double; color: white;">Read More</a></button>
    </div>
  </section>

  <section class="categories">
    <h3>Categories</h3>
    <div class="category-tags">
      <span>All</span>
      <span>Innovation</span>
      <span>Development</span>
      <span>Cybersecurity</span>
      <span>Future Tech</span>
      <span>Cloud Computing</span>
      <span>Data Science</span>
      <span>Mobile Development</span>
      <span>Blockchain</span>
    </div>
  </section>

 
  <section class="articles">
  <div class="article-grid" id="products-list">
    <?php foreach ($products as $product): ?>
      <?php
        $content = json_decode($product['content'], true);
        $modules = $content['modules'] ?? [];
      ?>
      <article class="course-card-premium">
        <div class="accent-bar"></div>

        <div class="course-img-wrapper">
          <img src="<?php echo htmlspecialchars($product['link']); ?>"
               alt="<?php echo htmlspecialchars($product['name']); ?>"
               loading="lazy">
          <div class="img-overlay"></div>
        </div>

        <div class="course-body">
          <header class="course-header">
            <h3 class="course-title">
              <?php echo htmlspecialchars($product['name']); ?>
            </h3>
            <div class="price-badge">
              Rs.<?php echo number_format($product['price']); ?>
            </div>
          </header>

          <p class="course-desc">
            <?php echo htmlspecialchars($product['description']); ?>
          </p>

          <?php if ($modules): ?>
            <ul class="course-modules">
              <?php foreach (array_slice($modules, 0, 3) as $mod): ?>
                <li>
                  <svg class="mod-icon" viewBox="0 0 16 16" fill="currentColor">
                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm1 12H7v-2h2v2zm0-3H7V5h2v4z"/>
                  </svg>
                  <?php echo htmlspecialchars($mod); ?>
                </li>
              <?php endforeach; ?>
              <?php if (count($modules) > 3): ?>
                <li class="more">+<?php echo count($modules) - 3; ?> more modules</li>
              <?php endif; ?>
            </ul>
          <?php endif; ?>

          <div class="course-actions">
            <a href="buy.php?id=<?php echo $product['id']; ?>" class="btn-buy-pulse">
              Buy Now
            </a>
            <a href="#" class="btn-view">
              View Details
            </a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

  
  <footer>
    <div class="footer-top">
      <h3>Stay Updated with SkillSprint Insights</h3>
      <p>Subscribe to our newsletter for the latest tech trends, product updates, and expert insights.</p>
      <div class="subscribe">
        <input type="email" placeholder="Enter your email address" />
        <button>Subscribe</button>
      </div>
    </div>

    <div class="footer-bottom">
      <h4>SkillSprint</h4>
      <p>© 2025 SkillSprint. All rights reserved.</p>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php#about-us">About Us</a></li>
        <li><a href="index.php#contact-us">Contact</a></li>
      </ul>
    </div>
  </footer>
</body>
</html>