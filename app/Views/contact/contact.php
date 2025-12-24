<link rel="stylesheet" href="/style/contact/contact.css">

<div class="contact-container">
    <div class="contact-header">
        <h1>Contactez-nous</h1>
        <p>Une question ? Une remarque ? N'hésitez pas à nous envoyer un message.</p>
    </div>

    <div class="contact-content">
        <!-- Formulaire de contact -->
        <section class="contact-form-section">
            <h2>Envoyer un message</h2>

            <?php if (!empty($success)): ?>
                <div class="success-message">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/contact" class="contact-form">
                <div class="form-group">
                    <label for="message">Votre message *</label>
                    <textarea 
                        id="message" 
                        name="message" 
                        rows="8" 
                        placeholder="Décrivez votre demande en détail..."
                        required
                    ><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                    <small class="char-count">Minimum 10 caractères, maximum 1000 caractères</small>
                </div>

                <button type="submit" class="btn-submit">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 2L11 13"/>
                        <path d="M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                    Envoyer le message
                </button>
            </form>
        </section>

        <!-- Informations de contact -->
        <section class="contact-info-section">
            <h2>Autres moyens de nous contacter</h2>
            
            <div class="contact-info-card">
                <div class="info-icon">📧</div>
                <h3>Email</h3>
                <p>contact@sparkleloop.fr</p>
                <small>Réponse sous 24h</small>
            </div>

            <div class="contact-info-card">
                <div class="info-icon">📞</div>
                <h3>Téléphone</h3>
                <p>+33 1 88 28 90 00</p>
                <small>Lun-Ven : 9h-18h</small>
            </div>

            <div class="contact-info-card">
                <div class="info-icon">📍</div>
                <h3>Adresse</h3>
                <p>30-32 Avenue de la République <br>94800 Villejuif, France</p>
                <small>Showroom sur rendez-vous</small>
            </div>

            <div class="contact-info-card">
                <div class="info-icon">⏰</div>
                <h3>Horaires</h3>
                <p>Service client 24/7</p>
                <small>Toujours à votre écoute</small>
            </div>
        </section>
    </div>

    <!-- Historique des messages -->
    <?php if (!empty($userMessages)): ?>
        <section class="message-history">
            <h2>Vos messages précédents</h2>
            <div class="messages-list">
                <?php foreach ($userMessages as $msg): ?>
                    <div class="message-card">
                        <div class="message-header">
                            <span class="message-date">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 6v6l4 2"/>
                                </svg>
                                <?= date('d/m/Y à H:i', strtotime($msg['date_envoi'])) ?>
                            </span>
                        </div>
                        <div class="message-body">
                            <?= nl2br(htmlspecialchars($msg['message'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</div>