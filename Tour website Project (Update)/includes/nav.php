<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<nav class="main-nav" id="main-nav">
  <div class="nav-inner">
    <a href="index.php" class="nav-logo">
      Jamaica<span>Wild</span>Tours
    </a>
    <ul class="nav-links">
      <li><a href="index.php" <?= $current_page === 'index.php' ? 'class="active"' : '' ?>>Home</a></li>
      <li><a href="tours.php" <?= $current_page === 'tours.php' ? 'class="active"' : '' ?>>Excursions</a></li>
      <li class="nav-dropdown">
        <a href="#">Tours ▾</a>
        <div class="dropdown-menu">
          <a href="tours.php?category=nightlife">🌅 Rick's Café</a>
          <a href="tours.php?category=adventure">🏍️ ATV Adventures</a>
          <a href="tours.php?category=rafting">🚣 River Rafting</a>
          <a href="tours.php?category=water">🤿 Water Excursions</a>
          <a href="tours.php?category=nature">🌿 Nature & Wildlife</a>
          <a href="tours.php?category=culture">🎵 Culture Tours</a>
          <a href="tours.php?category=food">🥃 Rum & Food</a>
        </div>
      </li>
      <li><a href="contact.php" <?= $current_page === 'contact.php' ? 'class="active"' : '' ?>>Contact</a></li>
    </ul>
    <a href="tours.php" class="nav-book-btn">Book a Tour</a>
    <button class="nav-burger" id="nav-burger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
  <div class="mobile-menu" id="mobile-menu">
    <a href="index.php">Home</a>
    <a href="tours.php">All Excursions</a>
    <a href="tours.php?category=nightlife">Rick's Café</a>
    <a href="tours.php?category=adventure">ATV Adventures</a>
    <a href="tours.php?category=rafting">River Rafting</a>
    <a href="tours.php?category=water">Water Excursions</a>
    <a href="tours.php?category=nature">Nature & Wildlife</a>
    <a href="tours.php?category=food">Rum & Food</a>
    <a href="contact.php">Contact Us</a>
    <a href="tours.php" class="mobile-book-btn">Book a Tour</a>
  </div>
</nav>
