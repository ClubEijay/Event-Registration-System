# 🏨 Grand Palace Hotel - Luxury Event Management System

A sophisticated PHP web application that demonstrates **POST**, **GET**, and **SESSION** concepts with elegant Bootstrap styling for a luxury hotel experience.

## 🎯 Project Overview

The Grand Palace Hotel Event Management System allows guests to register for exclusive luxury events, view all registered guests, and access detailed guest information. The application showcases the three core PHP concepts required for the lab activity while providing a premium hotel experience.

## 📁 File Structure

```
Lab Act 4.3/
├── index.php          # Luxury hotel registration form (POST)
├── participants.php    # Hotel guests management (GET)
├── participant.php     # Individual guest details (GET)
└── README.md          # Project documentation
```

## 🔧 PHP Concepts Demonstrated

### 1. POST (Form Submission)
**File:** `index.php`
- **Location:** Luxury hotel registration form (lines 15-30)
- **Implementation:** 
  ```php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = trim($_POST['name']);
      $email = trim($_POST['email']);
      $guests = trim($_POST['guests']);
      $special_requests = trim($_POST['special_requests']);
      // ... process form data
  }
  ```
- **Purpose:** Handles luxury hotel guest registration form submission
- **Features:** Form validation, data sanitization, success/error messages, guest count, special requests

### 2. GET (URL Parameters)
**Files:** `participants.php` and `participant.php`
- **Location:** Filter functionality and guest details
- **Implementation:**
  ```php
  // participants.php - Event filtering
  $filter_event = isset($_GET['event']) ? $_GET['event'] : '';
  
  // participant.php - Guest details
  $user_id = isset($_GET['user']) ? (int)$_GET['user'] : 0;
  ```
- **Purpose:** 
  - Filter hotel guests by event (`participants.php?event=Luxury Wine Tasting`)
  - View specific guest details (`participant.php?user=1`)

### 3. SESSION (Temporary Data Storage)
**Files:** All PHP files
- **Location:** Session initialization and data storage
- **Implementation:**
  ```php
  session_start();
  
  // Initialize registrants array
  if (!isset($_SESSION['registrants'])) {
      $_SESSION['registrants'] = array();
  }
  
  // Store guest data
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
  ```
- **Purpose:** Persist hotel guest registration data across page requests

## 🚀 How to Run

1. **Start a local server:**
   ```bash
   # Using PHP built-in server
   php -S localhost:8000
   
   # Or using XAMPP/WAMP
   # Place files in htdocs/www directory
   ```

2. **Access the application:**
   - Main page: `http://localhost:8000/index.php`
   - Participants: `http://localhost:8000/participants.php`
   - Individual participant: `http://localhost:8000/participant.php?user=1`

## 🎨 Features

### Luxury Hotel Registration Form (`index.php`)
- ✅ **Elegant Bootstrap 5** responsive design with luxury hotel theme
- ✅ **Premium form validation** (client-side and server-side)
- ✅ **POST method** form submission with enhanced fields
- ✅ **SESSION storage** for hotel guests with additional data
- ✅ **Luxury styling** with gold accents and premium fonts
- ✅ **Hotel branding** with Grand Palace Hotel theme
- ✅ **Enhanced fields**: Guest count, special requests, luxury events

### Hotel Guests Management (`participants.php`)
- ✅ **GET parameter filtering** by luxury events
- ✅ **Statistics dashboard** with luxury styling
- ✅ **Responsive table** with guest data and premium design
- ✅ **Action buttons** for each guest with luxury styling
- ✅ **Hotel-themed** clear filter functionality
- ✅ **Premium animations** and hover effects

### Guest Details (`participant.php`)
- ✅ **GET parameter** to view specific guest (`?user=1`)
- ✅ **Detailed guest information** display with luxury cards
- ✅ **Navigation** back to guests list with premium buttons
- ✅ **Error handling** for invalid guest IDs
- ✅ **VIP guest styling** with luxury avatars and badges

## 🔍 Concept Application Examples

### POST Example
```php
// Form submission handling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    // Process and store in SESSION
}
```

### GET Example
```php
// URL: participants.php?event=Web Development Workshop
$filter_event = isset($_GET['event']) ? $_GET['event'] : '';

// URL: participant.php?user=1
$user_id = isset($_GET['user']) ? (int)$_GET['user'] : 0;
```

### SESSION Example
```php
// Store data across pages
$_SESSION['registrants'][$id] = array(
    'id' => $id,
    'name' => $name,
    'email' => $email,
    'event' => $event,
    'registration_date' => date('Y-m-d H:i:s')
);
```

## 📱 Responsive Design

- **Bootstrap 5** for modern, responsive layout
- **Mobile-first** design approach
- **Font Awesome** icons for better UX
- **Form validation** with Bootstrap classes
- **Card-based** layout for better organization

## 🎓 Learning Outcomes

This project demonstrates:
1. **POST**: Secure form data handling and processing
2. **GET**: URL parameter usage for filtering and navigation
3. **SESSION**: Temporary data persistence across pages
4. **Bootstrap**: Modern web design and responsive layouts
5. **PHP**: Server-side programming fundamentals

## 📝 Notes for Presentation

When presenting this project, explain:

1. **POST**: Show how the registration form submits data securely
2. **GET**: Demonstrate URL filtering (`?event=...`) and user details (`?user=1`)
3. **SESSION**: Explain how data persists between page visits
4. **Bootstrap**: Highlight responsive design and validation features

## 🔧 Technical Requirements

- PHP 7.4 or higher
- Web server (Apache/Nginx) or PHP built-in server
- Modern web browser
- No database required (uses SESSION storage)

---

**Created for Lab Activity 4.3**  
*Demonstrating POST, GET, and SESSION concepts in PHP*
