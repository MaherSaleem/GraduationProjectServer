<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        AQAS
    </title>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css"
          rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.3/css/bulma.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{--<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">--}}


    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhaijaan" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/vue@2.4.4/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src={{url('/js/jquery.blockUI.js')}}></script>
    <script type="text/javascript" src="{{ url('/iCheck/icheck.min.js') }}"></script>
    <link href="{{ url('/iCheck/skins/square/blue.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">

        body {
            /*font: 20px Montserrat, sans-serif;*/
            font-family: 'Baloo Bhaijaan', cursive;
            line-height: 1.8;
            color: #1abc9c;
        }

        p {
            font-size: 16px;
        }


        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        input {
            text-align: right;
        }

        #custom-search-input {
            padding: 3px;
            border: solid 1px #E4E4E4;
            border-radius: 6px;
            background-color: #fff;
        }

        #custom-search-input input {
            border: 0;
            box-shadow: none;
        }

        #custom-search-input button {
            margin: 2px 0 0 0;
            background: none;
            box-shadow: none;
            border: 0;
            color: #666666;
            padding: 0 8px 0 10px;
            border-left: solid 1px #ccc;
        }

        #custom-search-input button:hover {
            border: 0;
            box-shadow: none;
            border-left: solid 1px #ccc;
        }

        #custom-search-input .glyphicon-search {
            font-size: 23px;
        }

        .col-centered {
            float: none;
            margin: 0 auto;
        }

        .centered {
            margin: 0 auto;
        }

        #submit{
            background-color: #1abc9c;
            color: white;
        }

        #query{
            height: auto;
        }



    </style>

</head>

<body>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-16">
            <h1 class="text-center">
                AQAS
            </h1>
        </div>
    </div>
    @yield('content')
</div>


@yield('scripts')
</body>


</html>
