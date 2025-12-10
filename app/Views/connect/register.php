<link rel="stylesheet" href="/style/connect/auth.css">

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Inscription</h1>
            <p>Créez votre compte SparkleLoop</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/register" class="auth-form">
            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input 
                    type="text" 
                    id="prenom" 
                    name="prenom" 
                    value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="nom">Nom *</label>
                <input 
                    type="text" 
                    id="nom" 
                    name="nom" 
                    value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Mot de passe *</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                >
                <small>Au moins 6 caractères</small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe *</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    required
                >
            </div>

            <button type="submit" class="btn-submit">S'inscrire</button>
        </form>

        <div class="auth-footer">
            <p>Vous avez déjà un compte ? <a href="/login">Se connecter</a></p>
        </div>
    </div>
</div>