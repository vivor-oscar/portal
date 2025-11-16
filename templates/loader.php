<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <style>
            :root{--loader-bg:rgba(15,23,42,0.92);--accent1:#7c3aed;--accent2:#06b6d4;--accent3:#f97316}
            #page-loader{position:fixed;inset:0;display:flex;align-items:center;justify-content:center;z-index:9999;background:var(--loader-bg);opacity:0;visibility:hidden;transition:opacity .3s ease}
            #page-loader.visible{opacity:1;visibility:visible}
            .loader-card{width:220px;padding:22px;border-radius:12px;background:linear-gradient(180deg,rgba(255,255,255,0.03),rgba(255,255,255,0.02));box-shadow:0 6px 30px rgba(2,6,23,0.6);display:flex;flex-direction:column;align-items:center;gap:12px;color:#fff;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial}
            .loader-svg{width:88px;height:88px}
            /* Animated circular stroke */
            .ring {stroke: url(#g); stroke-width:6; fill:none; stroke-linecap:round; stroke-dasharray: 280; stroke-dashoffset: 280; transform-origin:center; animation: dash 1.6s cubic-bezier(.4,0,.2,1) infinite}
            @keyframes dash {0%{stroke-dashoffset:280; transform:rotate(0deg)}50%{stroke-dashoffset:70; transform:rotate(140deg)}100%{stroke-dashoffset:280; transform:rotate(360deg)}}
            .loader-title{font-size:14px;opacity:.9}
            .loader-sub{font-size:12px;opacity:.7}
            .progress{width:100%;height:8px;background:rgba(255,255,255,0.06);border-radius:999px;overflow:hidden}
            .progress > i{display:block;height:100%;width:0%;background:linear-gradient(90deg,var(--accent2),var(--accent1));border-radius:999px;transition:width .25s linear}
            .loader-meta{display:flex;gap:8px;font-size:11px;color:rgba(255,255,255,0.75);align-items:center}
            .dot{width:8px;height:8px;border-radius:50%;background:var(--accent3);animation: pulse 1.2s infinite}
            @keyframes pulse{0%{transform:scale(.9);opacity:.8}50%{transform:scale(1.2);opacity:1}100%{transform:scale(.9);opacity:.8}}
            @media (max-width:480px){.loader-card{width:88%;padding:16px}}
        </style>
    </head>
    <body>
        <div id="page-loader" aria-hidden="true">
            <div class="loader-card" role="status" aria-live="polite">
                <svg class="loader-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <defs>
                        <linearGradient id="g" x1="0%" x2="100%">
                            <stop offset="0%" stop-color="var(--accent2)"/>
                            <stop offset="100%" stop-color="var(--accent1)"/>
                        </linearGradient>
                    </defs>
                    <circle cx="50" cy="50" r="40" stroke="rgba(255,255,255,0.06)" stroke-width="6" fill="none"/>
                    <circle class="ring" cx="50" cy="50" r="40"/>
                    <!-- small emblem in center -->
                    <g transform="translate(50,50) scale(.9)">
                        <path d="M-8,-2 L0,-12 L8,-2 L0,6 Z" fill="#fff" opacity="0.95"/>
                    </g>
                </svg>
                <div class="loader-title">Loading portal</div>
                <div class="loader-sub">Preparing your dashboard…</div>
                <div class="progress" aria-hidden="true"><i id="loader-bar"></i></div>
                <div class="loader-meta"><div class="dot" aria-hidden="true"></div><div id="loader-percent">0%</div></div>
            </div>
        </div>

        <script>
            // Loader API
            (function(){
                const loader = document.getElementById('page-loader');
                const bar = document.getElementById('loader-bar');
                const pct = document.getElementById('loader-percent');
                let value = 0, raf;
                function set(v){ value = Math.min(100, Math.max(0, Math.round(v))); bar.style.width = value + '%'; if(pct) pct.textContent = value + '%'; }
                function inc(){ set(value + Math.floor(Math.random()*8)+4); if(value<98) raf = setTimeout(inc, 300 + Math.random()*400); }
                window.Loader = {
                    show: function(){ loader.classList.add('visible'); set(6); inc(); },
                    hide: function(){ loader.classList.remove('visible'); clearTimeout(raf); set(100); setTimeout(()=>{ set(0); },250); }
                };
                // Auto show/hide demo: show on DOMContentLoaded then hide on load
                document.addEventListener('DOMContentLoaded', ()=>{ Loader.show(); });
                window.addEventListener('load', ()=>{ setTimeout(()=> Loader.hide(), 450); });
            })();
        </script>
    </body>
</html>