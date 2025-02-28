<?php
include 'db-connect.php'; 

// 🔍 Define log file path
$logFile = "C:/xampp/htdocs/doconnect/logs.txt";
error_log("🔍 location.php started at " . date('Y-m-d H:i:s') . "\n", 3, $logFile);

// Get the location slug from the URL
// $slug = isset($_GET['slug']) ? trim($_GET['slug']) : null;
// error_log("🔍 Received slug: " . ($slug ?: 'No slug') . "\n", 3, $logFile);



// Default variables
$city = 'Mumbai';
$locality = 'Oshiwara';

// if (!empty($slug) && $conn) {
//     error_log("🔎 Checking database for slug: $slug\n", 3, $logFile);
    
//     $stmt = $conn->prepare("SELECT city, locality FROM locations WHERE slug = ?");
//     $stmt->bind_param("s", $slug);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $location = $result->fetch_assoc();

//     if ($location) {
//         $city = $location['city'];
//         $locality = $location['locality'];
//         error_log("✅ Found location: $city ($locality)\n", 3, $logFile);
//     } else {
//         error_log("❌ Location NOT found for slug: $slug\n", 3, $logFile);
//         header("Location: /doconnect/index.php"); // Redirect to home if slug is invalid
//         exit();
//     }
//     $stmt->close();
// } else {
//     error_log("❌ Slug is empty or database connection failed.\n", 3, $logFile);
// }

// 🛠 **SEO Meta Tags Optimization** 🛠 //

// Default values
$defaultTitle = "Doctor Home Visit | Expert Medical Care at Your Home";
$defaultDescription = "Get expert doctors for home visits, providing fast, reliable, and personalized healthcare in your city.";
$defaultKeywords = "doctor home visit, home healthcare, medical care at home, home visit doctor";

// **Dynamic Metadata**
// $city = !empty($city) ? " in " . htmlspecialchars($city, ENT_QUOTES, 'UTF-8') : "";
// $locality = !empty($locality) ? " in " . htmlspecialchars($locality, ENT_QUOTES, 'UTF-8') : "";

$title = !empty($locality) ? "Doctor for Home Visit" . $locality : $defaultTitle;
$description = "Looking for a doctor for a home visit" . $locality . "? Our expert doctors provide fast and reliable healthcare services for elderly, bedridden, and chronic patients.";
$keywords = "doctor home visit" . ($locality ? ", doctor home visit in " . htmlspecialchars($locality, ENT_QUOTES, 'UTF-8') : "") .
            ", home healthcare, doctor on call" . ($locality ? " in " . htmlspecialchars($locality, ENT_QUOTES, 'UTF-8') : "") .
            ($locality ? ", home visit doctor in " . htmlspecialchars($locality, ENT_QUOTES, 'UTF-8') : "");


            $locations = [];
            if ($conn) {
                $query = "SELECT city, locality, slug FROM locations ORDER BY city, locality";
                $result = $conn->query($query);
            
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $locations[] = $row;
                    }
                }
            }

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
      <title><?= $title; ?></title>
      <meta name="description" content="<?= $description; ?>">
      <meta name="keywords" content="<?= $keywords; ?>">
      <!-- Favicons -->
      <link href="assets/img/favicon.png" rel="icon">
      <!-- Google Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
      <!-- Vendor CSS Files -->
      <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="assets/icons/style.css" rel="stylesheet">
      <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
      <link href="assets/vendor/aos/aos.css" rel="stylesheet">
      <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
      <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
      <!-- Template Main CSS File -->
      <link href="assets/css/main.css" rel="stylesheet">
   </head>
   <body>

   <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WDB2N5RB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
      <!-- ======= Header ======= -->
      <header id="header" class="header d-flex align-items-center">
         <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
               <!-- Uncomment the line below if you also wish to use an image logo -->
               <!-- <img src="assets/img/transparent-logo.png" class="logo1" alt=""> -->
               <h1 class="logo-heading">Doconnect</h1>
            <a href="tel:+918424845423" class="d-lg-none text-white mobile-number">+91 84248 45423</a>
            </a>
            <nav id="navbar" class="navbar">
               <ul>
                  <li><a href="#hero">Home</a></li>
                  <li><a href="#about">About</a></li>
                  <li><a href="#services">Services</a></li>
                  <li><a href="#testimonials">Testimonials</a></li>
                  <li><a href="#team">Team</a></li>
                  <li><a href="#faqs">FAQs</a></li>
                  <li><a href="#contact">Contact</a></li>
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
      <!-- End Header -->
      <!-- ======= Hero Section ======= -->
      


      <section id="hero" class="hero">
    <div class="container position-relative">
        <div class="row gy-5" data-aos="fade-in">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-start text-start align-self-center">
                <h2>Expert Doctor for Home Visit<?= !empty($locality) ? " in " . htmlspecialchars($locality) : "" ?></h2>
                <p>Fast, reliable, and personalized healthcare at home, including treatments for general, elderly, bedridden, and chronic patients<?= !empty($locality) ? " in " . htmlspecialchars($locality) : "" ?>.</p>
                <div class="d-flex justify-content-start">
                    <a href="tel:+918424845423" class="mobile-number">
                        <?= !empty($locality) ? "Call Now for Home Visit in " . htmlspecialchars($locality) : "Call Now for Home Visit" ?>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 align-items-center">
                <img src="assets/img/doctor-33.png" class="img-fluid align-self-center" 
                     alt="Doctor Home Visit<?= !empty($locality) ? ' in ' . htmlspecialchars($locality) : '' ?>" 
                     data-aos="zoom-out" data-aos-delay="100">
            </div>
        </div>
    </div>
    <div class="icon-boxes position-relative">
        <div class="container position-relative">
            <div class="row gy-4 mt-5">
                <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-box">
                        <div class="icon"><span class="icon-paramedic"></span></div>
                        <h4 class="title">
                            <a href="tel:+918424845423" class="stretched-link">
                                Doctor for Home Visit<?= !empty($locality) ? " in " . htmlspecialchars($locality) : "" ?>
                            </a>
                        </h4>
                        <a href="tel:+918424845423" class="mobile-number px-5 py-4">Call Now</a>
                    </div>
                </div>
                <!--End Icon Box -->
                <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-box">
                        <div class="icon"><span class="icon-woman"></span></div>
                        <h4 class="title">
                            <a href="tel:+918424845423" class="stretched-link">
                                Doctor Check-up at Home<?= !empty($locality) ? " in " . htmlspecialchars($locality) : "" ?>
                            </a>
                        </h4>
                        <a href="tel:+918424845423" class="mobile-number">Call Now</a>
                    </div>
                </div>
                <!--End Icon Box -->
                <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-box">
                        <div class="icon"><span class="icon-stethoscope"></span></div>
                        <h4 class="title">
                            <a href="tel:+918424845423" class="stretched-link">
                                Personalized Medical Care<?= !empty($locality) ? " in " . htmlspecialchars($locality) : "" ?>
                            </a>
                        </h4>
                        <a href="tel:+918424845423" class="mobile-number">Call Now</a>
                    </div>
                </div>
                <!--End Icon Box -->
                <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-box">
                        <div class="icon"><span class="icon-call"></span></div>
                        <h4 class="title">
                            <a href="tel:+918424845423" class="stretched-link">
                                Convenient Home Visits<?= !empty($locality) ? " in " . htmlspecialchars($locality) : "" ?>
                            </a>
                        </h4>
                        <a href="tel:+918424845423" class="mobile-number">Call Now</a>
                    </div>
                </div>
                <!--End Icon Box -->
            </div>
        </div>
    </div>
</section>






      <!-- End Hero Section -->
      <main id="main">
         <!-- ======= About Us Section ======= -->
         <section id="about" class="about">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2>About Us</h2>
            <p>
    Welcome to <span class="fw-bold">Doconnect</span>, where we redefine healthcare by bringing it directly to your home<?= !empty($city) ? " in " . htmlspecialchars($city, ENT_QUOTES, 'UTF-8') : "" ?>. 
    Our mission is to provide accessible and quality medical care through our 
    <span class="fw-bold">doctor for home visit<?= !empty($locality) ? " in " . htmlspecialchars($locality, ENT_QUOTES, 'UTF-8') : "" ?></span> services<?= !empty($city) ? " in " . htmlspecialchars($city, ENT_QUOTES, 'UTF-8') : "" ?>. 
    Whether you’re managing chronic illnesses, recovering from surgery, or simply need a routine check-up, our skilled doctors are here to help. 
    With <span class="fw-bold">Doconnect</span>, you can forget long wait times and travel hassles & get the medical attention you need in the comfort of your own home.
</p>

        </div>
        <div class="row gy-4">
            <div class="col-lg-12 align-self-center">
                <h3>How Doconnect Works</h3>
                <p>
    At <span class="fw-bold">Doconnect</span>, we believe healthcare should be convenient for everyone. 
    Our <span class="fw-bold">doctor on call for home visit<?= !empty($locality) ? " in " . htmlspecialchars($locality, ENT_QUOTES, 'UTF-8') : "" ?></span> 
    service connects you with a highly trained team of doctors<?= !empty($city) ? " in " . htmlspecialchars($city, ENT_QUOTES, 'UTF-8') : "" ?>. 
    Our medical professionals have hospital training, particularly in caring for critically ill patients in the ICU. 
    They specialize in troubleshooting at home, ensuring precise diagnosis in a home setting, 
    which leads to better patient management and treatment outcomes.
</p>

                <p>Our ICU doctors and critical care specialists are dedicated to providing high-level intensive care in the most complex situations. They are equipped to assess and monitor patients’ conditions, order necessary tests for diagnosis, and develop comprehensive treatment plans. With a deep understanding of emergency medicine, our doctors work with you to ensure that nothing is missed, providing life-saving treatments both at home and in coordination with hospital-based teams when required.</p>
                <p>The process is straightforward: simply call us to schedule an appointment, and we’ll take care of the rest. Our team ensures that you receive the personalized care you deserve without the stress of travel.</p>
                <p>Our comprehensive services<?= !empty($locality) ? " in " . htmlspecialchars($locality) : "" ?> include:</p>
                <ul>
                    <li>Nebulisation</li>
                    <li>Sugar Check</li>
                    <li>Injection Administration</li>
                    <li>Dressing / Wound Care</li>
                    <li>Management of Severe Abdominal Pain</li>
                    <li>Relief for Shivering</li>
                    <li>Treatment for High-Grade Fever</li>
                    <li>IV Fluid Therapy</li>
                    <li>Small Stitches</li>
                    <li>Urethral Catheterisation</li>
                    <li>Consultation at Home</li>
                </ul>
                <p>Our team is equipped with the latest medical tools, ensuring that you receive hospital-quality care right at your doorstep<?= !empty($city) ? " in " . htmlspecialchars($city) : "" ?>. We understand that ongoing medical needs often require regular follow-ups, so we provide continuous care management to help you recover faster and stay healthy.</p>
                <p><span class="fw-bold">Who needs home visits?</span></p>
                <p>Home visits are ideal for those facing health issues, elderly individuals needing assistance, or people who cannot visit the doctor due to time constraints or lifestyle commitments. Our home visit service<?= !empty($city) ? " in " . htmlspecialchars($city) : "" ?> is especially beneficial for patients with chronic illnesses such as diabetes who require regular check-ups and care but wish to avoid multiple trips to a clinic. Our board-certified doctors are available 24/7, offering personalized care with one-on-one discussions to address your health needs comprehensively.</p>
                <p>At <span class="fw-bold">Doconnect</span>, we are committed to delivering compassionate, high-quality care tailored to your needs. Our goal is to ensure that you have everything you need to heal comfortably at home<?= !empty($city) ? " in " . htmlspecialchars($city) : "" ?>, whether it's preventive care or critical support. Trust our <span class="fst-italic">doctors for home visit</span> services to be there for you, whenever you need us.</p>
            </div>
        </div>
    </div>
</section>

         <!-- End About Us Section -->
         <!-- ======= Stats Counter Section ======= -->
         <section id="stats-counter" class="stats-counter">
    <div class="container" data-aos="fade-up">
        <div class="row gy-4 align-items-center justify-content-center">
            <div class="col-lg-10">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <img src="assets/img/pie-chart.svg" alt="Doctor for home visit statistics<?= !empty($city) ? ' in ' . htmlspecialchars($city) : '' ?>" class="img-fluid" width="350px">
                    </div>
                    <div class="col-lg-6">
                        <div class="stats-item d-flex align-items-center">
                            <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
                            <p><strong>Home Visits Completed<?= !empty($city) ? ' in ' . htmlspecialchars($city) : '' ?></strong></p>
                        </div>
                        <div class="stats-item d-flex align-items-center">
                            <span data-purecounter-start="0" data-purecounter-end="153" data-purecounter-duration="1" class="purecounter"></span>
                            <p><strong>Successful Doctor Consultations<?= !empty($city) ? ' in ' . htmlspecialchars($city) : '' ?></strong></p>
                        </div>
                        <div class="stats-item d-flex align-items-center">
                            <span data-purecounter-start="0" data-purecounter-end="226" data-purecounter-duration="1" class="purecounter"></span>
                            <p><strong>Chronic Care Patients Managed at Home<?= !empty($city) ? ' in ' . htmlspecialchars($city) : '' ?></strong></p>
                        </div>
                        <div class="stats-item d-flex align-items-center">
                            <span data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1" class="purecounter"></span>
                            <p><strong>Urgent Care Home Visits Completed<?= !empty($city) ? ' in ' . htmlspecialchars($city) : '' ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

         <!-- End Stats Counter Section -->
         <!-- ======= Our Services Section ======= -->
         <section id="services" class="services sections-bg">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2>Our Services<?= !empty($locality) ? ' in ' . htmlspecialchars($locality) : '' ?></h2>
            <p>At Doconnect, we specialize in bringing medical care to the comfort of your home<?= !empty($locality) ? ' in ' . htmlspecialchars($locality) : '' ?>. Whether you need help with managing chronic conditions, urgent care for high-grade fever, or wound care, our doctors and healthcare professionals are here to provide expert medical services right at your doorstep.</p>
        </div>
        <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
            <?php
            $services = [
                "home-visit" => [
                    "icon" => "icon-paramedic",
                    "title" => "Doctor for Home Visit",
                    "description" => "Book an appointment with a doctor for a home visit.",
                    "features" => ["Nebulisation for respiratory issues.", "BP check to monitor blood pressure.", "Injection administration for medication delivery."],
                    "cta" => "Call Now for Home Visit"
                ],
                "sugar-check" => [
                    "icon" => "icon-blood-test",
                    "title" => "Sugar Check",
                    "description" => "Get your blood sugar levels checked at home.",
                    "features" => ["Convenient testing for diabetes management.", "Quick results for timely interventions.", "Professional support for your health."],
                    "cta" => "Call Now for Sugar Check"
                ],
                "wound-care" => [
                    "icon" => "icon-plaster",
                    "title" => "Dressing & Wound Care",
                    "description" => "Comprehensive wound care services at home.",
                    "features" => ["Dressing and wound care for various injuries.", "Small stitches for minor lacerations.", "Urethral catheterisation for urinary issues.", "Regular follow-ups to ensure proper healing."],
                    "cta" => "Call Now for Wound Care"
                ],
                "urgent-care" => [
                    "icon" => "icon-nurisng-care",
                    "title" => "Urgent Care at Home",
                    "description" => "Get urgent medical care for conditions such as fever or severe abdominal pain.",
                    "features" => ["Management of severe abdominal pain.", "Relief for shivering and chills.", "Treatment for high-grade fever.", "Quick assessments for urgent situations."],
                    "cta" => "Call Now for Urgent Care"
                ],
                "iv-therapy" => [
                    "icon" => "icon-s",
                    "title" => "IV Fluid Therapy",
                    "description" => "Receive IV fluid therapy in the comfort of your home.",
                    "features" => ["IV fluid administration for hydration.", "Injection administration for medications.", "Monitoring of vitals during therapy.", "Aftercare advice for home recovery."],
                    "cta" => "Call Now for IV Fluid Therapy"
                ],
                "nursing-care" => [
                    "icon" => "icon-charity",
                    "title" => "Nursing Care",
                    "description" => "Professional nursing care services at home.",
                    "features" => ["Post-operative care for recovery.", "Elderly care to assist daily needs.", "Medication management for chronic illnesses.", "Health monitoring for critical conditions."],
                    "cta" => "Call Now for Nursing Care"
                ],
                "physiotherapy" => [
                    "icon" => "icon-massage",
                    "title" => "Physiotherapy at Home",
                    "description" => "Expert physiotherapy services in the comfort of your home.",
                    "features" => ["Rehabilitation for injury recovery.", "Pain management techniques for relief.", "Customized exercise plans for mobility.", "Home visits for convenience and comfort."],
                    "cta" => "Call Now for Physiotherapy"
                ],
                "lab-testing" => [
                    "icon" => "icon-test-tube",
                    "title" => "Home Lab Testing",
                    "description" => "Experience convenient lab testing services right at home.",
                    "features" => ["Blood tests for various conditions.", "Urine tests for diagnostic purposes.", "Fast results delivered to your home.", "Safe and hygienic sample collection."],
                    "cta" => "Call Now for Lab Testing"
                ],
                "mental-health" => [
                    "icon" => "icon-mental-care",
                    "title" => "Mental Health Support",
                    "description" => "Get professional mental health support at your convenience.",
                    "features" => ["Therapy for stress management.", "Support for mental health disorders & stress management.", "Flexible scheduling for sessions."],
                    "cta" => "Call Now for Mental Health Support"
                ]
            ];
            
            foreach ($services as $id => $service) {
                echo '<div class="col-lg-6" id="' . $id . '">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <span class="' . $service["icon"] . ' service-icon"></span>
                            </div>
                            <h3><strong><em>' . $service["title"] . (!empty($locality) ? ' in ' . htmlspecialchars($locality) : '') . '</em></strong></h3>
                            <p>' . $service["description"] . (!empty($locality) ? ' in ' . htmlspecialchars($locality) : '') . '.</p>
                            <div class="service-para">';
                foreach ($service["features"] as $feature) {
                    echo '<p><span class="icon-correct service-para-icon"></span> ' . $feature . '</p>';
                }
                echo '    </div>
                            <a href="tel:8424845423" class="mobile-number">' . $service["cta"] . (!empty($locality) ? ' in ' . htmlspecialchars($locality) : '') . '</a>
                        </div>
                    </div>';
            }
            ?>
        </div>
    </div>
</section>

         <!-- End Our Services Section -->
         <!-- ======= Testimonials Section ======= -->
         <section id="testimonials" class="testimonials">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2>Testimonials</h2>
            <p>What our clients say</p>
        </div>
        <div class="slides-3 swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
                <?php
                // Define an array of testimonials
                $testimonials = [
                    ["name" => "Jayesh Patel", "review" => "I had a fantastic experience with Doconnect! Booking a doctor for a home visit was quick, and arranging lab tests was hassle-free.", "rating" => 5],
                    ["name" => "Vijay Gore", "review" => "The Doconnect team was incredibly helpful. Their service exceeded my expectations, and I highly recommend it for anyone needing medical assistance.", "rating" => 5],
                    ["name" => "Ramesh Dhoklam", "review" => "Everything was arranged quickly and easily. The customer service was excellent, and I got the help I needed without delay.", "rating" => 5],
                    ["name" => "Prince Chaurasiya", "review" => "The booking process was straightforward. I secured my appointments without any issues. Highly satisfied!", "rating" => 5],
                    ["name" => "Shashank Sinha", "review" => "I was impressed by the care and professionalism shown by Doconnect. They were always available to answer my questions and ensure everything went smoothly.", "rating" => 5]
                ];

                // Loop through testimonials and display them
                foreach ($testimonials as $testimonial) {
                    echo '<div class="swiper-slide">
                            <div class="testimonial-wrap">
                                <div class="testimonial-item">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h3>' . $testimonial["name"] . '</h3>
                                            <div class="stars">';
                    // Display star ratings
                    for ($i = 0; $i < $testimonial["rating"]; $i++) {
                        echo '<i class="bi bi-star-fill"></i>';
                    }
                    echo '            </div>
                                        </div>
                                    </div>
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        ' . $testimonial["review"] . '
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                </div>
                            </div>
                        </div>';
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

         <!-- End Testimonials Section -->
         <!-- ======= Our Team Section ======= -->
         <!--    -->
         <!-- End Our Team Section -->
         <!-- ======= Frequently Asked Questions Section ======= -->
         <section id="faqs" class="faq">
    <div class="container" data-aos="fade-up">
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="content px-xl-5">
                    <h3>Frequently Asked <strong>Questions</strong></h3>
                    <p>
                        Our top priority is providing comprehensive and quality home care to our patients. We understand that when medical care is needed, it can be a stressful and worrying time. That’s why we offer a range of home visit services to make the process easier for you.
                    </p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="accordion accordion-flush" id="faqlist" data-aos="fade-up" data-aos-delay="100">
                    <?php
                    // Define FAQs dynamically using existing $city and $locality variables
                    $faqs = [
                        ["question" => "How can I book a home visit for a doctor in $locality?", "answer" => "You can easily book a home visit by visiting Doconnect.org and selecting the home visit option for $locality. It's a simple process designed for your convenience."],
                        ["question" => "Can I request a nebulisation service at home in $locality?", "answer" => "Yes, we provide nebulisation services in $locality during home visits. Just let us know your requirement when you book your appointment."],
                        ["question" => "How can I arrange for an injection administration at home in $locality?", "answer" => "You can request injection administration by booking a home visit through Doconnect.org. Our trained professionals will be there to assist you in $city."],
                        ["question" => "Do you offer wound care management during home visits in $locality?", "answer" => "Yes, we provide dressing and wound care services in $locality. Just mention your needs when you book the appointment."],
                        ["question" => "Can I get treatment for severe abdominal pain at home in $locality?", "answer" => "Absolutely. Our doctors can assess and provide management for severe abdominal pain during a home visit in $locality. Please book an appointment for assistance."],
                        ["question" => "Is relief for shivering available through home visits in $locality?", "answer" => "Yes, we can provide relief for shivering during a home visit in $locality. Our medical team will assess your condition and provide appropriate care."],
                        ["question" => "Can you provide treatment for high-grade fever at home in $locality?", "answer" => "Yes, our doctors are equipped to manage high-grade fever during home visits in $locality. Just let us know your symptoms when you book."],
                        ["question" => "Do you offer IV fluid therapy during home visits in $locality?", "answer" => "Yes, we provide IV fluid therapy as part of our home visit services in $locality. Please specify your needs when scheduling an appointment."],
                        ["question" => "Can small stitches be administered at home in $locality?", "answer" => "Yes, we can administer small stitches during a home visit in $locality. Just let us know the details when you book your appointment."],
                        ["question" => "Can I have a urethral catheterisation done at home in $locality?", "answer" => "Yes, urethral catheterisation can be performed during a home visit in $locality. Our trained staff will handle the procedure with care."],
                        ["question" => "Is home consultation available in $locality?", "answer" => "Yes, you can book a consultation with our doctors at home in $locality. Simply visit Doconnect.org to schedule your appointment."]
                    ];

                    // Loop through FAQs and display dynamically
                    foreach ($faqs as $index => $faq) {
                        $faqNumber = $index + 1;
                        echo '<div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-' . $faqNumber . '">
                                        <span class="num">' . $faqNumber . '.</span> ' . $faq["question"] . '
                                    </button>
                                </h3>
                                <div id="faq-content-' . $faqNumber . '" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                        ' . $faq["answer"] . '
                                    </div>
                                </div>
                              </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

         <!-- End Frequently Asked Questions Section -->
         <!-- ======= Contact Section ======= -->
         <section id="contact" class="contact">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2>Contact Us</h2>
            <!-- <p>Find Us on Google</p> -->
        </div>

        <div class="row gx-lg-0 gy-4">
            <div class="col-lg-12 mx-lg-4">
                <div class="info-container d-flex flex-column align-items-center justify-content-center">
                    <div class="info-item d-flex">
                        <i class="bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h4>Location:</h4>
                            <p>
                                <?php
                                if (!empty($city) && !empty($locality)) {
                                    echo "We are located in various location in $city.";
                                } elseif (!empty($city)) {
                                    echo "We are located in $city.";
                                } elseif (!empty($locality)) {
                                    echo "We are located in $locality.";
                                } else {
                                    echo "Located at various addresses across Mumbai for your convenience.";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <!-- End Info Item -->

                    <div class="info-item d-flex">
                        <i class="bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h4>Email:</h4>
                            <p>info@Doconnect.org</p>
                        </div>
                    </div>
                    <!-- End Info Item -->

                    <div class="info-item d-flex">
                        <i class="bi bi-phone flex-shrink-0"></i>
                        <div>
                            <h4>Call:</h4>
                            <p>+91-84248 45423</p>
                        </div>
                    </div>
                    <!-- End Info Item -->

                    <div class="info-item d-flex">
                        <i class="bi bi-clock flex-shrink-0"></i>
                        <div>
                            <h4>Open Hours:</h4>
                            <p>24 x 7 Open</p>
                        </div>
                    </div>
                    <!-- End Info Item -->
                </div>
            </div>

            <div class="col-lg-6 mx-lg-4">
                
            </div>
            <!-- End Contact Form -->
        </div>
    </div>
</section>
<section id="location" class="contact">
    <div class="container">
        <div class="section-title aos-init aos-animate" data-aos="fade-up">
            <h2>Our Service Locations</h2>
            <p>We are serving in various locations</p>
        </div>
        <div class="row">
    <?php
    if (!empty($locations)) {
        // Split locations into 3 columns for better UI
        $chunks = array_chunk($locations, ceil(count($locations) / 3));

        foreach ($chunks as $column) {
            echo '<div class="col-lg-4 mt-2 aos-init aos-animate" data-aos="fade-right" data-aos-delay="100">';
            foreach ($column as $location) {
                $city = htmlspecialchars($location['city']);
                $locality = htmlspecialchars($location['locality']);
                $slug = htmlspecialchars($location['slug']); // Clean URL-friendly slug

                // Dynamic SEO-friendly URL
                $locationUrl = "./$slug.php"; 

                echo '<div class="info">
                        <div class="address mt-3">
                            <a href="' . $locationUrl . '" class="testimonial-link">
                                <i class="bi bi-geo-alt"></i> Doctor for home visit in ' . $locality . '
                            </a>
                        </div>
                    </div>';
            }
            echo '</div>';
        }
    } else {
        echo "<p>No locations available.</p>";
    }
    ?>
</div>

    </div>
</section>

         <!-- End Contact Section -->
      </main>
      <!-- End #main -->
      <!-- ======= Footer ======= -->
      <footer id="footer" class="footer">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5 col-md-12 footer-info">
                <a href="index.php" class="logo d-flex align-items-center">
                    <span>Doconnect</span>
                </a>
                <p>
                    At Doconnect, our top priority is providing comprehensive and quality care to our patients in the comfort of their homes. 
                    We understand that when medical care is needed, it can be a stressful and worrying time. 
                    That’s why we offer a range of in-home services, including doctor consultations, nebulisation, injection administration, and more.
                    We are committed to ensuring our patients have access to the care they need when and where they need it.
                </p>
                <div class="social-links d-flex mt-4">
                    <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#about">About us</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
                    <li><a href="#faqs">FAQs</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#services">Doctor Home Visit</a></li>
                    <li><a href="#services">Nebulisation</a></li>
                    <li><a href="#services">Sugar Check</a></li>
                    <li><a href="#services">Injection Administration</a></li>
                    <li><a href="#services">Wound Care</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                <h4>Contact Us</h4>
                <p>
                    <strong>Serving Areas:</strong><br>
                    <?php
                    // Display city and locality if available
                    if (!empty($city) && !empty($locality)) {
                        echo "We are serving in various locations in $city";
                    } elseif (!empty($city)) {
                        echo "We are serving in $city";
                    } elseif (!empty($locality)) {
                        echo "We are serving in $locality";
                    } else {
                        echo "We are serving in multiple locations.";
                    }
                    ?>
                    <br><br>
                    <strong>Phone:</strong> +91-84248 45423<br>
                    <strong>Email:</strong> info@Doconnect.org<br>
                </p>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="copyright">
            &copy; Copyright <strong><span>Doconnect</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- Designed by <a href="http://www.leadtroopers.com/">Leadtroopers</a> -->
        </div>
    </div>
</footer>

      <!-- End Footer -->
      <!--sticky mob-->
      <div class="fixed-bottom d-md-block d-lg-none">
         <div id="stickymob">
            <div class="row stickybtn">
               <a class="stickywa" href="whatsapp://send?text=Hello Doctor, #I was going through your website and  I want to schedule a home visit&phone=+918424845423">
               <img class="img-fluid" src="assets/img/wa-logo.png" height="45" width="45" alt="Doctor On Call For Home Visit">
               </a>
            </div>
         </div>
      </div>
      <a class="stickyphone" href="tel:+918424845423">
      <i class="bi bi-telephone-fill"></i>
      </a>
      <!-- end of sticky mob -->
      <!-- end of sticky mob -->
      <!-- End Footer -->
      <!-- <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> -->
      <!-- <div id="preloader"></div> -->
      <!-- Vendor JS Files -->
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="assets/vendor/aos/aos.js"></script>
      <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
      <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
      <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
      <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
      <script src="assets/vendor/php-email-form/validate.js"></script>
      <!-- Template Main JS File -->
      <script src="assets/js/main.js"></script>
   </body>
</html>