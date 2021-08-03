<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/app.css">
</head>

<body>

    @if (Auth::check())
    @php
    $user_auth_data = [
    'isLoggedin' => true,
    'user' => Auth::user()
    ];
    @endphp
    @else
    @php
    $user_auth_data = [
    'isLoggedin' => false
    ];
    @endphp
    @endif
    <script>
        window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
    </script>

    <div id="app">
        Test 1234...
    </div>
    <script src="js/app.js" type="text/javascript"></script>

</body>

</html>