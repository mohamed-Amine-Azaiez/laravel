<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <h1>verifyMail/h1>
        <p>link : {{$verifymail->token}}</p>
        <p>This link expires after 1h</p>
</body>

</html>