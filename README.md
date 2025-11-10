# Huisartspraktijk Website

Een moderne, responsieve website voor een huisartspraktijk gebouwd met PHP, HTML, CSS en JavaScript.

## Features

- ✅ **Responsief Design** - Werkt op desktop, tablet en mobiel
- ✅ **Contact Formulier** - Met validatie en feedback
- ✅ **Moderne UI** - Clean en professioneel design
- ✅ **Database Ready** - Voorbereid voor database integratie
- ✅ **SEO Geoptimaliseerd** - Meta tags en structured content
- ✅ **Toegankelijk** - ARIA labels en keyboard navigatie
- ✅ **Veilig** - Prepared statements en input sanitization

## Project Structuur

```
huisarts-project/
├── assets/
│   ├── css/
│   │   └── style.css          # Alle styling
│   ├── img/                   # Afbeeldingen (leeg)
│   └── js/
│       └── script.js          # JavaScript functionaliteit
├── config/
│   └── config.php             # Configuratie instellingen
├── database/
│   └── connection.php         # Database connectie
├── includes/
│   ├── header.php             # HTML head en navigatie
│   └── footer.php             # Footer en closing tags
├── index.php                  # Homepage
├── about.php                  # Over ons pagina
├── services.php               # Diensten pagina
├── contact.php                # Contact pagina met formulier
├── privacy.php                # Privacy verklaring
├── contact_handler.php        # Contact form handler
└── README.md                  # Dit bestand
```

## Installatie

### Vereisten
- PHP 7.4 of hoger
- MySQL/MariaDB database
- Webserver (Apache/Nginx) of lokale ontwikkelomgeving (XAMPP/Laragon)

### Setup Stappen

1. **Clone of download het project**
   ```bash
   git clone [repository-url]
   ```

2. **Configureer database instellingen**
   - Bewerk `config/config.php`
   - Pas database gegevens aan voor uw omgeving

3. **Maak database aan** (optioneel)
   ```sql
   CREATE DATABASE huisarts CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. **Upload naar webserver**
   - Plaats bestanden in webroot directory
   - Zorg dat PHP schrijfrechten heeft voor logs

5. **Test de website**
   - Open in browser
   - Test contact formulier
   - Controleer responsiviteit

## Verbeteringen Toegepast

### Technische Verbeteringen
- ✅ **CSS Fix**: `.body` → `body` selector gecorrigeerd
- ✅ **HTML Structuur**: Ontbrekende closing tags toegevoegd
- ✅ **Responsive Design**: Mobiele navigatie en grid layouts
- ✅ **JavaScript**: Form validatie en mobiele menu functionaliteit
- ✅ **Security**: Database credentials verplaatst naar config file
- ✅ **Error Handling**: Betere error handling en user feedback

### Design Verbeteringen
- ✅ **Moderne Styling**: Gradient header, card-based layout
- ✅ **Typography**: Betere lettertypen en readability
- ✅ **Color Scheme**: Consistent kleurenschema
- ✅ **Interactive Elements**: Hover effects en transitions
- ✅ **Mobile-First**: Responsive breakpoints

### Content Verbeteringen
- ✅ **Complete Navigation**: Alle menu items werken nu
- ✅ **Contact Form**: Volledig werkend contact formulier
- ✅ **Content Structure**: Logische pagina organisatie
- ✅ **SEO**: Proper meta tags en structured content

### Functionaliteit Verbeteringen
- ✅ **Form Handling**: Server-side validatie en feedback
- ✅ **Session Management**: Proper session handling
- ✅ **Database Ready**: Voorbereid voor toekomstige database features
- ✅ **Configuration**: Centralized config management

## Mogelijke Toekomstige Uitbreidingen

### Functionaliteit
- 📅 **Afspraak Systeem**: Online afspraken boeken
- 👥 **Patient Portal**: Inloggen voor patiënten
- 📝 **CMS**: Admin panel voor content management
- 📧 **Email Integration**: Automatische email notificaties
- 📊 **Analytics**: Google Analytics integratie

### Database Schema
```sql
-- Voorbeeld tabellen voor uitbreiding
CREATE TABLE appointments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    patient_name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    appointment_date DATETIME,
    service_type VARCHAR(50),
    status ENUM('pending', 'confirmed', 'cancelled'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    subject VARCHAR(100),
    message TEXT,
    status ENUM('unread', 'read', 'responded') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Security Checklist

- ✅ **Input Sanitization**: Filter_input gebruikt
- ✅ **Prepared Statements**: PDO prepared statements
- ✅ **Session Security**: HttpOnly cookies
- ✅ **Error Handling**: Geen database errors naar gebruiker
- ⚠️ **HTTPS**: Implementeer in productie
- ⚠️ **CSRF Protection**: Voeg CSRF tokens toe aan formulieren
- ⚠️ **Rate Limiting**: Implementeer voor contact formulier

## Browser Support

- ✅ Chrome (laatste 2 versies)
- ✅ Firefox (laatste 2 versies)
- ✅ Safari (laatste 2 versies)
- ✅ Edge (laatste 2 versies)
- ⚠️ IE11 (beperkte ondersteuning)

## Performance

- ✅ **CSS**: Geoptimaliseerd en gecomprimeerd
- ✅ **Images**: Placeholder voor optimalisatie
- ⚠️ **Caching**: Implementeer browser caching headers
- ⚠️ **Minification**: Minify CSS/JS voor productie

## Contact & Support

Voor vragen over deze website implementatie:
- Email: developer@huisartspraktijk.nl
- Documentatie updates welkom via pull requests

---
*Laatste update: November 2024*