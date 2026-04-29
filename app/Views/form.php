<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<div class="topbar">
  <div class="topbar-title">Saisie des notes</div>
  <div class="topbar-search">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" placeholder="Rechercher…" />
  </div>
  <div class="topbar-actions">
    <button class="icon-btn"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></button>
    <button class="icon-btn"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg></button>
  </div>
</div>

<div class="content">
  <div class="page-header">
    <div>
      <h2>Nouvelle note</h2>
      <div class="breadcrumb">Accueil / Notes / <span>Nouvelle saisie</span></div>
    </div>
    <a href="<?= site_url('notes') ?>" class="btn btn-secondary btn-sm">
      <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
      Voir la liste
    </a>
  </div>

  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-info">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <span><?= esc(implode(' ', session()->getFlashdata('errors'))) ?></span>
    </div>
  <?php endif; ?>

  <form action="<?= site_url('notes') ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-card section-gap">
      <div class="form-section-title">Saisie de la note</div>
      <div class="form-grid">
        <div>
          <label class="field-label">Étudiant <span class="required">*</span></label>
          <select name="id_etudiant" required>
            <option value="">— Sélectionner un étudiant —</option>
            <?php foreach (($etudiants ?? []) as $etudiant): ?>
              <?php
                $etudiantId = (string) ($etudiant['id_etudiant'] ?? '');
                $etudiantCode = (string) ($etudiant['ETU'] ?? '');
                $etudiantNom = (string) ($etudiant['nom'] ?? '');
                $etudiantPrenom = (string) ($etudiant['prenom'] ?? '');
              ?>
              <option value="<?= $etudiantId ?>" <?= old('id_etudiant') == $etudiantId ? 'selected' : '' ?>>
                <?= esc($etudiantCode) ?> - <?= esc($etudiantNom) ?> <?= esc($etudiantPrenom) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="field-label">Unité d’enseignement <span class="required">*</span></label>
          <select name="code_ue" required>
            <option value="">— Sélectionner une UE —</option>
            <?php foreach (($ues ?? []) as $ue): ?>
              <?php
                $codeUe = (string) ($ue['code_ue'] ?? '');
                $intituleUe = (string) ($ue['intitule'] ?? '');
              ?>
              <option value="<?= $codeUe ?>" <?= old('code_ue') === $codeUe ? 'selected' : '' ?>>
                <?= esc($codeUe) ?> - <?= esc($intituleUe) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="field-label">Note /20 <span class="required">*</span></label>
          <input type="number" name="note" value="<?= esc(old('note', '0')) ?>" min="0" max="20" step="0.01" required />
        </div>
        <div>
          <label class="field-label">Coefficient</label>
          <input type="number" name="coefficient" value="<?= esc(old('coefficient', '1')) ?>" min="0.1" step="0.1" />
        </div>
        <div>
          <label class="field-label">Session</label>
          <select name="session_note">
            <option value="Normale" <?= old('session_note', 'Normale') === 'Normale' ? 'selected' : '' ?>>Normale</option>
            <option value="Rattrapage" <?= old('session_note') === 'Rattrapage' ? 'selected' : '' ?>>Rattrapage</option>
          </select>
        </div>
      </div>

      <div class="form-grid cols-1">
        <div>
          <label class="field-label">Commentaire</label>
          <textarea name="commentaire" placeholder="Appréciation, remarques, ou contexte de la note…"><?= esc(old('commentaire')) ?></textarea>
        </div>
      </div>
    </div>

    <div class="form-footer">
      <a href="<?= site_url('notes') ?>" class="btn btn-secondary">Annuler</a>
      <button type="submit" class="btn btn-primary">
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        Enregistrer la note
      </button>
    </div>
  </form>
</div>

<?php $this->endSection(); ?>
