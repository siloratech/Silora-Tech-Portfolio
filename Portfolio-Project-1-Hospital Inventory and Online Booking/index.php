<!DOCTYPE html>
<html lang="en">

<body>

  <!-- ======= Head ======= -->
  <div class="row">
    <?php include 'include/head.php'; ?>
  </div>

  <!-- ======= Top Bar ======= -->
  <div class="row">
    <?php include 'include/topbar.php'; ?>
</div>


  <!-- ======= Header ======= -->
  <div class="row">
    <?php include 'include/header.php'; ?>
  </div>
  
  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">

        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url(assets/img/slide/slide-1.jpg)">
          <div class="container">
            <h2>Welcome to <span>XVY Health Care Centre</span></h2>
            <p>We are dedicated to providing comprehensive, accurate, and timely diagnostic services to help you take charge of your health. Our state-of-the-art facility and experienced medical professionals ensure you receive the highest quality care.</p>
            <a href="#about" class="btn-get-started scrollto">Read More</a>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item" style="background-image: url(assets/img/slide/slide-2.jpg)">
          <div class="container">
            <h2>Make an Appoinment</h2>
            <p>Our online appointment booking system allows you to schedule your visit at your convenience, ensuring a smooth and hassle-free experience.</p>
            <a href="booking_appointment.php" class="btn-get-started scrollto">Make Appointment</a>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item" style="background-image: url(assets/img/slide/slide-3.jpg)">
          <div class="container">
            <h2>Online Book a Test</h2>
            <p>We strive to make your diagnostic experience as seamless and convenient as possible. Our online test booking system allows you to schedule your tests at your convenience, ensuring timely and efficient service.</p>
            <a href="book_labtest.php" class="btn-get-started scrollto">Book Lab Test</a>
          </div>
        </div>

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

    </div>
  </section><!-- End Hero -->

  <main id="main">

    
    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">

        <div class="text-center">
          <h3>In an emergency? Need help now?</h3>
          
          <a class="cta-btn scrollto" href="booking_appointment.php">Make an Appointment</a>
        </div>

      </div>
    </section><!-- End Cta Section -->

    <section id="about" class="about">
      <div class="container" data-aos="fade-up">
  
        <div class="section-title">
          <h2>About Us</h2>
          <p>Our team of experienced medical professionals is the backbone of XVY Health Care Centre. Comprising skilled doctors, radiologists, lab technicians, and support staff, our team is dedicated to delivering exceptional diagnostic services with a personal touch.</p>
        </div>
  
        <div class="row">
          <div class="col-lg-6" data-aos="fade-right">
            <img src="assets/img/samplepic02.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left">
            <h3>Why Choose Us?</h3>
            <p class="fst-italic">
              We envision a future where advanced diagnostic services are accessible to all, contributing to early detection, prevention, and effective management of health conditions. Our commitment is to continually innovate and improve our services to meet the evolving needs of our patients.
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> <b>State-of-the-Art Technology:</b> We use the latest diagnostic equipment and techniques to ensure accurate results.</li>
              <li><i class="bi bi-check-circle"></i><b>Experienced Professionals:</b> Our team is composed of experienced and compassionate healthcare professionals.</li>
              <li><i class="bi bi-check-circle"></i><b>Patient-Centered Care:</b> We prioritize your comfort, convenience, and confidentiality throughout the diagnostic process.</b> </li>
              <li><i class="bi bi-check-circle"></i><b>Timely Results:</b> Our efficient processes ensure you receive your diagnostic results promptly.</li>
              <li><i class="bi bi-check-circle"></i><b>Comprehensive Support:</b> We provide thorough explanations of your results and collaborate with your healthcare providers for integrated care.</b> </li>
            </ul>
            
          </div>
        </div>
  
      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Services Section ======= -->
 <section id="services" class="services services">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Services</h2>
      <p>At XVY Health Care Centre, we offer a comprehensive range of diagnostic services and doctor consultations designed to meet the diverse needs of our patients. Our state-of-the-art technology and expert team ensure accurate, timely, and reliable results for all diagnostic tests.</p>
    </div>

    <div class="row">
      <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="100">
        <div class="icon"><i class="fas fa-heartbeat"></i></div>
        <h4 class="title"><a href="">Doctor Consultations(Offline/Online)</a></h4>
        <p class="description">Our Doctor Consultations service provides you with expert medical advice, personalized treatment plans, and follow-up care to ensure your health is managed effectively and holistically.</p>
      </div>
      <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="200">
        <div class="icon"><i class="fas fa-pills"></i></div>
        <h4 class="title"><a href="">Radiology Services</a></h4>
        <p class="description">our Radiology Services offers diagnostic and interventional radiology services that include X-Ray, Ultrasound, CT Scan, HSG, BARIUM MEAL FOLLOW, color doppler.</p>
      </div>
      <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="300">
        <div class="icon"><i class="fas fa-hospital-user"></i></div>
        <h4 class="title"><a href="">Laboratory Test</a></h4>
        <p class="description">We offer a comprehensive range of laboratory tests designed to provide critical insights into your health. Our services include: Blood test, Glucose, HbA1c test, Thyroid function tests, Urinalysis, Lipid panel, Kidney function test, Lipid panel, Microbiology, Calcium etc.</p>
      </div>
      <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="100">
        <div class="icon"><i class="fas fa-dna"></i></div>
        <h4 class="title"><a href="">Full body checkup</a></h4>
        <p class="description">Our Full Body Checkup is designed to give you a comprehensive overview of your health status, detect any potential health issues early, and provide peace of mind at low cost.</p>
      </div>
      <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="200">
        <div class="icon"><i class="fas fa-wheelchair"></i></div>
        <h4 class="title"><a href="">Pharmacy Services</a></h4>
        <p class="description">We offer a fully equipped pharmacy to ensure you have easy access to the medications and health products you need. Our pharmacy services are designed to provide convenience, affordability, and professional care.</p>
      </div>
      <div class="col-lg-4 col-md-6 icon-box" data-aos="zoom-in" data-aos-delay="300">
        <div class="icon"><i class="fas fa-notes-medical"></i></div>
        <h4 class="title"><a href="">Emergency Care Services</a></h4>
        <p class="description">we understand that medical emergencies can happen at any time. Our emergency care services are designed to provide immediate and expert medical attention to ensure the best possible outcomes.</p>
      </div>
    </div>

  </div>
</section><!-- End Services Section -->

    
    
    <!-- ======= Testimonials Section ======= -->
 <!--   <section id="testimonials" class="testimonials">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Management Team</h2>
          
        </div>

        <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Welcome to XVY Health Care Centre. As a CEO & Managing Director, our mission is to elevate the standard of diagnostic care. We are committed to combining the latest technology with a compassionate approach to deliver accurate results and exceptional service. Your health is our top priority, and we are honored to serve you.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Dr. Shariful Islam</h3>
                <h4>CEO &amp; Managing Director</h4>
              </div>
            </div><!-- End testimonial item -->

            
            

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Testimonials Section -->


            <!-- End testimonial item -->
    
  </main><!-- End #main -->

<!-- ======= Footer ======= -->
<div class="row">
    <?php include 'include/footer.php'; ?>
  </div><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>