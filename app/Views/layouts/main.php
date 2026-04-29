<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'SysInfo') ?></title>
  <link rel="stylesheet" href="<?= base_url('style.css') ?>" />
</head>
<body>

<div class="app">
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <div class="brand-name">SysInfo</div>
        <div class="brand-sub">v2.4.0</div>
      </div>
    </div>

    <div class="sidebar-section">Navigation</div>

    <a href="<?= site_url('dashboard') ?>" class="nav-item <?= (($activePage ?? '') === 'dashboard') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      Tableau de bord
    </a>
    <a href="<?= site_url('notes') ?>" class="nav-item <?= (($activePage ?? '') === 'notes') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Notes / Étudiants
    </a>
    <a href="<?= site_url('notes/create') ?>" class="nav-item <?= (($activePage ?? '') === 'note-form') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Saisie note
    </a>

    <div class="sidebar-bottom">
      <a href="<?= site_url('login') ?>" class="user-row">
        <div class="avatar">AD</div>
        <div class="user-info">
          <div class="name">Admin Sys</div>
          <div class="role">Super administrateur</div>
        </div>
      </a>
    </div>
  </aside>

  <div class="main">
    <?= $this->renderSection('content') ?>

    <footer class="form-footer" style="margin-top:24px;justify-content:center;opacity:.85">
      <span>SysInfo © <?= date('Y') ?> — Gestion des étudiants et des notes</span>
    </footer>
  </div>
</div>

<script src="<?= base_url('script.js') ?>"></script>
</body>
</html>
