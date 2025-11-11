# Huisarts Patient Management System

## Overzicht
Een complete patiënten management systeem voor huisartspraktijken met de volgende functionaliteiten:

## 🎯 Belangrijkste Functionaliteiten

### 🔐 Authenticatie
- **Login systeem** met gebruikersrollen (admin/dokter)
- **Sessie management** met timeout
- **Beveiligde pagina's** met access controle

### 👥 Patiënten Beheer
- **Overzichtspagina** met alle patiënten
- **Zoekfunctie** op naam, email, telefoon en plaats
- **Sorteerbare kolommen** (naam, geboortedatum, plaats, etc.)
- **Paginering** (25 patiënten per pagina)
- **CRUD operaties**: Toevoegen, Bewerken, Verwijderen

### 📝 Notities Systeem
- **Patiënt-specifieke notities** met datum
- **Sorteerbare notities** op datum (nieuwste eerst)
- **Rich text ondersteuning** met HTML formatting
- **Gebruiker tracking** (wie heeft notitie aangemaakt)
- **Tijdstempel** van aanmaak en laatste wijziging

### 🎨 User Experience
- **Responsive design** voor desktop en mobiel
- **Professional styling** met gradients en animaties
- **Form validatie** met real-time feedback
- **Auto-save functionaliteit** voor formulieren
- **Keyboard shortcuts** (Ctrl+S om op te slaan, Ctrl+F voor zoeken)
- **Print functionaliteit** voor overzichten
- **Loading states** en progress indicators

## 📱 Toegankelijkheid & UX Features

### Interactive Elements
- **Hover effects** op tabellen en knoppen
- **Smooth transitions** en animaties
- **Auto-resize textareas** voor notities
- **Character counters** voor lange tekstvelden
- **Search highlighting** en live search
- **Confirmation dialogs** voor delete acties

### Validation & Error Handling
- **Real-time form validation**
- **Dutch postal code validation** (1234AB format)
- **Email format validation**
- **Phone number validation** (Nederlandse formaten)
- **Date validation** (geen toekomstige datums voor geboortedatum)

### Auto-Save & Data Persistence
- **Auto-save draft functionality** voor formulieren
- **LocalStorage backup** van niet-opgeslagen wijzigingen
- **Session timeout warnings**
- **Data recovery** bij browser crash

## 🗄️ Database Structuur

### Tabellen
1. **patients** - Patiënt basisgegevens
   - Persoonlijke informatie (naam, geboortedatum)
   - Adresgegevens (adres, postcode, plaats)
   - Contactgegevens (telefoon, email)

2. **users** - Systeem gebruikers
   - Gebruikersnaam en wachtwoord hash
   - Rol (admin/doctor)
   - Timestamps

3. **notes** - Patiënt notities
   - Gekoppeld aan patiënt en gebruiker
   - Onderwerp en tekst
   - Notitiedatum en timestamps

## 🚀 Demo Accounts

Voor demonstratie zijn er twee accounts beschikbaar:

### Admin Account
- **Gebruikersnaam:** `admin`
- **Wachtwoord:** `password`
- **Rechten:** Volledige toegang

### Dokter Account
- **Gebruikersnaam:** `doctor`
- **Wachtwoord:** `password`
- **Rechten:** Patiënt beheer en notities

## 📋 Navigatie

### Hoofdpagina's
1. **`login.php`** - Inloggen
2. **`dashboard.php`** - Patiënten overzicht
3. **`add_patient.php`** - Nieuwe patiënt toevoegen
4. **`edit_patient.php`** - Patiënt bewerken
5. **`patient_notes.php`** - Patiënt notities beheren
6. **`delete_patient.php`** - Patiënt verwijderen (met confirmatie)

### Workflow
1. **Inloggen** via login.php
2. **Dashboard bekijken** - alle patiënten in overzicht
3. **Zoeken/Sorteren** - specifieke patiënten vinden
4. **Patiënt selecteren** - via edit of notes knop
5. **Notities beheren** - toevoegen, bekijken, verwijderen
6. **Gegevens bijwerken** - patiënt informatie aanpassen

## 💡 Technische Features

### Beveiliging
- **Password hashing** met PHP password_hash()
- **SQL injection preventie** via prepared statements
- **Session hijacking bescherming**
- **CSRF protection** ready (kan worden uitgebreid)

### Performance
- **Database indexing** op vaak gebruikte kolommen
- **Efficient queries** met LIMIT en OFFSET voor paginering
- **Image optimization** en lazy loading
- **Minified CSS/JS** voor productie

### Code Kwaliteit
- **Clean PHP code** met error handling
- **Modular structure** met herbruikbare componenten
- **Consistent naming conventions**
- **Comprehensive commenting**

## 🎯 Gebruiksinstructies

### Voor Eindgebruikers
1. **Ga naar de website** en klik op "Medewerker Inloggen"
2. **Log in** met een van de demo accounts
3. **Bekijk het dashboard** met alle patiënten
4. **Gebruik de zoekfunctie** om specifieke patiënten te vinden
5. **Klik op een patiënt** om details te bewerken of notities toe te voegen
6. **Voeg nieuwe patiënten toe** via de groene knop
7. **Beheer notities** via de notities knop (📝)

### Voor Ontwikkelaars
1. **Database importeren** via huisarts.sql
2. **Config aanpassen** in config/config.php voor database connectie
3. **Webserver starten** (Apache/Nginx met PHP support)
4. **Testen** met de demo accounts

## 🔧 Installatie Vereisten

- **PHP 7.4+** met PDO MySQL extensie
- **MySQL 5.7+** of MariaDB 10.2+
- **Webserver** (Apache/Nginx)
- **Modern browser** voor optimale UX

## 📈 Toekomstige Uitbreidingen

### Mogelijk te implementeren:
- **Afspraken systeem** met kalender integratie
- **Document upload** voor patiënt bestanden
- **Email notificaties** voor vervolgafspraken
- **Reporting dashboard** met statistieken
- **API endpoints** voor mobile app
- **Two-factor authentication** voor extra beveiliging
- **Audit logging** voor compliance
- **Backup/restore functionaliteit**

Dit systeem biedt een solide basis voor een professioneel patiënten management systeem met moderne UX en security best practices.