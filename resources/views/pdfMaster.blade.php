<!DOCTYPE html>
<html>

<head>

<link rel="stylesheet" href="{{asset('css/common.css?v='.time())}}">
<style>
    *{
        box-sizing: border-box
    }
</style>
@yield('css')
</head>

<body>
@yield('content')
</body>

</html>