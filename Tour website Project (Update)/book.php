<?php
session_start();
require_once 'includes/tours.php';
require_once 'includes/functions.php';

$slug = isset($_GET['tour']) ? sanitize($_GET['tour']) : '';
$tour = get_tour_by_slug($slug, $tours);
$errors = [];
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form_data = [
    'first_name'  => sanitize($_POST['first_name'] ?? ''),
    'last_name'   => sanitize($_POST['last_name'] ?? ''),
    'email'       => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
    'phone'       => sanitize($_POST['phone'] ?? ''),
    'hotel'       => sanitize($_POST['hotel'] ?? ''),
    'tour_date'   => sanitize($_POST['tour_date'] ?? ''),
    'guests'      => intval($_POST['guests'] ?? 1),
    'adults'      => intval($_POST['adults'] ?? 1),
    'children'    => intval($_POST['children'] ?? 0),
    'special'     => sanitize($_POST['special'] ?? ''),
    'tour_slug'   => sanitize($_POST['tour_slug'] ?? ''),
    'payment'     => sanitize($_POST['payment'] ?? ''),
  ];

  $selected_tour = get_tour_by_slug($form_data['tour_slug'], $tours);

  if (!$form_data['first_name']) $errors[] = 'First name is required.';
  if (!$form_data['last_name'])  $errors[] = 'Last name is required.';
  if (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
  if (!$form_data['tour_date'])  $errors[] = 'Please select a tour date.';
  if (!$selected_tour)           $errors[] = 'Please select a valid tour.';
  if ($form_data['guests'] < 1)  $errors[] = 'At least 1 guest required.';
  if ($selected_tour && $form_data['guests'] > $selected_tour['max_guests']) {
    $errors[] = 'Maximum group size for this tour is ' . $selected_tour['max_guests'] . ' guests. Please contact us for larger groups.';
  }
  if (!$form_data['payment']) $errors[] = 'Please select a payment method.';

  if (empty($errors)) {
    $total = $selected_tour['price'] * $form_data['adults'] + ($selected_tour['price'] * 0.6 * $form_data['children']);
    $ref = strtoupper(substr($selected_tour['slug'], 0, 3)) . '-' . date('ymd') . '-' . rand(100, 999);
    $_SESSION['booking_success'] = [
      'ref'   => $ref,
      'tour'  => $selected_tour['name'],
      'date'  => $form_data['tour_date'],
      'guests'=> $form_data['guests'],
      'total' => $total,
      'email' => $form_data['email'],
      'name'  => $form_data['first_name'],
    ];
    header('Location: confirmation.php');
    exit;
  }
}

$other_tours = array_filter($tours, fn($t) => $t['slug'] !== $slug);
$min_date = date('Y-m-d', strtotime('+1 day'));
$max_date = date('Y-m-d', strtotime('+180 days'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book <?= $tour ? htmlspecialchars($tour['name']) : 'a Tour' ?> — Jamaica Wild Tours</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="page-hero-slim">
  <div class="container">
    <div class="section-label">Secure Booking</div>
    <h1><?= $tour ? htmlspecialchars($tour['name']) : 'Book a Tour' ?></h1>
    <p>Fill in your details and we'll confirm within 2 hours</p>
  </div>
</div>

<section class="booking-section">
  <div class="container booking-layout">

    <!-- BOOKING FORM -->
    <div class="booking-form-wrap">
      <h2 class="form-title">Your Booking Details</h2>

      <?php if (!empty($errors)): ?>
      <div class="form-errors">
        <strong>⚠ Please fix the following:</strong>
        <ul>
          <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <form method="POST" action="book.php" id="booking-form" novalidate>
        <input type="hidden" name="tour_slug" value="<?= $tour ? $tour['slug'] : ($form_data['tour_slug'] ?? '') ?>">

        <!-- TOUR SELECTOR (if no tour pre-selected) -->
        <?php if (!$tour): ?>
        <div class="form-group">
          <label for="tour_select">Select a Tour *</label>
          <select name="tour_slug" id="tour_select" required onchange="updateTourInfo(this.value)">
            <option value="">— Choose your adventure —</option>
            <?php foreach ($tours as $t): ?>
            <option value="<?= $t['slug'] ?>" <?= ($form_data['tour_slug'] ?? '') === $t['slug'] ? 'selected' : '' ?>>
              <?= $t['emoji'] ?> <?= htmlspecialchars($t['name']) ?> — $<?= $t['price'] ?>/person
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <?php else: ?>
        <!-- Tour switcher link -->
        <div class="tour-switcher">
          <span class="tour-switch-emoji"><?= $tour['emoji'] ?></span>
          <strong><?= htmlspecialchars($tour['name']) ?></strong>
          <a href="tours.php" class="switch-link">Change tour ↗</a>
        </div>
        <?php endif; ?>

        <div class="form-row">
          <div class="form-group">
            <label for="first_name">First Name *</label>
            <input type="text" id="first_name" name="first_name" required
                   value="<?= htmlspecialchars($form_data['first_name'] ?? '') ?>"
                   placeholder="e.g. Marcus">
          </div>
          <div class="form-group">
            <label for="last_name">Last Name *</label>
            <input type="text" id="last_name" name="last_name" required
                   value="<?= htmlspecialchars($form_data['last_name'] ?? '') ?>"
                   placeholder="e.g. Johnson">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" required
                   value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"
                   placeholder="your@email.com">
          </div>
          <div class="form-group">
            <label for="phone">WhatsApp / Phone</label>
            <input type="tel" id="phone" name="phone"
                   value="<?= htmlspecialchars($form_data['phone'] ?? '') ?>"
                   placeholder="+1 876 555 0192">
          </div>
        </div>

        <div class="form-group">
          <label for="hotel">Hotel / Resort Name</label>
          <input type="text" id="hotel" name="hotel"
                 value="<?= htmlspecialchars($form_data['hotel'] ?? '') ?>"
                 placeholder="Sandals Royal Caribbean, Half Moon, etc.">
          <small>We'll arrange pickup from your hotel</small>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="tour_date">Tour Date *</label>
            <input type="date" id="tour_date" name="tour_date" required
                   min="<?= $min_date ?>" max="<?= $max_date ?>"
                   value="<?= htmlspecialchars($form_data['tour_date'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label for="guests">Total Guests *</label>
            <select id="guests" name="guests" required onchange="updateTotal()">
              <?php for ($i = 1; $i <= ($tour ? $tour['max_guests'] : 14); $i++): ?>
              <option value="<?= $i ?>" <?= ($form_data['guests'] ?? 1) == $i ? 'selected' : '' ?>>
                <?= $i ?> <?= $i === 1 ? 'Guest' : 'Guests' ?>
              </option>
              <?php endfor; ?>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="adults">Adults (13+) *</label>
            <select id="adults" name="adults" onchange="updateTotal()">
              <?php for ($i = 1; $i <= 14; $i++): ?>
              <option value="<?= $i ?>" <?= ($form_data['adults'] ?? 1) == $i ? 'selected' : '' ?>>
                <?= $i ?>
              </option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="children">Children 4–12 (60% off)</label>
            <select id="children" name="children" onchange="updateTotal()">
              <?php for ($i = 0; $i <= 10; $i++): ?>
              <option value="<?= $i ?>" <?= ($form_data['children'] ?? 0) == $i ? 'selected' : '' ?>>
                <?= $i ?>
              </option>
              <?php endfor; ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="special">Special Requests / Notes</label>
          <textarea id="special" name="special" rows="3"
                    placeholder="Dietary needs, mobility requirements, celebrating something special..."><?= htmlspecialchars($form_data['special'] ?? '') ?></textarea>
        </div>

        <!-- PAYMENT METHOD -->
        <div class="form-group">
          <label>Payment Method *</label>
          <div class="payment-options">
            <label class="payment-option <?= ($form_data['payment'] ?? '') === 'card' ? 'selected' : '' ?>">
              <input type="radio" name="payment" value="card" <?= ($form_data['payment'] ?? '') === 'card' ? 'checked' : '' ?>>
              <span class="payment-icon">💳</span>
              <span>Credit / Debit Card</span>
            </label>
            <label class="payment-option <?= ($form_data['payment'] ?? '') === 'paypal' ? 'selected' : '' ?>">
              <input type="radio" name="payment" value="paypal" <?= ($form_data['payment'] ?? '') === 'paypal' ? 'checked' : '' ?>>
              <span class="payment-icon">🅿️</span>
              <span>PayPal</span>
            </label>
            <label class="payment-option <?= ($form_data['payment'] ?? '') === 'cash' ? 'selected' : '' ?>">
              <input type="radio" name="payment" value="cash" <?= ($form_data['payment'] ?? '') === 'cash' ? 'checked' : '' ?>>
              <span class="payment-icon">💵</span>
              <span>Pay Cash on Day</span>
            </label>
          </div>
        </div>

        <div class="form-terms">
          <input type="checkbox" id="agree" name="agree" required>
          <label for="agree">I agree to the <a href="#">Terms & Cancellation Policy</a>. Free cancellation up to 48 hours before the tour date.</label>
        </div>

        <button type="submit" class="btn-submit" id="submit-btn">
          Confirm & Request Booking →
        </button>
        <p class="submit-note">No payment taken now. We'll contact you within 2 hours to confirm.</p>
      </form>
    </div>

    <!-- SIDEBAR: Tour Summary -->
    <aside class="booking-sidebar">
      <?php if ($tour): ?>
      <div class="summary-card">
        <div class="summary-img" style="background: <?= $tour['gradient'] ?>">
          <span><?= $tour['emoji'] ?></span>
        </div>
        <div class="summary-body">
          <h3><?= htmlspecialchars($tour['name']) ?></h3>
          <div class="summary-meta">
            <span>⏱ <?= $tour['duration'] ?></span>
            <span>📍 <?= $tour['location'] ?></span>
            <span>👥 Max <?= $tour['max_guests'] ?></span>
          </div>
          <div class="summary-includes">
            <strong>What's Included:</strong>
            <ul>
              <?php foreach ($tour['includes'] as $item): ?>
              <li>✓ <?= htmlspecialchars($item) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="price-breakdown" id="price-breakdown">
            <div class="price-row">
              <span>Price per adult</span>
              <span>$<?= $tour['price'] ?></span>
            </div>
            <div class="price-row">
              <span>Price per child (4–12)</span>
              <span>$<?= number_format($tour['price'] * 0.6, 0) ?></span>
            </div>
            <div class="price-row price-total">
              <span>Estimated Total</span>
              <span id="total-display">$<?= $tour['price'] ?></span>
            </div>
          </div>
        </div>
      </div>
      <?php else: ?>
      <div class="summary-card placeholder-card">
        <div class="placeholder-icon">🌴</div>
        <h3>Choose Your Tour</h3>
        <p>Select an excursion from the dropdown and your summary will appear here.</p>
        <a href="tours.php" class="btn-outline-sm">Browse All Tours</a>
      </div>
      <?php endif; ?>

      <div class="trust-card">
        <h4>Why Book With Us?</h4>
        <div class="trust-item-sm"><span>🛡️</span><span>Licensed by Jamaica Tourist Board</span></div>
        <div class="trust-item-sm"><span>🔄</span><span>Free cancellation 48hrs before</span></div>
        <div class="trust-item-sm"><span>🚐</span><span>Hotel pickup included</span></div>
        <div class="trust-item-sm"><span>📞</span><span>Confirmed within 2 hours</span></div>
        <div class="trust-item-sm"><span>⭐</span><span>4.9/5 on TripAdvisor</span></div>
      </div>

      <!-- Other tours -->
      <div class="other-tours-card">
        <h4>Other Popular Excursions</h4>
        <?php
        $popular = array_filter($tours, fn($t) => $t['popular'] && $t['slug'] !== $slug);
        $popular = array_slice($popular, 0, 3);
        foreach ($popular as $pt): ?>
        <a href="book.php?tour=<?= $pt['slug'] ?>" class="other-tour-item">
          <span class="ot-emoji"><?= $pt['emoji'] ?></span>
          <div class="ot-info">
            <strong><?= htmlspecialchars($pt['name']) ?></strong>
            <span>From $<?= $pt['price'] ?>/person</span>
          </div>
          <span class="ot-arrow">→</span>
        </a>
        <?php endforeach; ?>
      </div>
    </aside>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<script>
const tourPrices = <?= json_encode(array_column($tours, 'price', 'slug')) ?>;
const tourMaxGuests = <?= json_encode(array_column($tours, 'max_guests', 'slug')) ?>;

function updateTotal() {
  const slug = document.querySelector('[name="tour_slug"]')?.value || '<?= $tour ? $tour['slug'] : '' ?>';
  const price = tourPrices[slug] || 0;
  const adults = parseInt(document.getElementById('adults')?.value || 1);
  const children = parseInt(document.getElementById('children')?.value || 0);
  const total = (price * adults) + (price * 0.6 * children);
  const el = document.getElementById('total-display');
  if (el) el.textContent = '$' + Math.round(total);
}

function updateTourInfo(slug) {
  updateTotal();
}

document.querySelectorAll('.payment-option').forEach(opt => {
  opt.addEventListener('click', () => {
    document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
    opt.classList.add('selected');
  });
});

document.getElementById('guests')?.addEventListener('change', function() {
  const adults = document.getElementById('adults');
  const children = document.getElementById('children');
  const max = parseInt(this.value);
  if (parseInt(adults.value) + parseInt(children.value) > max) {
    adults.value = Math.min(parseInt(adults.value), max);
    children.value = 0;
  }
  updateTotal();
});

updateTotal();
</script>
<script src="assets/js/main.js"></script>
</body>
</html>
