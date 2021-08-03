<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/app.css">
    @if (Auth::check())
    <script>
        window.Laravel = {
            !!json_encode([
                'isLoggedin' => true,
                'user' => Auth::user()
            ]) !!
        }
    </script>
    @else
    <script>
        window.Laravel = {
            !!json_encode([
                'isLoggedin' => false
            ]) !!
        }
    </script>
    @endif
</head>

<body>

    <div id="app">
        Test 1234...
    </div>
    <script src="http://localhost/js/app.js" type="text/javascript"></script>

</body>

</html>