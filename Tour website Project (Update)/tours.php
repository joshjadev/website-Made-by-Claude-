<?php
session_start();
require_once 'includes/tours.php';
require_once 'includes/functions.php';

$category = isset($_GET['category']) ? sanitize($_GET['category']) : 'all';
$location = isset($_GET['location']) ? sanitize($_GET['location']) : '';

$filtered = $tours;
if ($category !== 'all' && $category !== '') {
  $filtered = array_filter($tours, fn($t) => $t['category'] === $category);
}
if ($location !== '') {
  $filtered = array_filter($filtered, fn($t) => $t['location'] === $location);
}

$categories = [
  'all'       => ['label' => 'All Experiences', 'icon' => '🌴'],
  'nightlife' => ['label' => "Rick's Café",     'icon' => '🌅'],
  'adventure' => ['label' => 'ATV & Adventure', 'icon' => '🏍️'],
  'rafting'   => ['label' => 'River Rafting',   'icon' => '🚣'],
  'water'     => ['label' => 'Water Excursions','icon' => '🤿'],
  'nature'    => ['label' => 'Nature & Wildlife','icon' => '🌿'],
  'culture'   => ['label' => 'Culture & Music', 'icon' => '🎵'],
  'food'      => ['label' => 'Rum & Food',      'icon' => '🥃'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Excursions — Jamaica Wild Tours</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="page-hero-slim">
  <div class="container">
    <div class="section-label">Jamaica Wild Tours</div>
    <h1>All Excursions</h1>
    <p>Pick your adventure — from cliff-side sunsets to jungle ATV trails</p>
  </div>
</div>

<section class="tours-page">
  <div class="container">
    <!-- Filter Bar -->
    <div class="filter-bar-sticky">
      <?php foreach ($categories as $key => $cat): ?>
      <a href="tours.php?category=<?= $key ?>"
         class="filter-pill <?= $category === $key ? 'active' : '' ?>">
        <?= $cat['icon'] ?> <?= $cat['label'] ?>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- Results Count -->
    <div class="results-meta">
      <span><?= count($filtered) ?> excursion<?= count($filtered) !== 1 ? 's' : '' ?> found</span>
      <?php if ($location): ?>
      <span class="location-filter">📍 <?= htmlspecialchars($location) ?> <a href="tours.php?category=<?= $category ?>">✕ Clear</a></span>
      <?php endif; ?>
    </div>

    <!-- Tours Grid -->
    <?php if (count($filtered) === 0): ?>
    <div class="no-results">
      <div class="no-results-emoji">🌴</div>
      <h3>No excursions found</h3>
      <p>Try a different category or <a href="tours.php">browse all tours</a>.</p>
    </div>
    <?php else: ?>
    <div class="tours-grid tours-grid-large">
      <?php foreach ($filtered as $tour): ?>
      <div class="tour-card">
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
          <div class="difficulty-row">
            <span class="difficulty-badge" style="color: <?= difficulty_color($tour['difficulty']) ?>">
              ● <?= $tour['difficulty'] ?>
            </span>
            <span class="min-age">Min age: <?= $tour['min_age'] ?>+</span>
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
    <?php endif; ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="assets/js/main.js"></script>
</body>
</html>
