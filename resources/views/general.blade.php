<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        AQAS
    </title>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.3/css/bulma.css">
    <style type="text/css">
        .icon-spinner10:before{content:"\eb56";}
        .icon-3x {
            font-size: 48px;
        }
        .spinner {
            display: inline-block;
            -webkit-animation: rotation 1s linear infinite;
            animation: rotation 1s linear infinite;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://unpkg.com/vue@2.4.4/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src={{url('/js/jquery.blockUI.js')}}></script>

</head>

<body>
<div id="content">
@yield('content')
</div>


@yield('scripts')
</body>


</html>
