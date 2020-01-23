<!doctype html>
<html lang="ru">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shorten URLs</title>
</head>
<body>
<section id="content" class="content">
    <div class="container">

        <div class="row">
            <form id="makeShort" class="mainBlock">

                <input type="text" name="origin_url" id="origin_url" class="fadeIn first origin_url"
                       placeholder="Вставьте ссылку сюда...">

                <div class="messages"></div>

                <input type="submit" class="fadeIn second" value="Укоротить ссылку">
            </form>

            <div id="success"></div>

        </div>
    </div>
</section>


<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>-->
<script src="/js/jquery-3.4.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>

<!--<script src="/js/jquery.magnific-popup.min.js" type="text/javascript"></script>-->
<script src="/js/main.js" type="text/javascript"></script>


</body>


</html>


