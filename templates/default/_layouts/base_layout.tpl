<{config_load 'config.ini.php'}>
<{config_load 'config.ini.php' 'siteinfo'}>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="ContentType" content="text/html; charset=<{$smarty.config.charset}>" />
        <title><{#base_title#}></title>
        <link href="<{$ini.base.media_url}>public/css/reset.css" type="text/css" rel="stylesheet" />
        <link href="<{$ini.base.media_url}>public/css/base.css" type="text/css" rel="stylesheet" />
        <link href="<{$ini.base.media_url}>styles/default/css/main.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="<{$ini.base.media_url}>public/js/jquery.js?v=1.6.2"></script>
        <script type="text/javascript" src="<{$ini.base.media_url}>public/js/unamed.debugbar.js"></script>
    </head>
    <body>
        <div id="main-wrap">
            <div id="header">
                Hello, Unamed~
            </div>
            <div id="article">
                <div id="article-left" class="float-left">Left Content</div>
                <div id="article-right" class="float-left">Right Panel</div>
            </div>
            <div id="footer">
                <div id="trace_area"></div>
            </div>
        </div>
    </body>
</html>