<?php
session_start();


if (!isset($_SESSION['registrants'])) {
    $_SESSION['registrants'] = array();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $event = $_POST['event'];
    $guests = trim($_POST['guests']);
    $special_requests = trim($_POST['special_requests']);
    
    
    if (!empty($name) && !empty($email) && !empty($phone) && !empty($event)) {
      
        $id = count($_SESSION['registrants']) + 1;
        
       
        $_SESSION['registrants'][$id] = array(
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'event' => $event,
            'guests' => $guests,
            'special_requests' => $special_requests,
            'registration_date' => date('Y-m-d H:i:s')
        );
        
        $success_message = "Registration successful! Your confirmation number is: " . $id;
    } else {
        $error_message = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Eijay Hotel - Event Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --hotel-gold: #D4AF37;
            --hotel-dark: #1a1a1a;
            --hotel-cream: #F5F5DC;
            --hotel-burgundy: #800020;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .hotel-header {
            background: linear-gradient(135deg, var(--hotel-dark) 0%, var(--hotel-burgundy) 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .hotel-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--hotel-gold);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .hotel-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 0.5rem;
        }
        
        .luxury-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--hotel-gold) 0%, #B8860B 100%);
            border: none;
            padding: 2rem;
        }
        
        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--hotel-gold);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }
        
        .btn-luxury {
            background: linear-gradient(135deg, var(--hotel-gold) 0%, #B8860B 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }
        
        .btn-luxury:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }
        
        .btn-outline-luxury {
            border: 2px solid var(--hotel-gold);
            color: var(--hotel-gold);
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-luxury:hover {
            background: var(--hotel-gold);
            color: white;
            transform: translateY(-1px);
        }
        
        .alert-luxury {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            font-weight: 500;
        }
        
        .hotel-features {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
            backdrop-filter: blur(10px);
        }
        
        .feature-icon {
            font-size: 2rem;
            color: var(--hotel-gold);
            margin-bottom: 1rem;
        }
        
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .floating-elements::before,
        .floating-elements::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-elements::before {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-elements::after {
            bottom: 10%;
            right: 10%;
            animation-delay: 3s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
    </style>
</head>
<body>
    <div class="floating-elements"></div>
    <!-- Hotel Header -->
    <div class="hotel-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="hotel-logo">
                        <i class="fas fa-crown me-3"></i>
                         Club Eijay Hotel
                    </div>
                    <div class="hotel-subtitle">
                        <i class="fas fa-star me-1"></i>
                        Luxury Events & Conferences
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                            <i class="fas fa-phone me-1"></i>
                            +1 (555) 123-4567
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Hotel Features -->
        <div class="hotel-features">
            <div class="row text-center text-white">
                <div class="col-md-3 mb-3">
                    <div class="feature-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <h5>Concierge Service</h5>
                    <p class="mb-0">24/7 Premium Support</p>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="feature-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h5>Fine Dining</h5>
                    <p class="mb-0">Michelin Star Cuisine</p>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="feature-icon">
                        <i class="fas fa-spa"></i>
                    </div>
                    <h5>Luxury Spa</h5>
                    <p class="mb-0">World-Class Wellness</p>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="feature-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h5>Valet Parking</h5>
                    <p class="mb-0">Complimentary Service</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="luxury-card">
                    <div class="card-header">
                        <h2 class="card-title text-center mb-0">
                            <i class="fas fa-calendar-check me-3"></i>
                            Exclusive Event Registration
                        </h2>
                        <p class="text-center mb-0 mt-2" style="opacity: 0.9;">
                            Reserve your spot at our prestigious events!
                        </p>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($success_message)): ?>
                            <div class="alert alert-success alert-luxury alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Congratulations!</strong> <?php echo $success_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger alert-luxury alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Attention:</strong> <?php echo $error_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="form-label fw-bold">
                                        <i class="fas fa-user me-2 text-warning"></i>Full Name
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                                    <div class="invalid-feedback">
                                        Please provide your full name.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="email" class="form-label fw-bold">
                                        <i class="fas fa-envelope me-2 text-warning"></i>Email Address
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="your.email@example.com" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid email address.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="phone" class="form-label fw-bold">
                                        <i class="fas fa-phone me-2 text-warning"></i>Phone Number
                                    </label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="+1 (555) 123-4567" required>
                                    <div class="invalid-feedback">
                                        Please provide your phone number.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="guests" class="form-label fw-bold">
                                        <i class="fas fa-users me-2 text-warning"></i>Number of Guests
                                    </label>
                                    <input type="number" class="form-control" id="guests" name="guests" placeholder="1" min="1" max="10" value="1">
                                    <div class="form-text">Maximum 10 guests per registration</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="event" class="form-label fw-bold">
                                        <i class="fas fa-calendar me-2 text-warning"></i>Select Event
                                    </label>
                                    <select class="form-select" id="event" name="event" required>
                                        <option value="">Choose your preferred event...</option>
                                        <option value="Luxury Wine Tasting">🍷 Luxury Wine Tasting - $150/person</option>
                                        <option value="Executive Business Summit">💼 Executive Business Summit - $500/person</option>
                                        <option value="Gourmet Cooking Class">👨‍🍳 Gourmet Cooking Class - $200/person</option>
                                        <option value="Art Gallery Opening">🎨 Art Gallery Opening - $75/person</option>
                                        <option value="Spa Wellness Retreat">🧘‍♀️ Spa Wellness Retreat - $300/person</option>
                                        <option value="Private Concert">🎵 Private Concert - $250/person</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an event.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="special_requests" class="form-label fw-bold">
                                        <i class="fas fa-star me-2 text-warning"></i>Special Requests
                                    </label>
                                    <textarea class="form-control" id="special_requests" name="special_requests" rows="3" placeholder="Dietary restrictions, accessibility needs, or special arrangements..."></textarea>
                                    <div class="form-text">Optional: Let us know how we can make your experience exceptional</div>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                                <button type="submit" class="btn btn-luxury btn-lg px-5">
                                    <i class="fas fa-crown me-2"></i>Reserve Your Spot
                                </button>
                            </div>
                        </form>
                        
                        <hr class="my-5" style="border-color: var(--hotel-gold); opacity: 0.3;">
                        
                        <div class="text-center">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <a href="participants.php" class="btn btn-outline-luxury w-100">
                                        <i class="fas fa-users me-2"></i>View All Guests
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="index.php" class="btn btn-outline-luxury w-100">
                                        <i class="fas fa-refresh me-2"></i>Refresh Page
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="tel:+15551234567" class="btn btn-outline-luxury w-100">
                                        <i class="fas fa-phone me-2"></i>Call Concierge
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hotel Footer -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="text-center text-white">
                    <div class="hotel-logo mb-3" style="font-size: 1.5rem;">
                        <i class="fas fa-crown me-2"></i>
                        Club Eijay Hotel
                    </div>
                    <p class="mb-2">Register and Give Me Your Money</p>
                    <div class="d-flex justify-content-center gap-4 mb-3">
                        <span><i class="fas fa-map-marker-alt me-1"></i> Lab 802, University of Cebu - Banilad</span>
                        <span><i class="fas fa-phone me-1"></i> +1 (555) 123-4567</span>
                        <span><i class="fas fa-envelope me-1"></i> eijay.pepito8@gmail.com</span>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>
</html>
