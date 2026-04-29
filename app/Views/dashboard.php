<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<div class="topbar">
  <div class="topbar-title">Tableau de bord</div>
  <div class="topbar-search">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" placeholder="Rechercher…" />
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
      <h2>Tableau de bord</h2>
      <div class="breadcrumb">Accueil / <span>Tableau de bord</span></div>
    </div>
    <button class="btn btn-primary btn-sm">
      <svg viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
      Exporter
    </button>
  </div>

  <div class="kpi-grid">
    <div class="kpi-card">
      <div class="kpi-header">
        <div class="kpi-label">Utilisateurs actifs</div>
        <div class="kpi-icon bg-blue">
          <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
      </div>
      <div class="kpi-value">1 284</div>
      <div class="kpi-delta up">+12.5% ce mois</div>
    </div>

    <div class="kpi-card">
      <div class="kpi-header">
        <div class="kpi-label">Transactions</div>
        <div class="kpi-icon bg-green">
          <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
      </div>
      <div class="kpi-value">8 430</div>
      <div class="kpi-delta up">+7.3% ce mois</div>
    </div>

    <div class="kpi-card">
      <div class="kpi-header">
        <div class="kpi-label">Incidents ouverts</div>
        <div class="kpi-icon bg-amber">
          <svg viewBox="0 0 24 24"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
      </div>
      <div class="kpi-value">37</div>
      <div class="kpi-delta down">-3 depuis hier</div>
    </div>

    <div class="kpi-card">
      <div class="kpi-header">
        <div class="kpi-label">Disponibilité</div>
        <div class="kpi-icon bg-green">
          <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
      </div>
      <div class="kpi-value">99.8%</div>
      <div class="kpi-delta up">SLA respecté</div>
    </div>
  </div>
</div>

<?php $this->endSection(); ?>
