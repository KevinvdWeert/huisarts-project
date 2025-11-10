<?php 
session_start();
include_once 'includes/header.php'; 
?>

<div class="container">
    <section class="hero-section">
        <h2>Contact</h2>
        <p>Neem contact met ons op voor afspraken, vragen of spoedgevallen.</p>
    </section>
    
    <?php if (isset($_SESSION['form_success'])): ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION['form_success']; 
            unset($_SESSION['form_success']);
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['form_errors'])): ?>
        <div class="alert alert-danger">
            <strong>Er zijn fouten opgetreden:</strong>
            <ul>
                <?php foreach ($_SESSION['form_errors'] as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['form_errors']); ?>
    <?php endif; ?>
    
    <section class="services-section">
        <div class="contact-grid">
            <div class="contact-info">
                <h3>Contactgegevens</h3>
                <ul class="contact-details">
                    <li><strong>Adres:</strong> Hoofdstraat 123, 1234 AB Amsterdam</li>
                    <li><strong>Telefoon:</strong> 010-123 4567</li>
                    <li><strong>Email:</strong> info@huisartspraktijk.nl</li>
                    <li><strong>Spoedlijn:</strong> 116 117 (buiten kantooruren)</li>
                </ul>
                
                <h3>Openingstijden</h3>
                <ul class="opening-hours">
                    <li><strong>Maandag:</strong> 08:00 - 17:00</li>
                    <li><strong>Dinsdag:</strong> 08:00 - 17:00</li>
                    <li><strong>Woensdag:</strong> 08:00 - 17:00</li>
                    <li><strong>Donderdag:</strong> 08:00 - 17:00</li>
                    <li><strong>Vrijdag:</strong> 08:00 - 17:00</li>
                    <li><strong>Zaterdag:</strong> 09:00 - 12:00</li>
                    <li><strong>Zondag:</strong> Gesloten</li>
                </ul>
            </div>
            
            <div class="contact-form">
                <h3>Stuur ons een bericht</h3>
                <form action="contact_handler.php" method="POST">
                    <div class="form-group">
                        <label for="name">Naam *</label>
                        <input type="text" id="name" name="name" value="<?php echo isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Telefoon</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo isset($_SESSION['form_data']['phone']) ? htmlspecialchars($_SESSION['form_data']['phone']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Onderwerp</label>
                        <select id="subject" name="subject">
                            <option value="afspraak" <?php echo (isset($_SESSION['form_data']['subject']) && $_SESSION['form_data']['subject'] === 'afspraak') ? 'selected' : ''; ?>>Afspraak maken</option>
                            <option value="vraag" <?php echo (isset($_SESSION['form_data']['subject']) && $_SESSION['form_data']['subject'] === 'vraag') ? 'selected' : ''; ?>>Algemene vraag</option>
                            <option value="klacht" <?php echo (isset($_SESSION['form_data']['subject']) && $_SESSION['form_data']['subject'] === 'klacht') ? 'selected' : ''; ?>>Klacht</option>
                            <option value="compliment" <?php echo (isset($_SESSION['form_data']['subject']) && $_SESSION['form_data']['subject'] === 'compliment') ? 'selected' : ''; ?>>Compliment</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Bericht *</label>
                        <textarea id="message" name="message" rows="5" required><?php echo isset($_SESSION['form_data']['message']) ? htmlspecialchars($_SESSION['form_data']['message']) : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">Verzenden</button>
                </form>
            </div>
        </div>
    </section>
</div>

<?php 
unset($_SESSION['form_data']); 
include_once 'includes/footer.php'; 
?>