<?php
// Small site-wide watermark (bottom-right) and fixed footer (bottom)
// This file is intended to be included from page header includes so it appears on every page.
?>
<!-- Watermark & Footer include -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
  .vo-watermark {
    position: fixed;
    right: 12px;
    bottom: 44px; /* leave room for footer */
    z-index: 9999;
    font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
    font-size: 12px;
    color: rgba(0,0,0,0.35);
    -webkit-text-stroke: 0.2px rgba(255,255,255,0.1);
    pointer-events: none;
    backdrop-filter: none;
    user-select: none;
  }

  .vo-watermark .vo-badge {
    display: inline-block;
    padding: 6px 10px;
    background: rgba(255,255,255,0.85);
    border-radius: 6px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    color: rgba(0,0,0,0.6);
    font-weight: 500;
  }

  /* Footer fixed at bottom across pages */
  .vo-footer {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9989;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
    font-size: 13px;
    color: rgba(55,65,81,0.8);
    background: rgba(255,255,255,0.9);
    border-top: 1px solid rgba(0,0,0,0.04);
    pointer-events: none;
  }

  @media (prefers-color-scheme: dark) {
    .vo-watermark { color: rgba(255,255,255,0.22); }
    .vo-watermark .vo-badge { background: rgba(0,0,0,0.45); color: rgba(255,255,255,0.9); }
    .vo-footer { background: rgba(20,20,20,0.7); color: rgba(255,255,255,0.75); border-top-color: rgba(255,255,255,0.03); }
  }
</style>

<div class="vo-watermark" aria-hidden="true">
  <span class="vo-badge">Made by Vivor Oscar</span>
</div>

<div class="vo-footer" aria-hidden="true">
  &copy; <?php echo date('Y'); ?> Vivor Oscar
</div>
