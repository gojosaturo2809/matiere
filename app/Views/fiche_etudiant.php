<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<div class="topbar">
  <div class="topbar-title">Fiche étudiant</div>
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
      <h2>Fiche complète</h2>
      <div class="breadcrumb">
        <a href="<?= site_url('releve') ?>">Relevé</a> / 
        <span><?= esc((string) ($etudiant['ETU'] ?? '')) . ' - ' . esc((string) ($etudiant['nom'] ?? '')) . ' ' . esc((string) ($etudiant['prenom'] ?? '')) ?></span>
      </div>
    </div>
    <a class="btn btn-secondary btn-sm" href="<?= site_url('releve') ?>">Retour au relevé</a>
  </div>

  <!-- Info Étudiant -->
  <div class="table-card">
    <div class="card-header">
      <h3>Informations étudiant</h3>
    </div>
    <div class="student-info">
      <div class="info-row">
        <span class="info-label">Matricule:</span>
        <span class="info-value"><?= esc((string) ($etudiant['ETU'] ?? '')) ?></span>
      </div>
      <div class="info-row">
        <span class="info-label">Nom:</span>
        <span class="info-value"><?= esc((string) ($etudiant['nom'] ?? '')) ?></span>
      </div>
      <div class="info-row">
        <span class="info-label">Prénom:</span>
        <span class="info-value"><?= esc((string) ($etudiant['prenom'] ?? '')) ?></span>
      </div>
      <div class="info-row">
        <span class="info-label">Parcours:</span>
        <span class="info-value"><?= esc((string) ($parcoursLabel ?? 'Non défini')) ?></span>
      </div>
    </div>
  </div>

  <!-- Semestre 3 -->
  <div class="table-card">
    <div class="card-header">
      <h3>Semestre 3 (S3)</h3>
      <div class="score-badge">Moyenne: <strong><?= number_format((float) ($s3Avg ?? 0), 2, ',', ' ') ?></strong> / 20</div>
    </div>
    <table class="detail-table">
      <thead>
        <tr>
          <th>Code UE</th>
          <th>Libellé</th>
          <th>Note</th>
          <th>Commentaire</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($s3Ues)): ?>
          <tr>
            <td colspan="4" style="text-align: center; color: #999;">Aucune note en Semestre 3</td>
          </tr>
        <?php else: ?>
          <?php foreach ($s3Ues as $ue): ?>
            <tr>
              <td><?= esc((string) ($ue['code'] ?? '')) ?></td>
              <td><?= esc((string) ($ue['libelle'] ?? '')) ?></td>
              <td>
                <?php if ((float) $ue['note'] > 0): ?>
                  <span class="note-badge"><?= number_format((float) $ue['note'], 2, ',', ' ') ?></span>
                <?php else: ?>
                  <span class="note-badge empty">–</span>
                <?php endif; ?>
              </td>
              <td><?= esc((string) ($ue['commentaire'] ?? '')) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Semestre 4 - Cours obligatoires -->
  <div class="table-card">
    <div class="card-header">
      <h3>Semestre 4 (S4) — Cours obligatoires</h3>
      <div class="score-badge">Moyenne: <strong><?= number_format((float) ($s4Avg ?? 0), 2, ',', ' ') ?></strong> / 20</div>
    </div>
    <table class="detail-table">
      <thead>
        <tr>
          <th>Code UE</th>
          <th>Libellé</th>
          <th>Note</th>
          <th>Commentaire</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($s4RequiredUes)): ?>
          <tr>
            <td colspan="4" style="text-align: center; color: #999;">Aucune note en Semestre 4 obligatoire</td>
          </tr>
        <?php else: ?>
          <?php foreach ($s4RequiredUes as $ue): ?>
            <tr>
              <td><?= esc((string) ($ue['code'] ?? '')) ?></td>
              <td><?= esc((string) ($ue['libelle'] ?? '')) ?></td>
              <td>
                <?php if ((float) $ue['note'] > 0): ?>
                  <span class="note-badge"><?= number_format((float) $ue['note'], 2, ',', ' ') ?></span>
                <?php else: ?>
                  <span class="note-badge empty">–</span>
                <?php endif; ?>
              </td>
              <td><?= esc((string) ($ue['commentaire'] ?? '')) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Options Semestre 4 - Développement -->
  <div class="table-card">
    <div class="card-header">
      <h3>Semestre 4 (S4) — Options Développement</h3>
      <div class="score-badge">Moyenne: <strong><?= number_format((float) ($optionAvgDev ?? 0), 2, ',', ' ') ?></strong> / 20</div>
    </div>
    <table class="detail-table">
      <thead>
        <tr>
          <th>Code UE</th>
          <th>Libellé</th>
          <th>Note</th>
          <th>Commentaire</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($optionsDev)): ?>
          <tr>
            <td colspan="4" style="text-align: center; color: #999;">Aucune option Développement</td>
          </tr>
        <?php else: ?>
          <?php foreach ($optionsDev as $ue): ?>
            <tr>
              <td><?= esc((string) ($ue['code'] ?? '')) ?></td>
              <td><?= esc((string) ($ue['libelle'] ?? '')) ?></td>
              <td>
                <?php if ((float) $ue['note'] > 0): ?>
                  <span class="note-badge"><?= number_format((float) $ue['note'], 2, ',', ' ') ?></span>
                <?php else: ?>
                  <span class="note-badge empty">–</span>
                <?php endif; ?>
              </td>
              <td><?= esc((string) ($ue['commentaire'] ?? '')) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Options Semestre 4 - BDD / Réseaux -->
  <div class="table-card">
    <div class="card-header">
      <h3>Semestre 4 (S4) — Options BDD / Réseaux</h3>
      <div class="score-badge">Moyenne: <strong><?= number_format((float) ($optionAvgBddres ?? 0), 2, ',', ' ') ?></strong> / 20</div>
    </div>
    <table class="detail-table">
      <thead>
        <tr>
          <th>Code UE</th>
          <th>Libellé</th>
          <th>Note</th>
          <th>Commentaire</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($optionsBddres)): ?>
          <tr>
            <td colspan="4" style="text-align: center; color: #999;">Aucune option BDD / Réseaux</td>
          </tr>
        <?php else: ?>
          <?php foreach ($optionsBddres as $ue): ?>
            <tr>
              <td><?= esc((string) ($ue['code'] ?? '')) ?></td>
              <td><?= esc((string) ($ue['libelle'] ?? '')) ?></td>
              <td>
                <?php if ((float) $ue['note'] > 0): ?>
                  <span class="note-badge"><?= number_format((float) $ue['note'], 2, ',', ' ') ?></span>
                <?php else: ?>
                  <span class="note-badge empty">–</span>
                <?php endif; ?>
              </td>
              <td><?= esc((string) ($ue['commentaire'] ?? '')) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Options Semestre 4 - Web -->
  <div class="table-card">
    <div class="card-header">
      <h3>Semestre 4 (S4) — Options Web</h3>
      <div class="score-badge">Moyenne: <strong><?= number_format((float) ($optionAvgWeb ?? 0), 2, ',', ' ') ?></strong> / 20</div>
    </div>
    <table class="detail-table">
      <thead>
        <tr>
          <th>Code UE</th>
          <th>Libellé</th>
          <th>Note</th>
          <th>Commentaire</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($optionsWeb)): ?>
          <tr>
            <td colspan="4" style="text-align: center; color: #999;">Aucune option Web</td>
          </tr>
        <?php else: ?>
          <?php foreach ($optionsWeb as $ue): ?>
            <tr>
              <td><?= esc((string) ($ue['code'] ?? '')) ?></td>
              <td><?= esc((string) ($ue['libelle'] ?? '')) ?></td>
              <td>
                <?php if ((float) $ue['note'] > 0): ?>
                  <span class="note-badge"><?= number_format((float) $ue['note'], 2, ',', ' ') ?></span>
                <?php else: ?>
                  <span class="note-badge empty">–</span>
                <?php endif; ?>
              </td>
              <td><?= esc((string) ($ue['commentaire'] ?? '')) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Résumé L2 -->
  <div class="table-card">
    <div class="card-header">
      <h3>Calcul L2</h3>
    </div>
    <div class="l2-summary">
      <div class="l2-row">
        <span class="l2-label">S3 (Semestre 3):</span>
        <span class="l2-value"><?= number_format((float) ($s3Avg ?? 0), 2, ',', ' ') ?></span>
      </div>
      <div class="l2-row">
        <span class="l2-label">S4 (Semestre 4):</span>
        <span class="l2-value"><?= number_format((float) ($s4Avg ?? 0), 2, ',', ' ') ?></span>
      </div>
      <div class="l2-row l2-total">
        <span class="l2-label">L2 = S3 + S4:</span>
        <span class="l2-value"><?= number_format((float) ($l2 ?? 0), 2, ',', ' ') ?></span>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>
