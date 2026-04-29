<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<div class="topbar">
  <div class="topbar-title">Notes par étudiant</div>
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
      <h2>Liste des notes</h2>
      <div class="breadcrumb">Accueil / <span>Notes</span></div>
    </div>
    <a class="btn btn-primary btn-sm" href="<?= site_url('notes/create') ?>">Saisir une note</a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
      <span><?= esc((string) session()->getFlashdata('success')) ?></span>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
      <span><?= esc((string) session()->getFlashdata('error')) ?></span>
    </div>
  <?php endif; ?>

  <?php $sections = $studentSections ?? []; ?>

  <?php if (empty($sections)): ?>
    <div class="table-card">
      <div style="padding:24px;text-align:center;color:var(--c-muted)">Aucun étudiant trouvé.</div>
    </div>
  <?php else: ?>
    <?php foreach ($sections as $section): ?>
      <?php
        $etudiant = $section['etudiant'] ?? [];
        $notes = $section['notes'] ?? [];
        $studentId = (int) ($etudiant['id_etudiant'] ?? 0);
        $studentName = trim((string) ($etudiant['prenom'] ?? '') . ' ' . (string) ($etudiant['nom'] ?? ''));
        $studentCode = (string) ($etudiant['ETU'] ?? '');
      ?>
      <div class="table-card" style="margin-bottom:18px;">
        <div class="card-header">
          <h3><?= esc($studentName !== '' ? $studentName : 'Étudiant #' . $studentId) ?></h3>
          <div class="score-badge">
            <?= esc($studentCode !== '' ? $studentCode : 'Sans matricule') ?>
            — <strong><?= count($notes) ?></strong> note<?= count($notes) > 1 ? 's' : '' ?>
          </div>
        </div>

        <?php if (empty($notes)): ?>
          <div style="padding:24px;text-align:center;color:var(--c-muted)">
            Aucune note pour cet étudiant.
          </div>
        <?php else: ?>
          <table class="detail-table">
            <thead>
              <tr>
                <th>Code UE</th>
                <th>Note</th>
                <th>Commentaire</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($notes as $note): ?>
                <?php
                  $noteId = (int) ($note['id_note'] ?? 0);
                  $noteValue = (float) ($note['note'] ?? 0);
                  $dateSaisie = (string) ($note['date_saisie'] ?? '');
                ?>
                <tr>
                  <td><?= esc((string) ($note['code_ue'] ?? '')) ?></td>
                  <td><span class="note-badge"><?= number_format($noteValue, 2, ',', ' ') ?></span></td>
                  <td><?= esc((string) ($note['commentaire'] ?? '')) ?></td>
                  <td><?= $dateSaisie !== '' ? esc(date('d/m/Y H:i', strtotime($dateSaisie))) : '—' ?></td>
                  <td>
                    <form action="<?= site_url('notes/' . $noteId) ?>" method="post" onsubmit="return confirm('Supprimer cette note ?');" style="display:inline;">
                      <?= csrf_field() ?>
                      <input type="hidden" name="_method" value="DELETE" />
                      <button type="submit" class="action-btn del" title="Supprimer">
                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php $this->endSection(); ?>