<?php
session_start();
require_once 'includes/tours.php';
require_once 'includes/functions.php';

$featured_tours = array_slice($tours, 0, 6);
$success_msg = isset($_SESSION['booking_success']) ? $_SESSION['booking_success'] : null;
unset($_SESSION['booking_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jamaica Wild Tours — Excursions, ATV, Rafting & More</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'includes/nav.php'; ?>

<!-- HERO -->
<section class="hero">
  <div class="hero-video-bg">
    <div class="hero-gradient"></div>
    <div class="floating-orb orb1"></div>
    <div class="floating-orb orb2"></div>
    <div class="floating-orb orb3"></div>
  </div>
  <div class="hero-content">
    <div class="hero-eyebrow">
      <span class="pulse-dot"></span>
      Montego Bay, Jamaica
    </div>
    <h1>Where <em>Wild</em> Meets<br>the Caribbean</h1>
    <p>From Rick's Café cliff dives to ATV mountain trails, river rafting to hidden waterfalls — Jamaica's most thrilling excursions, curated for the adventurous soul.</p>
    <div class="hero-ctas">
      <a href="tours.php" class="btn-hero-primary">Browse All Excursions</a>
      <a href="#featured" class="btn-hero-ghost">↓ See What's Popular</a>
    </div>
    <div class="hero-trust">
      <div class="trust-item"><strong>4,800+</strong><span>Adventures Booked</span></div>
      <div class="trust-divider"></div>
      <div class="trust-item"><strong>4.9★</strong><span>TripAdvisor Rating</span></div>
      <div class="trust-divider"></div>
      <div class="trust-item"><strong>100%</strong><span>Local Guides</span></div>
    </div>
  </div>
  <div class="hero-scroll-hint">Scroll to explore ↓</div>
</section>

<!-- CATEGORY PILLS -->
<section class="categories-bar">
  <div class="container">
    <a href="tours.php?category=all" class="cat-pill active">All Experiences</a>
    <a href="tours.php?category=water" class="cat-pill">🌊 Water</a>
    <a href="tours.php?category=adventure" class="cat-pill">🏍️ ATV & Offroad</a>
    <a href="tours.php?category=nightlife" class="cat-pill">🌅 Rick's Café</a>
    <a href="tours.php?category=rafting" class="cat-pill">🚣 Rafting</a>
    <a href="tours.php?category=culture" class="cat-pill">🎵 Culture</a>
    <a href="tours.php?category=nature" class="cat-pill">🌿 Nature</a>
    <a href="tours.php?category=food" class="cat-pill">🥃 Rum & Food</a>
  </div>
</section>

<!-- RICK'S CAFE SPOTLIGHT -->
<section class="spotlight">
  <div class="container spotlight-grid">
    <div class="spotlight-media">
      <div class="spotlight-img-frame">
        <div class="spotlight-emoji-bg">🌅</div>
        <div class="spotlight-badge">Most Popular</div>
      </div>
    </div>
    <div class="spotlight-content">
      <div class="section-label">Featured Experience</div>
      <h2 class="section-title">Rick's Café<br><em>Sunset & Cliff Diving</em></h2>
      <p>Perched on Negril's legendary West End cliffs, Rick's Café is the most iconic sunset destination in Jamaica. Watch fearless cliff divers plunge into the turquoise Caribbean while you sip cocktails as the sky turns gold. An experience unlike any other in the world.</p>
      <ul class="feature-list">
        <li>World-famous cliff diving show at sunset</li>
        <li>Cocktails with front-row ocean views</li>
        <li>Optional cliff dive participation</li>
        <li>Live reggae music nightly</li>
        <li>Complimentary round-trip transport from MoBay</li>
      </ul>
      <div class="spotlight-footer">
        <div class="spotlight-price">
          <span class="price-from">From</span>
          <span class="price-amount">$95</span>
          <span class="price-per">/ person</span>
        </div>
        <a href="book.php?tour=ricks-cafe-sunset" class="btn-primary">Book This Experience</a>
      </div>
    </div>
  </div>
</section>

<!-- FEATURED TOURS -->
<section class="featured-tours" id="featured">
  <div class="container">
    <div class="section-header">
      <div>
        <div class="section-label">Top Excursions</div>
        <h2 class="section-title">Adventures Waiting for You</h2>
      </div>
      <a href="tours.php" class="view-all-link">View all <?= count($tours) ?> tours →</a>
    </div>
    <div class="tours-grid">
      <?php foreach ($featured_tours as $tour): ?>
      <div class="tour-card" data-category="<?= $tour['category'] ?>">
        <div class="tour-card-img" style="background: <?= $tour['gradient'] ?>">
          <span class="tour-emoji"><?= $tour['emoji'] ?></span>
          <div class="tour-overlay-tags">
            <?php foreach ($tour['tags'] as $tag): ?>
            <span class="mini-tag"><?= htmlspecialchars($tag) ?></span>
            <?php endforeach; ?>
          </div>
          <?php if ($tour['popular']): ?>
          <div class="popular-badge">🔥 Popular</div>
          <?php endif; ?>
        </div>
        <div class="tour-card-body">
          <h3 class="tour-card-title"><?= htmlspecialchars($tour['name']) ?></h3>
          <p class="tour-card-desc"><?= htmlspecialchars($tour['short_desc']) ?></p>
          <div class="tour-card-meta">
            <span>⏱ <?= $tour['duration'] ?></span>
            <span>👥 Max <?= $tour['max_guests'] ?></span>
            <span>📍 <?= $tour['location'] ?></span>
          </div>
          <div class="tour-card-footer">
            <div class="tour-price">
              $<?= $tour['price'] ?><span>/person</span>
            </div>
            <a href="book.php?tour=<?= $tour['slug'] ?>" class="btn-book">Book Now</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="view-more-cta">
      <a href="tours.php" class="btn-outline">Explore All Excursions</a>
    </div>
  </div>
</section>

<!-- WHY US STRIP -->
<section class="why-strip">
  <div class="container why-grid">
    <div class="why-item">
      <div class="why-icon">🧭</div>
      <div class="why-text">
        <strong>Born & Raised Local</strong>
        <span>Every guide is Jamaican-born with deep community roots</span>
      </div>
    </div>
    <div class="why-item">
      <div class="why-icon">🛡️</div>
      <div class="why-text">
        <strong>Fully Licensed & Insured</strong>
        <span>Certified by Jamaica Tourist Board</span>
      </div>
    </div>
    <div class="why-item">
      <div class="why-icon">🔄</div>
      <div class="why-text">
        <strong>Free 48hr Cancellation</strong>
        <span>Full refund, no questions asked</span>
      </div>
    </div>
    <div class="why-item">
      <div class="why-icon">🚐</div>
      <div class="why-text">
        <strong>Hotel Pickup Included</strong>
        <span>AC transport from all major MoBay resorts</span>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials">
  <div class="container">
    <div class="section-label centered">Guest Reviews</div>
    <h2 class="section-title centered">Stories From the Island</h2>
    <div class="testimonials-grid">
      <div class="testi-card">
        <div class="testi-stars">★★★★★</div>
        <p>"The ATV mountain trail was INSANE — muddy, steep, breathtaking views. Our guide Devon made it safe and so fun. Best day of our whole trip by far."</p>
        <div class="testi-author">
          <div class="author-init">JM</div>
          <div><strong>James M.</strong><span>Houston, Texas</span></div>
        </div>
      </div>
      <div class="testi-card featured-testi">
        <div class="testi-stars">★★★★★</div>
        <p>"Rick's Café at sunset — I literally cried. The cliff divers, the music, the cocktails, the colors in the sky. We've traveled to 40 countries and this moment is in our top 5. Book it."</p>
        <div class="testi-author">
          <div class="author-init">LP</div>
          <div><strong>Lauren & Pete</strong><span>Melbourne, Australia</span></div>
        </div>
      </div>
      <div class="testi-card">
        <div class="testi-stars">★★★★★</div>
        <p>"River rafting on the Martha Brae was incredibly peaceful after our wild ATV morning. The combo day package is genius — do both. Don't overthink it."</p>
        <div class="testi-author">
          <div class="author-init">TC</div>
          <div><strong>Tanya C.</strong><span>Toronto, Canada</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- QUICK BOOKING BAND -->
<section class="quick-book-band">
  <div class="container">
    <div class="qb-text">
      <h3>Not sure which tour to pick?</h3>
      <p>Tell us what you love and we'll build your perfect Jamaica day.</p>
    </div>
    <a href="contact.php" class="btn-primary">Talk to a Local Expert</a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="assets/js/main.js"></script>
</body>
</html>
