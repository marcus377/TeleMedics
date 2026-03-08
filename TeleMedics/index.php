<?php
/* 
Telemedicine Consultation System
Homepage
Author: Melvine Nasio Makokha
University: The Co-operative University of Kenya
*/

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Telemedicine Consultation System</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>

body{
font-family:'Poppins',sans-serif;
background:#f9fafc;
}

:root{
--primary:#0055CC;
--secondary:#00B4B4;
}

.navbar{
background:white;
box-shadow:0 3px 15px rgba(0,0,0,0.08);
}

.navbar-brand{
font-weight:700;
color:var(--primary)!important;
}

.hero{
background:linear-gradient(135deg,#0055CC,#003D99);
color:white;
padding:120px 0;
}

.hero h1{
font-size:3rem;
font-weight:700;
}

.btn-main{
background:white;
color:#0055CC;
font-weight:600;
border-radius:8px;
padding:12px 25px;
}

.btn-main:hover{
background:#e5e5e5;
}

.section-title{
text-align:center;
margin-bottom:60px;
}

.service-card{
background:white;
padding:30px;
border-radius:12px;
box-shadow:0 5px 20px rgba(0,0,0,0.08);
transition:0.3s;
}

.service-card:hover{
transform:translateY(-8px);
}

footer{
background:#003D99;
color:white;
padding:40px 0;
margin-top:80px;
}

</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
<div class="container">

<a class="navbar-brand" href="#">
<i class="fa fa-hospital"></i>
Telemedicine
</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="menu">

<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="#home">Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#services">Services</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#doctors">Doctors</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#contact">Contact</a>
</li>

</ul>

<div class="ms-3">

<a href="login.php" class="btn btn-outline-primary">Login</a>

<a href="register.php" class="btn btn-primary">Register</a>

</div>

</div>

</div>
</nav>


<!-- HERO -->
<section class="hero" id="home">
<div class="container">
<div class="row align-items-center">

<div class="col-lg-6" data-aos="fade-right">

<h1>Online Healthcare Consultation Platform</h1>

<p>
Connect with professional doctors remotely and manage your health records securely from anywhere.
</p>

<a href="register.php" class="btn btn-main">
Start Consultation
</a>

</div>

<div class="col-lg-6 text-center" data-aos="fade-left">

<i class="fa fa-user-md" style="font-size:200px;"></i>

</div>

</div>
</div>
</section>


<!-- SERVICES -->
<section class="container py-5" id="services">

<div class="section-title">
<h2>Our Services</h2>
<p>Digital healthcare services accessible anytime</p>
</div>

<div class="row g-4">

<div class="col-md-4">
<div class="service-card text-center">

<i class="fa fa-calendar-check fa-3x text-primary"></i>

<h4 class="mt-3">Appointments</h4>

<p>Book online doctor appointments easily.</p>

</div>
</div>

<div class="col-md-4">
<div class="service-card text-center">

<i class="fa fa-video fa-3x text-primary"></i>

<h4 class="mt-3">Video Consultation</h4>

<p>Consult doctors via secure video calls.</p>

</div>
</div>

<div class="col-md-4">
<div class="service-card text-center">

<i class="fa fa-phone fa-3x text-primary"></i>

<h4 class="mt-3">Call Consultation</h4>

<p>Quick consultations over audio calls.</p>

</div>
</div>

<div class="col-md-4">
<div class="service-card text-center">

<i class="fa fa-comments fa-3x text-primary"></i>

<h4 class="mt-3">Text Consultation</h4>

<p>Text-based consultations at your convenience.</p>

</div>
</div>

<div class="col-md-4">
<div class="service-card text-center">

<i class="fa fa-file-medical fa-3x text-primary"></i>

<h4 class="mt-3">Medical Records</h4>

<p>Access your medical records securely.</p>

</div>
</div>

<div class="col-md-4">
<div class="service-card text-center">

<i class="fa fa-pills fa-3x text-primary"></i>

<h4 class="mt-3">Digital Prescriptions</h4>

<p>Receive prescriptions digitally.</p>

</div>
</div>

</div>

</section>


<!-- DOCTORS -->
<section class="container py-5" id="doctors">

<div class="section-title">
<h2>Our Doctors</h2>
</div>

<div class="row g-4">

<div class="col-md-4">

<div class="card text-center">

<div class="card-body">

<i class="fa fa-user-md fa-4x text-primary"></i>

<h4 class="mt-3">Dr. Melvine Makokha</h4>

<p>General Practitioner</p>

<a href="login.php" class="btn btn-outline-primary">
Book Appointment
</a>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card text-center">

<div class="card-body">

<i class="fa fa-heartbeat fa-4x text-danger"></i>

<h4 class="mt-3">Dr. Charles Mutobera</h4>

<p>Cardiologist</p>

<a href="login.php" class="btn btn-outline-primary">
Book Appointment
</a>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card text-center">

<div class="card-body">

<i class="fa fa-stethoscope fa-4x text-success"></i>

<h4 class="mt-3">Dr. Emily Mutobera</h4>

<p>Pediatrician</p>

<a href="login.php" class="btn btn-outline-primary">
Book Appointment
</a>

</div>

</div>

</div>

</div>

</section>


<!-- CONTACT -->
<section class="container py-5" id="contact">

<div class="section-title">
<h2>Contact Us</h2>
</div>

<div class="row">

<div class="col-md-6">

<form method="POST">

<div class="mb-3">
<input type="text" class="form-control" name="name" placeholder="Full Name" required>
</div>

<div class="mb-3">
<input type="email" class="form-control" name="email" placeholder="Email" required>
</div>

<div class="mb-3">
<textarea class="form-control" name="message" placeholder="Message"></textarea>
</div>

<button class="btn btn-primary">Send Message</button>

</form>

</div>

<div class="col-md-6">

<h5>Location</h5>
<p>The Co-operative University of Kenya<br>Karen, Nairobi</p>

<h5>Phone</h5>
<p>+254 795 207 374</p>

<h5>Email</h5>
<p>makokhanmelvin04@gmail.com</p>

</div>

</div>

</section>


<!-- FOOTER -->
<footer>

<div class="container text-center">

<p>
© <?php echo date("Y"); ?> Telemedicine Consultation System
</p>

</div>

</footer>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
AOS.init();
</script>

</body>
</html>