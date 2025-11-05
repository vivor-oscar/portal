<?php
// Minimal loader overlay (partial) — include inside pages (no <html>/<body> wrappers)
?>
<style>
  /* simple centered spinner */
  #page-loader { position: fixed; inset: 0; display:flex;align-items:center;justify-content:center;z-index:9999;background:rgba(0,0,0,0.45);visibility:hidden;opacity:0;transition:opacity .25s ease; }
  #page-loader.visible { visibility:visible; opacity:1; }
  .simple-spinner { width:48px;height:48px;border-radius:50%;border:4px solid rgba(255,255,255,0.12);border-top-color:#fff;animation:spin .8s linear infinite; }
  @keyframes spin { to { transform: rotate(360deg); } }
  /* small accessibility helpers */
  #page-loader[aria-hidden="true"] { pointer-events:none; }
</style>

<div id="page-loader" aria-hidden="true">
  <div class="simple-spinner" role="status" aria-label="Loading"></div>
</div>

<script>
  const Loader = window.Loader || {};
  Loader.show = () => { const el = document.getElementById('page-loader'); if(el){ el.classList.add('visible'); el.setAttribute('aria-hidden','false'); }};
  Loader.hide = () => { const el = document.getElementById('page-loader'); if(el){ el.classList.remove('visible'); el.setAttribute('aria-hidden','true'); }};
  window.Loader = Loader;
  // auto-hide after DOM ready if left visible by server
  document.addEventListener('DOMContentLoaded', ()=> setTimeout(()=> Loader.hide(), 1500));
</script>
