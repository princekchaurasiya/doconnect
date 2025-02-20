<?php 

require_once 'log_errors.php';



// Dynamic Page Title & Meta Description
$pageTitle = isset($pageTitle) ? $pageTitle : "Doconnect | Doctor Home Visit at Your Home";
$metaDescription = isset($metaDescription) ? $metaDescription : "Book a doctor home visit quickly and easily with Doconnect.";
$meta_keywords = isset($meta_keywords) ? $meta_keywords : "doctor home visit, home healthcare, medical services";

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-WDB2N5RB');</script>
      <!-- End Google Tag Manager -->

      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      
      <title><?php echo htmlspecialchars($pageTitle); ?></title>
      <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
      <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
      
      <!-- Favicons -->
      <link href="assets/img/favicon.png" rel="icon">

      <!-- Google Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

      <!-- Vendor CSS Files -->
      <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
      <link href="assets/vendor/aos/aos.css" rel="stylesheet">
      <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
      <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
      
      <!-- Custom CSS -->
      <link href="assets/css/main.css" rel="stylesheet">
   </head>
   <body>

      <!-- Google Tag Manager (noscript) -->
      <noscript>
         <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WDB2N5RB" height="0" width="0" style="display:none;visibility:hidden"></iframe>
      </noscript>
      <!-- End Google Tag Manager -->

      <!-- ======= Header ======= -->
      <header id="header" class="header d-flex align-items-center">
         <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
               <!-- Uncomment the line below if you also wish to use an image logo -->
               <!-- <img src="assets/img/transparent-logo.png" class="logo1" alt=""> -->
               <h1 class="logo-heading">Doconnect</h1>
            </a>
            <a href="tel:+918424845423" class="d-lg-none text-white mobile-number">+91 84248 45423</a>

            <nav id="navbar" class="navbar">
               <ul>
                  <li><a href="index.php">Home</a></li>
                  <li><a href="about.php">About</a></li>
                  <li><a href="services.php">Services</a></li>
                  <li><a href="testimonials.php">Testimonials</a></li>
                  <li><a href="team.php">Team</a></li>
                  <li><a href="faqs.php">FAQs</a></li>
                  <li><a href="contact.php">Contact</a></li>
                  <li><a href="blog.php">Blogs</a></li>
                  <li><a href="tel:+918424845423" class="mobile-number">+91 84248 45423</a></li>
               </ul>
            </nav>
            <!-- .navbar -->
            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
         </div>
      </header>
      <!-- End Header -->
