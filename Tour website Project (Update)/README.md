# Jamaica Wild Tours — Website

A complete PHP/HTML tour booking website for a Jamaica excursion company.

## Pages

| File | Description |
|---|---|
| `index.php` | Homepage with hero, featured tours, spotlight, testimonials |
| `tours.php` | Full filterable excursions listing (12 tours) |
| `book.php` | Booking form (pre-fills when linked from a tour) |
| `confirmation.php` | Post-booking confirmation with confetti |
| `contact.php` | Contact form with FAQ accordion |
| `404.php` | Custom 404 error page |

## Tours Included

1. Rick's Café Sunset & Cliff Diving
2. ATV Mountain Adventure
3. Martha Brae River Rafting
4. Dunn's River Falls Climb
5. Luminous Lagoon Night Swim
6. Blue Mountain Coffee Trek
7. Appleton Estate Rum Tour
8. Horseback Ride & Ocean Swim
9. Negril Snorkeling & Coral Reef
10. Reggae & Culture: Kingston Deep Dive
11. Black River Crocodile Safari
12. YS Falls & Zip-line Combo

## Setup Requirements

- PHP 7.4 or higher
- Apache with `mod_rewrite` enabled (for .htaccess)
- OR Nginx (configure manually for PHP)

## Local Development

### With XAMPP / MAMP / WAMP
1. Extract this folder into your `htdocs` (XAMPP) or `www` (MAMP) directory
2. Rename the folder to `jamaica-tours` (or your preferred name)
3. Visit `http://localhost/jamaica-tours/`

### With PHP Built-in Server
```bash
cd jamaica-tours
php -S localhost:8080
```
Then visit `http://localhost:8080`

## File Structure

```
jamaica-tours/
├── index.php               # Homepage
├── tours.php               # All tours listing
├── book.php                # Booking form
├── confirmation.php        # Booking confirmation
├── contact.php             # Contact page
├── 404.php                 # Error page
├── .htaccess               # Apache config
├── includes/
│   ├── tours.php           # All tour data
│   ├── functions.php       # Helper functions
│   ├── nav.php             # Navigation partial
│   └── footer.php          # Footer partial
└── assets/
    ├── css/
    │   └── style.css       # All styles
    └── js/
        └── main.js         # All JavaScript
```

## Customisation

### Adding a New Tour
Edit `includes/tours.php` and add a new array entry following the existing pattern.

### Changing Prices
All prices are in `includes/tours.php` — update the `'price'` field for each tour.

### Changing Contact Details
Search for `555-0192` and `hello@jamaicawildtours.com` across all files to update phone/email.

### Real Email Integration
In `book.php` and `contact.php`, replace the session redirect with PHP `mail()` or an SMTP library like PHPMailer:
```php
mail($to, $subject, $message, $headers);
```

## Design System

| Variable | Value | Use |
|---|---|---|
| `--gold` | `#C9A84C` | Primary accent |
| `--dark` | `#0B1A12` | Background |
| `--text` | `#F2E8D4` | Body text |
| `--success` | `#2ECC71` | Success states |

Fonts: **Cormorant Garamond** (headings) + **Outfit** (body)

---

Built with ❤️ in Jamaica 🇯🇲
