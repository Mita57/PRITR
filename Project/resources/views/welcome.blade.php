<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
        <title>Fast boi Moor</title>
    </head>
    <style>
        body {
            height: 100%;
            margin: 0;
            font-family: "Noto Sans";
            padding: 0;
            width: 100%;
            background-color: #9ea2a5;
        }
    </style>
    <body>
        <div id="app">
            <app></app>
        </div>
    </body>
    <script src="{{mix('js/app.js')}}"></script>
</html>
