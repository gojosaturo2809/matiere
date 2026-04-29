<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<div class="topbar">
  <div class="topbar-title">Gestion des etudiants</div>
  <div class="topbar-search">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" placeholder="Rechercher..." />
  </div>
  <div class="topbar-actions">
    <button class="icon-btn">
      <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      <span class="notif-dot"></span>
    </button>
    <button class="icon-btn">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
    </button>
  </div>
</div>

<div class="content">
  <div class="page-header">
    <div>
      <h2>Liste des etudiants</h2>
      <div class="breadcrumb">Accueil / <span>Etudiants</span></div>
    </div>
    <a href="<?= site_url('notes/create') ?>" class="btn btn-primary btn-sm">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Saisir une note
    </a>
  </div>

  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>Etudiant</th>
          <th>Matricule</th>
          <th>Email</th>
          <th>Parcours</th>
          <th>Date d'inscription</th>
        </tr>
      </thead>
      <tbody>
      <?php if (! empty($etudiants ?? [])): ?>
        <?php foreach ($etudiants as $etudiant): ?>
          <?php
            $nomComplet = trim((string) (($etudiant['prenom'] ?? '') . ' ' . ($etudiant['nom'] ?? '')));
            $email = (string) ($etudiant['email'] ?? 'Non renseigne');
            $parcours = ! empty($etudiant['id_parcours']) ? (string) $etudiant['id_parcours'] : '-';
            $dateInscription = ! empty($etudiant['date_inscription'])
              ? date('d/m/Y', strtotime((string) $etudiant['date_inscription']))
              : '-';
          ?>
          <tr>
            <td><?= esc($nomComplet !== '' ? $nomComplet : 'Etudiant sans nom') ?></td>
            <td style="font-family:monospace;color:var(--c-muted)"><?= esc((string) ($etudiant['ETU'] ?? '-')) ?></td>
            <td><?= esc($email) ?></td>
            <td><?= esc($parcours) ?></td>
            <td><?= esc($dateInscription) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" style="text-align:center;padding:40px;color:var(--c-muted)">Aucun etudiant enregistre</td>
        </tr>
      <?php endif; ?>
      </tbody>
    </table>

    <div class="pagination">
      <span>Nombre d'etudiants: <strong><?= count($etudiants ?? []) ?></strong></span>
      <div class="page-btns">
        <button class="page-btn active">1</button>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>
