<!DOCTYPE html>
<html>
<head>
    <title>94 MAKEUP</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
    </style>

    <script>
        var facebookAppId = '{!! env('FACEBOOK_APP_ID', '') !!}';
        var facebookAppApi = '{!! env('FACEBOOK_APP_API', '') !!}';
    </script>

</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">94 MAKEUP</div>
        <button id="facebook-share">Share</button>
    </div>
</div>
</body>

<script src="/public/components/jquery/dist/jquery.min.js"></script>
<script src="/public/js/facebook.js"></script>
</html>
