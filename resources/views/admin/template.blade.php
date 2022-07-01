<? header('Content-Type: text/html; charset=utf8'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt_BR">

<head>
    <title>KANBAN</title>
    <meta charset="utf-8">
    <meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT" />
    <meta http-equiv="Last-Modified" content="<?= gmdate('D, d M Y H:i:s') . ' GMT' ?>" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Cache-Control" content="post-check=0, pre-check=0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Cache" content="no-cache" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="rating" content="general" />
    <meta name="author" content="Sandro Alves Peres" />
    <meta name="title" content="KANBAN" />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="googlebot" content="noindex,nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Mobile device meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=4" />
    <meta name="x-blackberry-defaultHoverEffect" content="false" />
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="240" />

    <link rel="shortcut icon" href="./assets/imagens/trello-desktop.jpg" type="image/jpg" />
    <link rel="apple-touch-icon" href="./assets/imagens/trello-desktop.jpg" type="image/jpg" />
    <link rel="stylesheet" href="./assets/bootstrap-3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./assets/css/kanban.css" />

    <script src="./assets/js/jquery-1.11.2.min.js"></script>
    <script src="./assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    @hasSection('css')
        @yield('css')
    @endif
</head>

<body>

    {{-- <? include_once './formulario.php'; ?> --}}

    <div class="container-fluid">

        @yield('content')

    </div>


    @hasSection('js')
        @yield('js')
    @endif
</body>

</html>
