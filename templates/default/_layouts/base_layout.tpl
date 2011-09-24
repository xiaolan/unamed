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
                <div id="logo" class="float-left">Unamed PHP Framework</div>
                <div id="navigator" class="float-left">
                    <a href="<{'index'|url}>">Home</a>
                    <a href="<{'article.category.documention'|url}>">Documention</a>
                    <div class="clear"></div>
                </div>
                <div id="account-info" class="float-right">
                    <{if $user->is_authenticated}>
                    <{else}>
                        <a href="<{"auth.register"|url}>"><{'Register'|lang}></a>
                        <a href="<{"auth.login"|url}>"><{'Login'|lang}></a>
                    <{/if}>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        
        <div id="main-wrap">
            <div id="article">
                <{block content}><{/block}>
            </div>
        </div>
        <div id="footer">
            Copyright &copy; 2011 Unamed. Build on <a href="http://muyou.la/unamed_php_framework" target="_blank">Unamed PHP Framework</a>
        </div>
        <div id="kill-ie6">
            <script type="text/javascript" src="http://letskillie6.googlecode.com/svn/trunk/letskillie6.zh_CN.pack.js"></script>
        </div>
    </body>
</html>