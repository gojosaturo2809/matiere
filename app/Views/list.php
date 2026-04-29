<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<div class="topbar">
  <div class="topbar-title">Gestion des notes</div>
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
      <h2>Liste des notes</h2>
      <div class="breadcrumb">Accueil / <span>Notes</span></div>
    </div>
    <a href="<?= site_url('notes/create') ?>" class="btn btn-primary btn-sm">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Saisir une note
    </a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-info">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <span><?= esc(session()->getFlashdata('success')) ?></span>
    </div>
  <?php endif; ?>

  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>Etudiant</th>
          <th>Matricule</th>
          <th>UE</th>
          <th>Note /20</th>
          <th>Coefficient</th>
          <th>Session</th>
          <th>Date de saisie</th>
        </tr>
      </thead>
      <tbody>
      <?php if (! empty($notes ?? [])): ?>
        <?php foreach ($notes as $note): ?>
          <?php
            $etudiant = $etudiantIndex[$note['id_etudiant']] ?? null;
            $nomComplet = trim((string) (($etudiant['prenom'] ?? '') . ' ' . ($etudiant['nom'] ?? '')));
            $matricule = (string) ($etudiant['ETU'] ?? '-');
            $dateSaisie = ! empty($note['date_saisie']) ? date('d/m/Y H:i', strtotime($note['date_saisie'])) : '-';
          ?>
          <tr>
            <td><?= esc($nomComplet !== '' ? $nomComplet : 'Etudiant inconnu') ?></td>
            <td style="font-family:monospace;color:var(--c-muted)"><?= esc($matricule) ?></td>
            <td><?= esc((string) ($note['code_ue'] ?? '-')) ?></td>
            <td><strong><?= esc(number_format((float) ($note['note'] ?? 0), 2, ',', ' ')) ?></strong></td>
            <td><?= esc(number_format((float) ($note['coefficient'] ?? 1), 1, ',', ' ')) ?></td>
            <td><?= esc((string) ($note['session_note'] ?? 'Normale')) ?></td>
            <td><?= esc($dateSaisie) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" style="text-align:center;padding:40px;color:var(--c-muted)">Aucune note enregistree</td>
        </tr>
      <?php endif; ?>
      </tbody>
    </table>

    <div class="pagination">
      <span>Nombre de notes: <strong><?= count($notes ?? []) ?></strong></span>
      <div class="page-btns">
        <button class="page-btn active">1</button>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>
