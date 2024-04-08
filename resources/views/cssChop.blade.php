<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blinking Text</title>
<style>
    @keyframes blink {
        0% { opacity: 1; color: red; }
        50% { opacity: 1; color: yellow;}
        100% { opacity: 1; color: rgb(64, 206, 206); }
    }

    .blinking-text {
        animation: blink 1s linear infinite;
    }
</style>
</head>
<body>
    <p class="blinking-text">Chữ chớp sáng</p>
</body>
</html>
