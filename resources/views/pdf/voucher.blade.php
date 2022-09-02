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

        .lexend {
            font-family: Lexend, sans-serif;
        }

        .nunito {
            font-family: Nunito, sans-serif;
        }

        .satisfy {
            font-family: Satisfy, cursive;
        }

        .container {
            width: 595px;
            height: 150px;
        }

        .smaller-container {
            width: 595px;
            height: 75px;
        }

        .center__vertical {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .center__horizontal {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .center__both {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .box {
            width: 110px;
            padding: 2rem;
            background-color: #F28D91;
            border-radius: 0.5rem;
            opacity: 0.8;
            text-align: center;
        }

        .gray-500 {
            color: #6b7280
        }
    </style>
</head>
<body>

<div style="height: 200px"></div>


<div class="container">
    <div class="center__horizontal">

    </div>
</div>

<div class="container">
    <div class="center__horizontal">
        <span class="satisfy" style="font-size: 45px">Gutschein</span>
    </div>
</div>
<div class="smaller-container">
    <div class="center__horizontal">
        <span class="lexend" style="font-size: 30px">{{ $company }}</span>
    </div>
</div>

<div class="container">
    <div class="center__horizontal" style="text-align: center">
        <span class="nunito gray-500" style="font-size: 16px">{{ $text }}</span>
    </div>
</div>

<div class="container nunito">
    <div class="center__horizontal">
        <div class="lexend gray-500" style="font-size: x-small">Gutschein Code</div>
        <div class="box">{{ $code }}</div>
    </div>
</div>

<div class="container nunito">
    <div class="center__horizontal">
        <div class="lexend gray-500" style="font-size: x-small">Betrag</div>
        <div class="box">{{ $amount }} €</div>
    </div>
</div>

</body>
</html>
