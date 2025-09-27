<?php 
include("db.php"); 
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="user.css" />
    <!-- <link rel="stylesheet" href="app.css" /> -->
    <script defer src="user.js"></script>
    <title>User Dashboard</title>
  </head>
  <body>
    <!-- Top Navigation -->
    <nav class="top-nav">
      <div class="nav-content">
        <div class="logo">
          <div class="logo-icon">P</div>
          <span class="sage">Re-Value.PH</span>
        </div>

        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
          ☰
        </button>

        <div class="user-menu">
          <div class="user-info">
            <div class="user-avatar"><?php
        if (isset($_SESSION['full_name'])) {
            $parts = explode(" ", $_SESSION['full_name']);
            $initials = "";
            foreach ($parts as $p) {
                $initials .= strtoupper($p[0]);
            }
            echo $initials; // e.g. DH
        } else {
            echo "G"; // Default for guest
        }
      ?>
    
      </div>
        <!-- Show full name -->
    <span class="user-name">
      <?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Guest'; ?>
    </span>
            <!-- PHP: Replace static name with -->
            
          </div>
          <!-- PHP: Logout button will POST to logout.php -->
          <button class="btn-logout" onclick="handleLogout()">Logout</button>
        </div>
      </div>
    </nav>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
      <!-- Sidebar Navigation -->
      <aside class="sidebar" id="sidebar">
        <nav>
          <ul class="sidebar-nav">
            <li class="nav-item">
              <a href="#" class="nav-link active" data-section="overview">
                <span class="nav-icon">📊</span>
                <span>Dashboard Overview</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" data-section="orders">
                <span class="nav-icon">📦</span>
                <span>My Orders</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" data-section="spent">
                <span class="nav-icon">💰</span>
                <span>Total Spent</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" data-section="addresses">
                <span class="nav-icon">📍</span>
                <span>Address Book</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" data-section="personal">
                <span class="nav-icon">👤</span>
                <span>Personal Details</span>
              </a>
            </li>
          </ul>
        </nav>
      </aside>

      <!-- Main Content Area -->
      <main class="main-content">
        <!-- Overview Section -->
        <section id="overview" class="content-section active">
          <div class="section-header">
            <h1 class="section-title">Dashboard Overview</h1>
            <p class="section-subtitle">
              Welcome back! Here's what's happening with your account.
            </p>
          </div>

          <div class="stats-grid">
            <!-- PHP: These values will be populated from database queries -->
            <!-- Example: SELECT COUNT(*) as total_orders FROM orders WHERE user_id = $_SESSION['user_id'] -->
            <div class="stat-card">
              <div class="stat-icon">📦</div>
              <div class="stat-value" id="totalOrders">24</div>
              <div class="stat-label">Total Orders</div>
            </div>

            <!-- PHP: SELECT SUM(total_amount) as total_spent FROM orders WHERE user_id = $_SESSION['user_id'] -->
            <div class="stat-card">
              <div class="stat-icon">💵</div>
              <div class="stat-value" id="totalSpentOverview">$3,247.50</div>
              <div class="stat-label">Total Spent</div>
            </div>

            <!-- PHP: SELECT created_at FROM orders WHERE user_id = $_SESSION['user_id'] ORDER BY created_at DESC LIMIT 1 -->
            <div class="stat-card">
              <div class="stat-icon">📅</div>
              <div class="stat-value" id="lastOrderDate">Dec 15, 2024</div>
              <div class="stat-label">Last Order</div>
            </div>
          </div>

          <div class="section-header">
            <h2 class="section-title">Recent Activity</h2>
          </div>

          <div class="table-container">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody id="recentOrdersTable">
                <!-- PHP: This will be populated with recent orders -->
                <!-- Query: SELECT * FROM orders WHERE user_id = $_SESSION['user_id'] ORDER BY created_at DESC LIMIT 5 -->
              </tbody>
            </table>
          </div>
        </section>

        <!-- Orders Section -->
        <section id="orders" class="content-section">
          <div class="section-header">
            <h1 class="section-title">My Orders</h1>
            <p class="section-subtitle">
              Track and manage all your orders in one place.
            </p>
          </div>

          <div class="table-container">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Date</th>
                  <th>Items</th>
                  <th>Status</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody id="ordersTable">
                <!-- PHP: Replace with database query -->
                <!-- SELECT * FROM orders WHERE user_id = $_SESSION['user_id'] ORDER BY created_at DESC -->
              </tbody>
            </table>
          </div>
        </section>

        <!-- Total Spent Section -->
        <section id="spent" class="content-section">
          <div class="section-header">
            <h1 class="section-title">Total Spent</h1>
            <p class="section-subtitle">
              Track your spending and set budgets for future purchases.
            </p>
          </div>

          <div class="stats-grid">
            <div class="spent-card">
              <div class="spent-amount" id="totalSpent">
                <!-- PHP: Replace with SUM(total_amount) from orders WHERE user_id = $_SESSION['user_id'] -->
                $3,247.50
              </div>
              <div class="spent-label">Lifetime Spending</div>
            </div>
          </div>

          <div class="section-header">
            <h2 class="section-title">Spending Breakdown</h2>
          </div>

          <div class="table-container">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Month</th>
                  <th>Amount</th>
                  <th>Orders</th>
                  <th>Average Order Value</th>
                </tr>
              </thead>
              <tbody id="spendingBreakdownTable">
                <!-- PHP: Replace with SELECT MONTH(created_at), SUM(total_amount), COUNT(*), AVG(total_amount) FROM orders GROUP BY MONTH(created_at) -->
              </tbody>
            </table>
          </div>
        </section>

        <!-- Address Book Section -->
        <section id="addresses" class="content-section">
          <div class="section-header">
            <h1 class="section-title">Address Book</h1>
            <p class="section-subtitle">
              Manage your saved shipping and billing addresses.
            </p>
          </div>

          <div style="text-align: right; margin-bottom: var(--spacing-lg)">
            <!-- PHP: This button will trigger modal or redirect to add_address.php -->
            <button class="btn btn-primary" onclick="showAddAddressModal()">
              + Add Address
            </button>
          </div>

          <div class="address-grid" id="addressGrid">
            <!-- PHP: Replace with database query -->
            <!-- SELECT * FROM addresses WHERE user_id = $_SESSION['user_id'] -->
          </div>
        </section>

        <!-- Personal Details Section -->
        <section id="personal" class="content-section">
          <div class="section-header">
            <h1 class="section-title">Personal Details</h1>
            <p class="section-subtitle">
              Update your personal information and account settings.
            </p>
          </div>

          <form id="personalDetailsForm">
            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="firstName">First Name</label>
                <input
                  type="text"
                  id="firstName"
                  class="form-input"
                  value=""
                  required
                />
                <!-- PHP: value="<?php echo htmlspecialchars($_SESSION['first_name']); ?>" -->
              </div>
              <div class="form-group">
                <label class="form-label" for="lastName">Last Name</label>
                <input
                  type="text"
                  id="lastName"
                  class="form-input"
                  value=""
                  required
                />
                <!-- PHP: value="<?php echo htmlspecialchars($_SESSION['last_name']); ?>" -->
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="email">Email Address</label>
              <input
                type="email"
                id="email"
                class="form-input"
                value=""
                required
              />
              <!-- PHP: value="<?php echo htmlspecialchars($_SESSION['email']); ?>" -->
            </div>

            <div class="form-group">
              <label class="form-label" for="phone">Phone Number</label>
              <input type="tel" id="phone" class="form-input" value="" />
              <!-- PHP: value="<?php echo htmlspecialchars($_SESSION['phone']); ?>" -->
            </div>

            <div class="form-group">
              <label class="form-label" for="birthdate">Birth Date</label>
              <input type="date" id="birthdate" class="form-input" value="" />
              <!-- PHP: value="<?php echo $_SESSION['birthdate']; ?>" -->
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="city">City</label>
                <input type="text" id="city" class="form-input" value="" />
                <!-- PHP: value="<?php echo htmlspecialchars($_SESSION['city']); ?>" -->
              </div>
              <div class="form-group">
                <label class="form-label" for="country">Country</label>
                <select id="country" class="form-input">
                  <option value="">Select Country</option>
                  <option value="US">United States</option>
                  <option value="CA">Canada</option>
                  <option value="UK">United Kingdom</option>
                  <option value="AU">Australia</option>
                  <option value="DE">Germany</option>
                  <!-- PHP: Populate from database or static array -->
                </select>
                <!-- PHP: Set selected option based on $_SESSION['country'] -->
              </div>
            </div>

            <div
              style="
                display: flex;
                gap: var(--spacing-md);
                justify-content: flex-end;
                margin-top: var(--spacing-2xl);
              "
            >
              <button
                type="button"
                class="btn btn-secondary"
                onclick="resetForm()"
              >
                Reset
              </button>
              <button type="submit" class="btn btn-primary">
                Save Changes
              </button>
              <!-- PHP: On form submission, POST to update_profile.php -->
            </div>
          </form>
        </section>
      </main>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast" class="toast"></div>
  </body>
</html>
