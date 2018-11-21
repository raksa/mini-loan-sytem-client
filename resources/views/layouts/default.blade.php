<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Loan Client Test</title>
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('style')
</head>

<body>
    @yield('content')
    @yield('script')
</body>

</html>
