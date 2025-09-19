<?php
session_start();

// Initialize registrants array in session if not exists
if (!isset($_SESSION['registrants'])) {
    $_SESSION['registrants'] = array();
}

// Get user ID from GET parameter
$user_id = isset($_GET['user']) ? (int)$_GET['user'] : 0;

// Find the specific participant
$participant = null;
if ($user_id > 0 && isset($_SESSION['registrants'][$user_id])) {
    $participant = $_SESSION['registrants'][$user_id];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Details - Grand Palace Hotel</title>
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
        
        .guest-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--hotel-gold) 0%, #B8860B 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
            margin: 0 auto 2rem;
        }
        
        .info-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(245,245,220,0.9) 100%);
            border: 2px solid var(--hotel-gold);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.2);
        }
        
        .info-icon {
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
                        Grand Palace Hotel
                    </div>
                    <div class="hotel-subtitle">
                        <i class="fas fa-star me-1"></i>
                        Guest Information System
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                            <i class="fas fa-user me-1"></i>
                            Guest #<?php echo $user_id; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if ($participant): ?>
                    <div class="luxury-card">
                        <div class="card-header">
                            <h2 class="card-title text-center mb-0">
                                <i class="fas fa-user me-3"></i>
                                Guest Information
                            </h2>
                            <p class="text-center mb-0 mt-2" style="opacity: 0.9;">
                                Detailed guest profile and event registration
                            </p>
                        </div>
                        <div class="card-body p-4">
                            <!-- Guest Information -->
                            <div class="row">
                                <div class="col-md-4 text-center mb-5">
                                    <div class="guest-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <h3 class="mb-2" style="font-family: 'Playfair Display', serif;">
                                        <?php echo htmlspecialchars($participant['name']); ?>
                                    </h3>
                                    <p class="text-muted mb-0">Guest ID: #<?php echo $participant['id']; ?></p>
                                    <span class="badge bg-warning text-dark px-3 py-2 mt-2" style="border-radius: 20px;">
                                        <i class="fas fa-crown me-1"></i>VIP Guest
                                    </span>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-sm-6 mb-4">
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-2">Email Address</h6>
                                                <p class="mb-0">
                                                    <a href="mailto:<?php echo htmlspecialchars($participant['email']); ?>" 
                                                       class="text-decoration-none text-primary fw-bold">
                                                        <i class="fas fa-envelope me-1"></i>
                                                        <?php echo htmlspecialchars($participant['email']); ?>
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-4">
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-2">Phone Number</h6>
                                                <p class="mb-0">
                                                    <a href="tel:<?php echo htmlspecialchars($participant['phone']); ?>" 
                                                       class="text-decoration-none text-success fw-bold">
                                                        <i class="fas fa-phone me-1"></i>
                                                        <?php echo htmlspecialchars($participant['phone']); ?>
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6 mb-4">
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-2">Registered Event</h6>
                                                <p class="mb-0">
                                                    <span class="badge bg-info px-3 py-2" style="border-radius: 20px;">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        <?php echo htmlspecialchars($participant['event']); ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-4">
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-2">Registration Date</h6>
                                                <p class="mb-0">
                                                    <strong><?php echo date('F j, Y', strtotime($participant['registration_date'])); ?></strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <?php echo date('g:i A', strtotime($participant['registration_date'])); ?>
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php if (!empty($participant['guests']) && $participant['guests'] > 1): ?>
                                    <div class="row">
                                        <div class="col-sm-6 mb-4">
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-2">Number of Guests</h6>
                                                <p class="mb-0">
                                                    <span class="badge bg-success px-3 py-2" style="border-radius: 20px;">
                                                        <i class="fas fa-users me-1"></i>
                                                        <?php echo $participant['guests']; ?> Guest<?php echo $participant['guests'] > 1 ? 's' : ''; ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <?php if (!empty($participant['special_requests'])): ?>
                                        <div class="col-sm-6 mb-4">
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-2">Special Requests</h6>
                                                <p class="mb-0 text-muted">
                                                    <i class="fas fa-star me-1"></i>
                                                    <?php echo htmlspecialchars($participant['special_requests']); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="text-center mt-5">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <a href="participants.php" class="btn btn-luxury w-100">
                                            <i class="fas fa-arrow-left me-2"></i>Back to Guests
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="participants.php?event=<?php echo urlencode($participant['event']); ?>" 
                                           class="btn btn-outline-luxury w-100">
                                            <i class="fas fa-filter me-2"></i>Same Event
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="index.php" class="btn btn-outline-luxury w-100">
                                            <i class="fas fa-plus me-2"></i>New Registration
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="luxury-card">
                        <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <div class="guest-avatar mx-auto">
                                    <i class="fas fa-user-times"></i>
                                </div>
                            </div>
                            <h3 class="text-muted mb-3" style="font-family: 'Playfair Display', serif;">
                                Guest Not Found
                            </h3>
                            <p class="text-muted mb-4">
                                <?php if ($user_id > 0): ?>
                                    The guest with ID #<?php echo $user_id; ?> was not found in our system.
                                <?php else: ?>
                                    No guest ID was specified.
                                <?php endif; ?>
                            </p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <a href="participants.php" class="btn btn-luxury w-100">
                                        <i class="fas fa-users me-2"></i>View All Guests
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="index.php" class="btn btn-outline-luxury w-100">
                                        <i class="fas fa-home me-2"></i>Back to Registration
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Hotel Footer -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="text-center text-white">
                    <div class="hotel-logo mb-3" style="font-size: 1.5rem;">
                        <i class="fas fa-crown me-2"></i>
                        Grand Palace Hotel
                    </div>
                    <p class="mb-2">Where Luxury Meets Excellence</p>
                    <div class="d-flex justify-content-center gap-4 mb-3">
                        <span><i class="fas fa-map-marker-alt me-1"></i> 123 Luxury Avenue, Prestige City</span>
                        <span><i class="fas fa-phone me-1"></i> +1 (555) 123-4567</span>
                        <span><i class="fas fa-envelope me-1"></i> concierge@grandpalace.com</span>
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
</body>
</html>
