<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>

<body>

</body>

<script>

    // $(document).ready(function(){
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         url: 'https://battuta.medunes.net/api/city/jp/search/?city=paris&callback=?&key=ffeff82d44681dc9e056c194360d8945',
    //         method: 'post',
    //         success: function(result){
    //
    //             console.log(result);
    //         }
    //     });
    // });

    // function createCORSRequest(method, url) {
    //     var xhr = new XMLHttpRequest();
    //     if ("withCredentials" in xhr) {
    //
    //         // Check if the XMLHttpRequest object has a "withCredentials" property.
    //         // "withCredentials" only exists on XMLHTTPRequest2 objects.
    //         xhr.open(method, url, true);
    //
    //     } else if (typeof XDomainRequest != "undefined") {
    //
    //         // Otherwise, check if XDomainRequest.
    //         // XDomainRequest only exists in IE, and is IE's way of making CORS requests.
    //         xhr = new XDomainRequest();
    //         xhr.open(method, url);
    //
    //     } else {
    //
    //         // Otherwise, CORS is not supported by the browser.
    //         xhr = null;
    //
    //     }
    //     return xhr;
    // }
    //
    // var xhr = createCORSRequest('POST', 'http://battuta.medunes.net/api/country/all/?key=ffeff82d44681dc9e056c194360d8945');
    // if (!xhr) {
    //     throw new Error('CORS not supported');
    // }
    // xhr.onload = function() {
    //     var responseText = xhr.responseText;
    //     console.log(responseText);
    // };
    //
    // xhr.onerror = function() {
    //     console.log('There was an error!');
    // };

</script>