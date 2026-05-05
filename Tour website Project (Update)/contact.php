<?php
session_start();
require_once 'includes/functions.php';

$errors = [];
$form_data = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form_data = [
    'name'    => sanitize($_POST['name'] ?? ''),
    'email'   => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
    'subject' => sanitize($_POST['subject'] ?? ''),
    'message' => sanitize($_POST['message'] ?? ''),
  ];
  if (!$form_data['name'])    $errors[] = 'Name is required.';
  if (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
  if (!$form_data['message']) $errors[] = 'Message is required.';

  if (empty($errors)) {
    $success = true;
    $form_data = [];
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us — Jamaica Wild Tours</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="page-hero-slim">
  <div class="container">
    <div class="section-label">Get in Touch</div>
    <h1>Talk to a Local Expert</h1>
    <p>We know Jamaica inside out — let us plan your perfect adventure</p>
  </div>
</div>

<section class="contact-section">
  <div class="container contact-layout">
    <div class="contact-info">
      <h2>We're Here for You</h2>
      <p>Have questions about excursions, group bookings, or building a custom itinerary? Our local team responds within 2 hours.</p>

      <div class="contact-cards">
        <div class="contact-card">
          <div class="cc-icon">📞</div>
          <div>
            <strong>Call or WhatsApp</strong>
            <span>+1 (876) 555-0192</span>
            <span>Mon–Sun, 7am–8pm</span>
          </div>
        </div>
        <div class="contact-card">
          <div class="cc-icon">✉️</div>
          <div>
            <strong>Email Us</strong>
            <span>hello@jamaicawildtours.com</span>
            <span>Reply within 2 hours</span>
          </div>
        </div>
        <div class="contact-card">
          <div class="cc-icon">📍</div>
          <div>
            <strong>Walk-In Office</strong>
            <span>Queens Drive, Montego Bay</span>
            <span>Near Sangster International</span>
          </div>
        </div>
      </div>

      <div class="popular-questions">
        <h3>Common Questions</h3>
        <details>
          <summary>Do you offer hotel pickup?</summary>
          <p>Yes! We offer complimentary pickup from all major Montego Bay resorts and many hotels in Ocho Rios and Negril. Just let us know where you're staying when you book.</p>
        </details>
        <details>
          <summary>Can we book for large groups?</summary>
          <p>Absolutely. We can accommodate groups of up to 50+ with private tours. Contact us directly for group pricing — we offer significant discounts for 10+ guests.</p>
        </details>
        <details>
          <summary>What's your cancellation policy?</summary>
          <p>Free cancellation up to 48 hours before your tour. Within 48 hours, we offer a full credit for rescheduling. We understand that travel plans change.</p>
        </details>
        <details>
          <summary>Can we do multiple tours in one day?</summary>
          <p>Yes! Several tours pair beautifully — for example, ATV in the morning and Martha Brae Rafting in the afternoon. We'll design a full-day itinerary for you.</p>
        </details>
      </div>
    </div>

    <div class="contact-form-wrap">
      <?php if ($success): ?>
      <div class="contact-success">
        <div class="success-icon">🌴</div>
        <h3>Message Received!</h3>
        <p>Thanks for reaching out. Our team will reply to your email within 2 hours. One love!</p>
        <a href="index.php" class="btn-primary">Back to Home</a>
      </div>
      <?php else: ?>
      <h2 class="form-title">Send Us a Message</h2>

      <?php if (!empty($errors)): ?>
      <div class="form-errors">
        <strong>⚠ Please fix:</strong>
        <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
      </div>
      <?php endif; ?>

      <form method="POST" action="contact.php">
        <div class="form-group">
          <label for="name">Your Name *</label>
          <input type="text" id="name" name="name" required
                 value="<?= htmlspecialchars($form_data['name'] ?? '') ?>"
                 placeholder="Full name">
        </div>
        <div class="form-group">
          <label for="email">Email Address *</label>
          <input type="email" id="email" name="email" required
                 value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"
                 placeholder="your@email.com">
        </div>
        <div class="form-group">
          <label for="subject">What can we help with?</label>
          <select id="subject" name="subject">
            <option value="">— Select a topic —</option>
            <option value="booking" <?= ($form_data['subject'] ?? '') === 'booking' ? 'selected' : '' ?>>Booking a tour</option>
            <option value="group" <?= ($form_data['subject'] ?? '') === 'group' ? 'selected' : '' ?>>Group / Private tour</option>
            <option value="custom" <?= ($form_data['subject'] ?? '') === 'custom' ? 'selected' : '' ?>>Custom itinerary</option>
            <option value="info" <?= ($form_data['subject'] ?? '') === 'info' ? 'selected' : '' ?>>General information</option>
            <option value="change" <?= ($form_data['subject'] ?? '') === 'change' ? 'selected' : '' ?>>Change / Cancel booking</option>
          </select>
        </div>
        <div class="form-group">
          <label for="message">Your Message *</label>
          <textarea id="message" name="message" rows="5" required
                    placeholder="Tell us what you're looking for — travel dates, group size, interests..."><?= htmlspecialchars($form_data['message'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn-submit">Send Message →</button>
      </form>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="assets/js/main.js"></script>
</body>
</html>
