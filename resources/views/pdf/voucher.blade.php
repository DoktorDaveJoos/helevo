<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>

    <style>
        @font-face {
            font-family: 'Lexend';
            src: url({{ storage_path('fonts/Lexend-Regular.ttf') }});
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Nunito';
            src: url({{ storage_path('fonts/Nunito-Regular.ttf') }});
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Satisfy';
            src: url({{ storage_path('fonts/Satisfy-Regular.ttf') }});
            font-weight: normal;
        }

        .company-container {
            position: absolute;
            top: 380px;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            width: 30%;
            text-align: center;
            font-family: Lexend, sans-serif;
        }

        .company-text {
            color: white;
            font-size: 28px;
        }

        .text-container {
            position: absolute;
            top: 440px;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
            text-align: center;
            font-family: Nunito, sans-serif;
        }

        .text-text {
            color: white;
            font-size: 16px;
            font-weight: lighter;
            line-height: normal;
        }

        .code-container {
            position: absolute;
            top: 740px;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            width: 30%;
            text-align: center;
            font-family: Lexend, sans-serif;
        }

        .code-text {
            font-size: 20px;
        }

        .amount-container {
            position: absolute;
            top: 880px;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            width: 30%;
            text-align: center;
            font-family: Lexend, sans-serif;
        }

        .amount-text {
            font-size: 20px;
        }

        .logo-container {
            position: absolute;
            top: 110px;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
            width: 25%;
        }

    </style>
</head>
<body
    style="background-image: url({{ storage_path('img/voucher-boiler.png') }}); background-size: 100% 100%; background-repeat: no-repeat;">

<div class="logo-container">
    <img style="top: 0; bottom: 0; left: 0; right: 0; width: 100%; margin: auto" src="{{ storage_path('app/helevo-base-logo.png') }}" alt="company logo" />
</div>

<div class="company-container">
    <div class="company-text">{{ $company }}</div>
</div>

<div class="text-container">
    <div class="text-text">{{ $text }}</div>
</div>

<div class="code-container">
    <div class="code-text">{{ $code }}</div>
</div>

<div class="amount-container">
    <div class="amount-text">{{ $amount }} €</div>
</div>

</body>
</html>
