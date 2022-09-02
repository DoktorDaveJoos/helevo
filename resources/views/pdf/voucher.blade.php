<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: black;
            color: #fff;;
        }
    </style>
</head>
<body>
<div class="bg-red-500 flex flex-col items-center">

    <h1 class="font-lexend text-gray-800">Gutschein</h1>

    <div class="flex">

        <span>Gutschein-Code</span>
        <div class="p-6 bg-slate-100">
            {{ $code }}
        </div>

    </div>

    <div class="flex">

        <span>Betrag</span>
        <div class="p-6 bg-slate-100">
            {{ $amount }}
        </div>

    </div>


</div>
</body>
</html>
