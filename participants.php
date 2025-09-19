<?php
session_start();

// Initialize registrants array in session if not exists
if (!isset($_SESSION['registrants'])) {
    $_SESSION['registrants'] = array();
}

// Handle GET parameters for filtering
$filter_event = isset($_GET['event']) ? $_GET['event'] : '';
$view_user = isset($_GET['user']) ? (int)$_GET['user'] : 0;

// Filter registrants based on GET parameter
$filtered_registrants = $_SESSION['registrants'];
if (!empty($filter_event)) {
    $filtered_registrants = array_filter($_SESSION['registrants'], function($registrant) use ($filter_event) {
        return $registrant['event'] === $filter_event;
    });
}

// Get unique events for filter dropdown
$events = array_unique(array_column($_SESSION['registrants'], 'event'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Guests - Grand Palace Hotel</title>
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
        
        .stats-card {
            background: linear-gradient(135deg, var(--hotel-gold) 0%, #B8860B 100%);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .table-luxury {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .table-luxury thead {
            background: linear-gradient(135deg, var(--hotel-dark) 0%, var(--hotel-burgundy) 100%);
            color: white;
        }
        
        .table-luxury tbody tr:hover {
            background-color: rgba(212, 175, 55, 0.1);
            transform: scale(1.01);
            transition: all 0.3s ease;
        }
        
        .badge-luxury {
            background: linear-gradient(135deg, var(--hotel-gold) 0%, #B8860B 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
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
                        Guest Management System
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex justify-content-end">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                            <i class="fas fa-users me-1"></i>
                            <?php echo count($_SESSION['registrants']); ?> Guests
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="luxury-card">
                    <div class="card-header">
                        <h2 class="card-title text-center mb-0">
                            <i class="fas fa-users me-3"></i>
                            Hotel Guests & Event Attendees
                        </h2>
                        <p class="text-center mb-0 mt-2" style="opacity: 0.9;">
                            Manage and view all registered guests
                        </p>
                    </div>
                    <div class="card-body p-4">
                        <!-- Filter Section -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <form method="GET" action="">
                                    <div class="input-group">
                                        <select class="form-select" name="event" onchange="this.form.submit()">
                                            <option value="">All Events</option>
                                            <?php foreach ($events as $event): ?>
                                                <option value="<?php echo htmlspecialchars($event); ?>" 
                                                        <?php echo ($filter_event === $event) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($event); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button class="btn btn-outline-secondary" type="button" onclick="window.location.href='participants.php'">
                                            <i class="fas fa-times"></i> Clear Filter
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="index.php" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>New Registration
                                </a>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="row mb-5">
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <i class="fas fa-users fa-2x mb-3"></i>
                                    <h3 class="mb-2"><?php echo count($_SESSION['registrants']); ?></h3>
                                    <p class="mb-0 fw-bold">Total Guests</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <i class="fas fa-filter fa-2x mb-3"></i>
                                    <h3 class="mb-2"><?php echo count($filtered_registrants); ?></h3>
                                    <p class="mb-0 fw-bold">Filtered Results</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <i class="fas fa-calendar fa-2x mb-3"></i>
                                    <h3 class="mb-2"><?php echo count($events); ?></h3>
                                    <p class="mb-0 fw-bold">Events Available</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stats-card">
                                    <i class="fas fa-eye fa-2x mb-3"></i>
                                    <h3 class="mb-2"><?php echo !empty($filter_event) ? 'Filtered' : 'All'; ?></h3>
                                    <p class="mb-0 fw-bold">Current View</p>
                                </div>
                            </div>
                        </div>

                        <!-- Guests Table -->
                        <?php if (empty($filtered_registrants)): ?>
                            <div class="alert alert-info text-center p-4" style="border-radius: 15px; background: rgba(212, 175, 55, 0.1); border: 2px solid var(--hotel-gold);">
                                <i class="fas fa-info-circle me-2 fa-2x text-warning"></i>
                                <h5 class="mt-3">
                                    <?php if (empty($_SESSION['registrants'])): ?>
                                        No guests registered yet. <a href="index.php" class="text-decoration-none fw-bold">Register now!</a>
                                    <?php else: ?>
                                        No guests found for the selected filter.
                                    <?php endif; ?>
                                </h5>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-luxury">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-hashtag me-2"></i>Guest ID</th>
                                            <th><i class="fas fa-user me-2"></i>Name</th>
                                            <th><i class="fas fa-envelope me-2"></i>Email</th>
                                            <th><i class="fas fa-phone me-2"></i>Phone</th>
                                            <th><i class="fas fa-calendar me-2"></i>Event</th>
                                            <th><i class="fas fa-clock me-2"></i>Registration Date</th>
                                            <th><i class="fas fa-cog me-2"></i>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($filtered_registrants as $registrant): ?>
                                            <tr>
                                                <td>
                                                    <span class="badge-luxury">#<?php echo $registrant['id']; ?></span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                        <strong><?php echo htmlspecialchars($registrant['name']); ?></strong>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="mailto:<?php echo htmlspecialchars($registrant['email']); ?>" 
                                                       class="text-decoration-none text-primary fw-bold">
                                                        <i class="fas fa-envelope me-1"></i>
                                                        <?php echo htmlspecialchars($registrant['email']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="tel:<?php echo htmlspecialchars($registrant['phone']); ?>" 
                                                       class="text-decoration-none text-success fw-bold">
                                                        <i class="fas fa-phone me-1"></i>
                                                        <?php echo htmlspecialchars($registrant['phone']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info px-3 py-2" style="border-radius: 20px;">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        <?php echo htmlspecialchars($registrant['event']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        <?php echo date('M j, Y', strtotime($registrant['registration_date'])); ?>
                                                        <br>
                                                        <small><?php echo date('g:i A', strtotime($registrant['registration_date'])); ?></small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="participant.php?user=<?php echo $registrant['id']; ?>" 
                                                       class="btn btn-outline-luxury btn-sm">
                                                        <i class="fas fa-eye me-1"></i>View Details
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <!-- Navigation -->
                        <div class="text-center mt-5">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <a href="index.php" class="btn btn-luxury w-100">
                                        <i class="fas fa-home me-2"></i>Back to Registration
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="participants.php" class="btn btn-outline-luxury w-100">
                                        <i class="fas fa-refresh me-2"></i>Refresh List
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
