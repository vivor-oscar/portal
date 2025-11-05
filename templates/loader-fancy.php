<?php
// Fancy neon loader overlay (partial). Include as a partial (no <html> wrapper).
?>
<style>
  #page-loader { position: fixed; inset:0; display:flex;align-items:center;justify-content:center;z-index:9999;background:linear-gradient(180deg, rgba(12,12,25,0.88), rgba(6,9,23,0.9)); visibility:hidden; opacity:0; transition:opacity .3s ease; }
  #page-loader.visible { visibility:visible; opacity:1; }
  .neon-loader { width:140px; height:140px; position:relative; }
  .neon-loader .ring{ position:absolute;border-radius:50%; border:4px solid transparent; animation:neon 1.8s linear infinite; }
  .neon-loader .ring.r1{ width:100%; height:100%; border-top-color:#00dbde; box-shadow:0 0 20px rgba(0,219,222,0.6);} 
  .neon-loader .ring.r2{ width:78%; height:78%; top:11%; left:11%; border-left-color:#fc00ff; box-shadow:0 0 20px rgba(252,0,255,0.55); animation-delay:.15s}
  .neon-loader .ring.r3{ width:56%; height:56%; top:22%; left:22%; border-bottom-color:#4776e6; box-shadow:0 0 18px rgba(71,118,230,0.45); animation-delay:.3s}
  .neon-loader .center{ width:20px; height:20px; background:#fff;border-radius:50%; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); box-shadow:0 0 18px #fff; }
  @keyframes neon{ 0%{ transform:rotate(0deg) scale(1)}50%{ transform:rotate(180deg) scale(1.05)}100%{ transform:rotate(360deg) scale(1)} }
</style>

<div id="page-loader" aria-hidden="true">
  <div class="neon-loader" role="status" aria-label="Loading">
    <div class="ring r1"></div>
    <div class="ring r2"></div>
    <div class="ring r3"></div>
    <div class="center"></div>
  </div>
</div>

<script>
  const Loader = window.Loader || {};
  Loader.show = () => { const el = document.getElementById('page-loader'); if(el){ el.classList.add('visible'); el.setAttribute('aria-hidden','false'); }};
  Loader.hide = () => { const el = document.getElementById('page-loader'); if(el){ el.classList.remove('visible'); el.setAttribute('aria-hidden','true'); }};
  window.Loader = Loader;
  document.addEventListener('DOMContentLoaded', ()=> setTimeout(()=> Loader.hide(), 2000));
</script>
