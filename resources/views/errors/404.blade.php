<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>
    <meta http-equiv="refresh" content="5;url=/" />
    <style>
        body {
            background-color: #0f172a;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            color: #e2e8f0;
        }

        .container {
            text-align: center;
            max-width: 500px;
        }

        h1 {
            font-size: 36px;
            color: #f8fafc;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            color: #94a3b8;
            margin-bottom: 30px;
        }

        .button {
            display: inline-block;
            background-color: #38bdf8;
            color: #0f172a;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>404 - Page Not Found</h1>
        <p>You’ll be redirected to the home page in <span id="timer">5</span> seconds...</p>
        <a href="/" class="button">Go Now</a>
    </div>

    <script>
        let seconds = 5;
        const timerSpan = document.getElementById('timer');
        const countdown = setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = '/';
            } else {
                timerSpan.textContent = seconds;
            }
        }, 1000);
    </script>
</body>

</html>
