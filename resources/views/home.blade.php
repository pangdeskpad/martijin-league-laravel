<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.png"/>
    <!-- link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" -->
    <!-- link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet" -->
    <style>
        .container {
            font-size: 12px;
            margin: 0px auto !important;
        }
    </style>
    <title>League Ranking</title>
</head>
<body>
<input type="hidden" id="js-csrf-token" value="{!! csrf_token() !!}"/>
<input type="hidden" id="js-league-token" value="{{ $league_token }}"/>
<input type="hidden" id="js-week-no" value="1"/>

<div class="container" id="app">
    <div class="mt-5 flex justify-center">
        <fortel-component></fortel-component>
    </div>
</div>
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>