<?php
function get_tour_by_slug($slug, $tours) {
  foreach ($tours as $tour) {
    if ($tour['slug'] === $slug) return $tour;
  }
  return null;
}

function sanitize($val) {
  return htmlspecialchars(strip_tags(trim($val)));
}

function format_price($price) {
  return '$' . number_format($price, 0);
}

function difficulty_color($level) {
  $map = [
    'Easy'       => '#2ECC71',
    'Moderate'   => '#F39C12',
    'Challenging'=> '#E74C3C',
  ];
  return $map[$level] ?? '#888';
}
?>
