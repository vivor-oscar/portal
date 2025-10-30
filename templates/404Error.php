<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            text-align: center;
        }

        h1 {
            font-size: 5em;
            color: #FF6B6B;
            margin: 0;
        }

        p {
            font-size: 1.2em;
            color: #555;
            margin-top: 20px;
        }

        .button {
            margin-top: 30px;
            padding: 15px 30px;
            font-size: 1em;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
        }

        .error-animation {
            margin-top: 40px;
            position: relative;
            width: 100px;
            height: 100px;
            background-color: #FF6B6B;
            border-radius: 50%;
            animation: bounce 1.5s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .error-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="error-container">
        <div class="error-animation"></div>
        <h1>404</h1>
        <p>Oops! The page you’re looking for doesn’t exist.</p>
        <a href="../" class="button">Go Back Home</a>
    </div>

</body>
</html>
