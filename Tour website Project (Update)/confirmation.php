<?php
session_start();
require_once 'includes/functions.php';

if (!isset($_SESSION['booking_success'])) {
  header('Location: index.php');
  exit;
}

$b = $_SESSION['booking_success'];
unset($_SESSION['booking_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Confirmed — Jamaica Wild Tours</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="confirmation-body">

<?php include 'includes/nav.php'; ?>

<section class="confirmation-section">
  <div class="container confirmation-container">
    <div class="confetti-zone" id="confetti-zone"></div>

    <div class="confirm-card">
      <div class="confirm-check">✓</div>
      <div class="confirm-eyebrow">Booking Request Received!</div>
      <h1 class="confirm-title">You're headed to Jamaica, <?= htmlspecialchars($b['name']) ?>!</h1>
      <p class="confirm-subtitle">We'll confirm your booking and send details to <strong><?= htmlspecialchars($b['email']) ?></strong> within 2 hours.</p>

      <div class="confirm-details">
        <div class="confirm-ref">
          <span class="ref-label">Booking Reference</span>
          <span class="ref-code"><?= htmlspecialchars($b['ref']) ?></span>
        </div>
        <div class="confirm-grid">
          <div class="confirm-item">
            <span class="ci-label">Tour</span>
            <span class="ci-value"><?= htmlspecialchars($b['tour']) ?></span>
          </div>
          <div class="confirm-item">
            <span class="ci-label">Date</span>
            <span class="ci-value"><?= date('l, F j, Y', strtotime($b['date'])) ?></span>
          </div>
          <div class="confirm-item">
            <span class="ci-label">Guests</span>
            <span class="ci-value"><?= $b['guests'] ?> <?= $b['guests'] === 1 ? 'person' : 'people' ?></span>
          </div>
          <div class="confirm-item">
            <span class="ci-label">Estimated Total</span>
            <span class="ci-value price-highlight">$<?= number_format($b['total'], 0) ?></span>
          </div>
        </div>
      </div>

      <div class="confirm-next-steps">
        <h3>What Happens Next?</h3>
        <div class="next-step">
          <div class="step-num">1</div>
          <div><strong>Confirmation Email</strong> — We'll send your full booking details and pickup time within 2 hours.</div>
        </div>
        <div class="next-step">
          <div class="step-num">2</div>
          <div><strong>WhatsApp Message</strong> — Our team will message you directly to confirm pickup location and logistics.</div>
        </div>
        <div class="next-step">
          <div class="step-num">3</div>
          <div><strong>Day of Tour</strong> — Your guide meets you at your hotel. Get ready for an unforgettable day!</div>
        </div>
      </div>

      <div class="confirm-actions">
        <a href="tours.php" class="btn-primary">Browse More Excursions</a>
        <a href="index.php" class="btn-ghost">← Back to Home</a>
      </div>

      <div class="confirm-contact">
        Need to change your booking? Call us: <a href="tel:+18765550192">+1 (876) 555-0192</a> or <a href="#">WhatsApp</a>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<script>
function launchConfetti() {
  const zone = document.getElementById('confetti-zone');
  const colors = ['#C9A84C','#2ECC71','#E74C3C','#3498DB','#F39C12'];
  for (let i = 0; i < 80; i++) {
    const piece = document.createElement('div');
    piece.style.cssText = `
      position:absolute;
      width:${6 + Math.random()*6}px;
      height:${6 + Math.random()*6}px;
      background:${colors[Math.floor(Math.random()*colors.length)]};
      border-radius:${Math.random() > 0.5 ? '50%' : '2px'};
      left:${Math.random()*100}%;
      top:-10px;
      animation: confettiFall ${1.5 + Math.random()*2}s ease-in ${Math.random()*0.8}s forwards;
      transform: rotate(${Math.random()*360}deg);
    `;
    zone.appendChild(piece);
  }
}
launchConfetti();
</script>
<script src="assets/js/main.js"></script>
</body>
</html>
