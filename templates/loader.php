<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(26, 26, 46, 0.95);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
            opacity: 0;
            visibility: hidden;
        }

        #page-loader.visible {
            opacity: 1;
            visibility: visible;
        }

        .neon-loader {
            width: 120px;
            height: 120px;
            position: relative;
        }

        .neon-loader .ring {
            position: absolute;
            border-radius: 50%;
            border: 3px solid transparent;
            animation: neon-pulse 2s linear infinite;
        }

        .neon-loader .ring:nth-child(1) {
            width: 100%;
            height: 100%;
            border-top: 3px solid #00dbde;
            border-bottom: 3px solid #00dbde;
            box-shadow: 0 0 15px rgba(0, 219, 222, 0.7);
        }

        .neon-loader .ring:nth-child(2) {
            width: 80%;
            height: 80%;
            top: 10%;
            left: 10%;
            border-left: 3px solid #fc00ff;
            border-right: 3px solid #fc00ff;
            animation-delay: 0.2s;
            box-shadow: 0 0 15px rgba(252, 0, 255, 0.7);
        }

        .neon-loader .ring:nth-child(3) {
            width: 60%;
            height: 60%;
            top: 20%;
            left: 20%;
            border-top: 3px solid #4776E6;
            border-bottom: 3px solid #4776E6;
            animation-delay: 0.4s;
            box-shadow: 0 0 15px rgba(71, 118, 230, 0.7);
        }

        .neon-loader .center {
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 20px white;
            animation: center-pulse 2s ease-in-out infinite;
        }

        @keyframes neon-pulse {
            0% { transform: rotate(0deg) scale(1); opacity: 1; }
            50% { transform: rotate(180deg) scale(1.1); opacity: 0.7; }
            100% { transform: rotate(360deg) scale(1); opacity: 1; }
        }

        @keyframes center-pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.2); }
        }
    </style>
</head>
<body>
    <!-- Loader HTML -->
    <div id="page-loader">
        <div class="neon-loader">
            <div class="ring"></div>
            <div class="ring"></div>
            <div class="ring"></div>
            <div class="center"></div>
        </div>
    </div>

    <script>
        // Simple loader control
        const Loader = {
            show: () => document.getElementById('page-loader').classList.add('visible'),
            hide: () => document.getElementById('page-loader').classList.remove('visible')
        };

        // Usage examples:
        // Loader.show(); - to show the loader
        // Loader.hide(); - to hide the loader
        
        // Demo: Show loader for 3 seconds on page load
        document.addEventListener('DOMContentLoaded', function() {
            Loader.show();
            setTimeout(() => Loader.hide(), 3000);
        });
    </script>
</body>
</html>