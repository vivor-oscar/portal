<?php
// Small site-wide watermark (bottom area) and fixed footer (bottom)
// This include is safe to add to header files but avoid including it on pages
// that send header() redirects before rendering (login redirects already handled).
//
// Optional overrides (set these before including):
// $VO_WATERMARK_SCALE = 0.9;           // multiplier for size (default 1)
// $VO_WATERMARK_OPACITY = 0.35;        // badge text opacity (0..1)
// $VO_WATERMARK_POSITION = 'bottom-right'; // 'bottom-right'|'bottom-left'|'bottom-center'

$vo_scale = isset($VO_WATERMARK_SCALE) ? (float) $VO_WATERMARK_SCALE : 1.0;
$vo_opacity = isset($VO_WATERMARK_OPACITY) ? (float) $VO_WATERMARK_OPACITY : 0.35;
$vo_position = isset($VO_WATERMARK_POSITION) ? $VO_WATERMARK_POSITION : 'bottom-right';

// sanitize position
if (!in_array($vo_position, ['bottom-right','bottom-left','bottom-center'], true)) {
  $vo_position = 'bottom-right';
}
?>

<!-- Watermark & Footer include -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
  /* configurable CSS vars: scale and opacity will be set inline via PHP */
  .vo-watermark { --vo-scale: <?php echo $vo_scale; ?>; --vo-opacity: <?php echo $vo_opacity; ?>; }

  .vo-watermark {
    position: fixed;
    z-index: 9999;
    font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
    /* responsive size: small screens get smaller text, desktop larger */
    font-size: clamp(11px, 0.9vw + 8px, 16px);
    color: rgba(0,0,0,var(--vo-opacity));
    -webkit-text-stroke: 0.2px rgba(255,255,255,0.06);
    pointer-events: none;
    user-select: none;
    transform-origin: 100% 100%;
    transform: scale(var(--vo-scale));
    transition: transform .18s ease, opacity .18s ease;
    opacity: 1;
    display: flex;
    align-items: center;
    gap: 8px;
    /* keep clear of safe-area (iPhone notch / home bar) */
    right: env(safe-area-inset-right, 12px);
    left: auto;
    bottom: calc(15px + env(safe-area-inset-bottom, 2px)); /* leave room for footer */
  }

  /* positions */
  .vo-watermark.pos-bottom-left { left: env(safe-area-inset-left, 12px); right: auto; transform-origin: 0% 100%; }
  .vo-watermark.pos-bottom-center { left: 50%; right: auto; transform-origin: 50% 100%; transform: translateX(-50%) scale(var(--vo-scale)); }

  .vo-watermark .vo-badge {
    display: inline-block;
    padding: 6px 10px;
    background: rgba(255,255,255,0.88);
    border-radius: 6px;
    box-shadow: 0 1px 6px rgba(2,6,23,0.06);
    color: rgba(0,0,0,0.7);
    font-weight: 500;
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
  }

  /* Footer fixed at bottom across pages */
  .vo-footer {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9989;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
    font-size: 13px;
    color: rgba(55,65,81,0.8);
    background: rgba(255,255,255,0.94);
    border-top: 1px solid rgba(0,0,0,0.04);
    pointer-events: none;
    padding-bottom: env(safe-area-inset-bottom, 0px);
  }

  /* darker mode adjustments */
  @media (prefers-color-scheme: dark) {
    .vo-watermark { color: rgba(255,255,255,calc(var(--vo-opacity) * 0.9)); }
    .vo-watermark .vo-badge { background: rgba(0,0,0,0.5); color: rgba(255,255,255,0.92); }
    .vo-footer { background: rgba(18,18,18,0.8); color: rgba(255,255,255,0.78); border-top-color: rgba(255,255,255,0.03); }
  }

  /* compact layout on very small screens: center and reduce size */
  @media (max-width:420px) {
    .vo-watermark { font-size: clamp(10px, 2.2vw, 13px); --vo-scale: calc(var(--vo-scale) * 0.9); bottom: calc(54px + env(safe-area-inset-bottom, 8px)); }
    .vo-watermark .vo-badge { padding: 4px 8px; }
  }

  /* hide watermark when user prefers reduced motion/visuals */
  @media (prefers-reduced-motion: reduce), (prefers-contrast: more) {
    .vo-watermark { opacity: 0.85; transform: none; }
  }
</style>

<?php
// position class
$pos_class = 'pos-bottom-right';
if ($vo_position === 'bottom-left') { $pos_class = 'pos-bottom-left'; }
if ($vo_position === 'bottom-center') { $pos_class = 'pos-bottom-center'; }
?>

<div class="vo-watermark <?php echo $pos_class; ?>" aria-hidden="true">
  <span class="vo-badge">Made by Vivor Oscar</span>
</div>


