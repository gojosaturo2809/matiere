<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<div class="topbar">
  <div class="topbar-title">Relevé de notes</div>
  <div class="topbar-search">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" placeholder="Rechercher un étudiant…" />
  </div>
  <div class="topbar-actions">
    <button class="icon-btn"><svg viewBox="0 0 24 24"><path d="M4 4h16v16H4z"/><path d="M8 4v16"/><path d="M4 8h16"/></svg></button>
  </div>
</div>

<div class="content">
  <div class="page-header">
    <div>
      <h2>Relevé global</h2>
      <div class="breadcrumb">Accueil / <span>Relevé de notes</span></div>
    </div>
    <a class="btn btn-primary btn-sm" href="<?= site_url('notes/create') ?>">Saisir une note</a>
  </div>

  <div class="table-card">
    <table class="releve-table">
      <thead>
        <tr>
          <th>Matricule</th>
          <th>Étudiant</th>
          <th>S3</th>
          <th>S4</th>
          <th>Option Dev</th>
          <th>Option BDD/Réseaux</th>
          <th>Option Web</th>
          <th>L2 = S3 + S4</th>
        </tr>
      </thead>
      <tbody>
        <?php $rows = $releves ?? []; ?>
        <?php foreach ($rows as $row): ?>
          <?php
            $etu = $row['etudiant'] ?? [];
            $etuId = (int) ($etu['id_etudiant'] ?? 0);
            $matricule = (string) ($etu['ETU'] ?? '');
            $fullName = trim((string) ($etu['nom'] ?? '') . ' ' . (string) ($etu['prenom'] ?? ''));
            $ficheUrl = site_url('releve/fiche/' . $etuId);
          ?>
          <tr class="clickable-row" onclick="window.location.href='<?= esc($ficheUrl) ?>';" style="cursor: pointer;">
            <td><?= esc($matricule) ?></td>
            <td><?= esc($fullName) ?></td>
            <td><?= number_format((float) $row['s3'], 2, ',', ' ') ?></td>
            <td><?= number_format((float) $row['s4'], 2, ',', ' ') ?></td>
            <td><?= number_format((float) ($row['option_dev'] ?? 0), 2, ',', ' ') ?></td>
            <td><?= number_format((float) ($row['option_bddres'] ?? 0), 2, ',', ' ') ?></td>
            <td><?= number_format((float) ($row['option_web'] ?? 0), 2, ',', ' ') ?></td>
            <td><strong><?= number_format((float) $row['l2'], 2, ',', ' ') ?></strong></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php $this->endSection(); ?>