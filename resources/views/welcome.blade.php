<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to OPOMPOS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts & Styling -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lottie-web@5.7.4/build/player/lottie.min.js"></script>
    @livewireStyles
    <style>
        body {
            margin: 0;
            background-color: #0f172a;
            color: #f1f5f9;
            font-family: 'Roboto Mono', monospace;
            min-height: 100vh;
            text-align: center;
            overflow-x: hidden;
        }


        p {
            margin-top: 20px;
            color: #94a3b8;
            max-width: 600px;
            font-size: 1.2rem;
        }

        .btn-container {
            margin-top: 30px;
        }

        .btn {
            padding: 14px 32px;
            margin: 0 10px;
            background-color: #38bdf8;
            color: #0f172a;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0ea5e9;
        }

        @media (max-width: 600px) {
            .btn-container {
                flex-direction: column;
                display: flex;
                gap: 10px;
            }

            .btn {
                width: 100%;
                max-width: 280px;
            }
        }

        .column {
            flex: 1;
            min-width: 300px;
            max-width: 600px;
        }

        @media (max-width: 768px) {
            #pageContainer {
                flex-direction: column;
                padding: 20px;
            }

            .column.left {
                padding-right: 0;
            }

            .column.right {
                align-items: center;
                justify-content: center;
                display: flex;
                flex-direction: column;
            }
        }

        @media (min-width: 768px) {
            #announcementBanner {
                flex-direction: row !important;
                justify-content: center;
                gap: 16px;
            }
        }
    </style>
</head>


<body>

    @php
        $announcement = \App\Models\Announcement::latest()->first();
    @endphp

    @if ($announcement)
        <div id="announcementBanner"
            style="position: fixed; top: 0; left: 0; right: 0; width: 100%; background-color: #38bdf8; color: #0f172a; padding: 12px 16px; box-shadow: 0 0 10px rgba(0,0,0,0.2); font-weight: 600; z-index: 999; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 8px;">
            📢 <span id="announcementText" style="font-weight: bold;"></span>
            <button id="closeBannerBtn"
                style="background: none; border: none; font-size: 18px; cursor: pointer;">✖</button>
        </div>
    @endif

    <div id="pageContainer"
        style="display: flex; flex-wrap: wrap; flex-direction: row; align-items: flex-start; justify-content: center; gap: 40px; padding: 40px; padding-top: 100px;">
        <!-- Left column with text and buttons -->
        <div class="column left">
            <img src="/images/opom_pos.png" alt="OPOMPOS Logo"
                style="height: 90px; margin: 0 auto 30px auto; display: block; border-radius: 50%; background-color: #1e293b; padding: 8px; box-shadow: 0 0 12px rgba(0, 0, 0, 0.3); max-width: 90%;" />
            <h1 style="font-size: 2.5rem; font-weight: bold; line-height: 1.4; margin-bottom: 20px;">OPOMPOS
                <span style="font-size: 1.2rem; color: #94a3b8;">- Open Point of Sale</span>
            </h1>
            <p>
                Your all-in-one Point of Sale system – empowering businesses with simplicity, speed, and smart control.
                Start managing inventory, sales, and reports the modern way.
            </p>
            <div
                style="margin-top: 40px; padding: 20px; background-color: #1e293b; border-radius: 12px; color: #f1f5f9; font-size: 1rem; max-width: 620px; text-align: left; line-height: 1.6;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <div id="devLottie" style="width: 40px; height: 40px;"></div>
                    <strong>This is an open-source POS project, and we welcome your support!</strong>
                </div>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <div id="nonDevLottie" style="width: 40px; height: 40px;"></div>
                    If you're a developer, please consider joining us by registering or logging in if you already have
                    an account.
                </div>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <div id="viewerLottie" style="width: 40px; height: 40px;"></div>
                    Even if you're not a developer, you're still very welcome — register as a viewer and share your
                    feedback or ideas.
                </div>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div id="designLottie" style="width: 40px; height: 40px;"></div>
                    We’re also looking for designers and contributors from all backgrounds. Every bit of help counts!
                </div>
            </div>
            <div class="btn-container">
                <a href="/into/login" class="btn">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Login"
                        style="width: 16px; height: 16px; margin-right: 8px; vertical-align: middle;" />
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn">
                    <img src="https://cdn-icons-png.flaticon.com/512/992/992651.png" alt="Register"
                        style="width: 16px; height: 16px; margin-right: 8px; vertical-align: middle;" />
                    Register
                </a>
            </div>
        </div>

        <!-- Right column with animation -->
        <div class="column right">
            <div id="lottie-animation"
                style="width: 380px; height: 380px; background-color: #1e293b; border-radius: 20px; padding: 20px; box-shadow: 0 0 15px rgba(0,0,0,0.4);">
            </div>
            <div style="margin-top: 20px; display: flex; justify-content: flex-start;">
                <a href="https://t.me/opompos_channel" target="_blank"
                   style="min-width: 240px; display: flex; align-items: center; gap: 10px; padding: 12px 24px; background-color: #f3f4f6; color: #111827; font-weight: bold; border-radius: 6px; text-decoration: none; transition: background-color 0.3s;">
                    <img src="https://cdn-icons-png.flaticon.com/512/2111/2111646.png" alt="Telegram"
                        style="width: 20px; height: 20px;" />
                    Join Telegram Channel
                </a>
            </div>
        </div>
    </div>

    <script>
        const messages = ["Welcome to OPOMPOS", "Empowering Businesses", "Smart Point of Sale"];
        let index = 0;
        let charIndex = 0;
        let typingSpeed = 100;
        let erasingSpeed = 60;
        let delayBetween = 1500;

        // Removed #typewriter usage since it's now redundant

        function type() {
            if (charIndex < messages[index].length) {
                // No #typewriter element to update
                charIndex++;
                setTimeout(type, typingSpeed);
            } else {
                setTimeout(erase, delayBetween);
            }
        }

        function erase() {
            if (charIndex > 0) {
                // No #typewriter element to update
                charIndex--;
                setTimeout(erase, erasingSpeed);
            } else {
                index = (index + 1) % messages.length;
                setTimeout(type, typingSpeed);
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            if (messages.length) setTimeout(type, 500);
        });
    </script>

    <script>
        lottie.loadAnimation({
            container: document.getElementById('lottie-animation'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets4.lottiefiles.com/packages/lf20_jtbfg2nb.json' // replace with your desired Lottie JSON
        });
    </script>
    @if ($announcement)
        <script>
            const announcementFull = "{{ $announcement->title }}: {{ $announcement->content }}";
            const announcementElement = document.getElementById("announcementText");
            let announceChar = 0;

            function animateAnnouncement() {
                if (announceChar <= announcementFull.length) {
                    announcementElement.textContent = announcementFull.substring(0, announceChar++);
                    setTimeout(animateAnnouncement, 40);
                }
            }

            animateAnnouncement();
        </script>
    @endif
    <script>
        lottie.loadAnimation({
            container: document.getElementById('devLottie'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets9.lottiefiles.com/packages/lf20_jtbfg2nb.json'
        });
        lottie.loadAnimation({
            container: document.getElementById('nonDevLottie'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets10.lottiefiles.com/packages/lf20_vnikrcia.json'
        });
        lottie.loadAnimation({
            container: document.getElementById('viewerLottie'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets9.lottiefiles.com/packages/lf20_jtbfg2nb.json'
        });
        lottie.loadAnimation({
            container: document.getElementById('designLottie'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets10.lottiefiles.com/packages/lf20_vnikrcia.json'
        });
    </script>
    @livewireScripts
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const banner = document.getElementById('announcementBanner');
            const container = document.getElementById('pageContainer');

            if (banner && container) {
                container.style.paddingTop = banner.offsetHeight + 20 + 'px';
            }

            document.getElementById('closeBannerBtn')?.addEventListener('click', function() {
                banner.style.display = 'none';
                container.style.marginTop = '0';
            });
        });
    </script>
    <footer style="text-align: center; color: #94a3b8; font-size: 0.9rem; padding: 30px 0 20px;">
        © 2025 - OPOMPOS
    </footer>
</body>

</html>
