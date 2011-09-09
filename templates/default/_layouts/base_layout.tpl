<{config_load 'config.ini.php'}>
<{config_load 'config.ini.php' 'siteinfo'}>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<{$smarty.config.charset}>" />
        <title><{#base_title#}></title>
        <link href="<{$ini.base.media_url}>public/css/reset.css" type="text/css" rel="stylesheet" />
        <link href="<{$ini.base.media_url}>public/css/base.css" type="text/css" rel="stylesheet" />
        <link href="<{$ini.base.media_url}>styles/default/css/main.css" type="text/css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Fontdiner%20Swanky">
        <script type="text/javascript" src="<{$ini.base.media_url}>public/js/jquery.js?v=1.6.2"></script>
        <script type="text/javascript" src="<{$ini.base.media_url}>public/js/unamed.debugbar.js"></script>
    </head>
    <body>
        <div id="header">
            <div id="header-inner">
                <div id="logo" class="float-left">Unamed</div>
                <div id="navigator" class="float-left">Navigator area</div>
                <div id="account-info" class="float-right">
                    <{if $user->is_authenticated}>
                    <{else}>
                        注册&nbsp;&nbsp;&nbsp;&nbsp;登陆
                    <{/if}>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <!--[if gt IE 6]>
        <div id="for-gt-ie6"></div>
        <![endif]-->
        <!--[if lt IE 7]>
        <div id="for-ie6">
            <{'You are using unsafe web brower!'|lang}>
        </div>
        <![endif]-->
        <div id="main-wrap">
            <div id="article">
                <{block content}><{/block}>
            </div>
        </div>
        <div id="footer">
            Copyright &copy; 2011 Unamed. Build on <a href="http://muyou.la/unamed-php-framework" target="_blank">Unamed PHP Framework</a>
        </div>
    </body>
</html>