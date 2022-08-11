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
    <h1>Forget Password</h1>
    <p>code : {{$code->code}}</p>
    <p>This code expires after 1h</p>
</body>

</html>