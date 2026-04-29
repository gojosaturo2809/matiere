<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Connexion</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="login-page">
  <div class="login-card">

    <div class="login-logo">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="22" height="22"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <h1>SysInfo</h1>
        <span>Système d'Information</span>
      </div>
    </div>

    <h2>Connexion</h2>
    <p class="subtitle">Connectez-vous à votre espace de travail</p>

    <!-- Affichage des erreurs de session si elles existent -->
    <?php if (session()->getFlashdata('error')): ?>
        <div style="color: red; margin-bottom: 15px; text-align: center;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Le formulaire pointe vers la route 'admin/authenticate' -->
    <form action="<?= base_url('admin/authenticate') ?>" method="POST">
      <div class="field-group">
        <label>Adresse e-mail</label>
        <div class="input-wrap">
          <div class="icon">
            <svg viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          </div>
          <!-- Ajout de l'attribut name="email" -->
          <input type="email" name="email" placeholder="admin@matiere.com" value="admin@matiere.com" required />
        </div>
      </div>

      <div class="field-group">
        <label>Mot de passe</label>
        <div class="input-wrap">
          <div class="icon">
            <svg viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </div>
          <!-- Ajout de l'attribut name="mot_de_passe" -->
          <input type="password" name="mot_de_passe" placeholder="admin123" value="admin123" required />
        </div>
      </div>

      <div class="remember-row">
        <label>
          <input type="checkbox" checked />
          Se souvenir de moi
        </label>
        <a href="#">Mot de passe oublié ?</a>
      </div>

      <!-- Changement du lien <a> en bouton <button type="submit"> -->
      <button type="submit" class="btn btn-primary btn-full" style="width: 100%; border: none; cursor: pointer;">
        <svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Se connecter
      </button>
    </form>

    <div class="login-footer">
      Pas encore de compte ? <a href="#">Contactez votre administrateur</a>
    </div>

  </div>
</div>

</body>
</html>
