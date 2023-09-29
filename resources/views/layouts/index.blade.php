<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Include jQuery from HTTP CDN -->
    <!-- Include Bootstrap CSS from HTTP CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome CSS from HTTPS CDN -->
    <link rel="stylesheet" href="{{asset('dist/css/lightbox.min.css')}}">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">--}}
    <link rel="stylesheet" href="css/app.css">
    <!-- include VueJS first -->
    <script src="https://unpkg.com/vue@next"></script>

    <!-- use the latest VueQuill release -->
    <link rel="stylesheet" href="https://unpkg.com/@vueup/vue-quill@latest/dist/vue-quill.snow.prod.css">
    <title>Comments</title>
</head>
<body>

@yield('content')
<script src="https://unpkg.com/@vueup/vue-quill@latest"></script>
<script src="{{asset('dist/js/lightbox-plus-jquery.js')}}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- use the latest release -->
<script src="https://unpkg.com/vuejs-paginate-next@latest/dist/vuejs-paginate-next.umd.js"></script>
<!-- or use the specify version -->
<script src="https://unpkg.com/vuejs-paginate-next@1.0.2/dist/vuejs-paginate-next.umd.js"></script>
<script src="js/app.js" type="module"></script>
</body>
</html>
