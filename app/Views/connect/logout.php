<link rel="stylesheet" href="/style/connect/profile.css">

<div class="profile-container">
    <div class="profile-header">
        <h1>Mon Profil</h1>
        <p>Gérez vos informations personnelles</p>
    </div>

    <div class="profile-content">
        <!-- Section informations personnelles -->
        <div class="profile-section">
            <h2>Informations personnelles</h2>

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

            <form method="POST" action="/logout" class="profile-form">
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input 
                        type="text" 
                        id="prenom" 
                        name="prenom" 
                        value="<?= htmlspecialchars($user['prenom']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input 
                        type="text" 
                        id="nom" 
                        name="nom" 
                        value="<?= htmlspecialchars($user['nom']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="<?= htmlspecialchars($user['email']) ?>"
                        required
                    >
                </div>

                <button type="submit" name="update_profile" class="btn-confirm">
                    Confirmer les modifications
                </button>
            </form>
        </div>

        <!-- Section changement de mot de passe -->
        <div class="profile-section">
            <h2>Modifier le mot de passe</h2>

            <form method="POST" action="/logout" class="profile-form">
                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input 
                        type="password" 
                        id="new_password" 
                        name="new_password" 
                        required
                    >
                    <small>Au moins 6 caractères</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        required
                    >
                </div>

                <button type="submit" name="update_password" class="btn-confirm">
                    Modifier le mot de passe
                </button>
            </form>
        </div>

        <!-- Bouton de déconnexion -->
        <div class="profile-section logout-section">
            <h2>Déconnexion</h2>
            <p>Vous souhaitez vous déconnecter de votre compte ?</p>
            <a href="/disconnect" class="btn-logout">Se déconnecter</a>
        </div>
    </div>
</div>