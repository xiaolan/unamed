<{extends '_layouts/base_layout.tpl'}>

<{block content}>

<div class="float-left">
    <img class="float-left" width="160" src="http://muyou.la/wp-content/uploads/2011/09/OgAAAH8x_5a0YfSd0k28Xt4Ir0maQJ-mLFas-BhNbaMiDg0cpRFd2CBeAzJvN6dZtw8X-kxZ-xuN17VvllqkyD6ZEJ8A15jOjNk-dSZO922PFaeYb-ArjYzZOz5k.jpg" />
</div>
<div class="float-left ml-20" style="line-height:250%">
    <p><<----- Across the Great Wall, we can reach every corner in the world.</p>
    <p>Unamed PHP Framework是一个PHP web开发框架， 旨在通过一系列内建的规则和开发库帮助开发者实现快速安全的开发。</p>
    <p>基于<a href="http://www.apache.org/licenses/" target="_blank">Apache License v2.0</a>协议 </p>
    <p>项目托管于Github: <a href="https://github.com/xiaolan/unamed" target="_blank">https://github.com/xiaolan/unamed</a> </p>
</div>
<div class="clear"></div>
<div>
<p>@Feature:</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp; - 灵活的扩展+插件机制 @see: pluggable</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp; - 内建I18N支持 支持普通php数组方式和*nix的gettext方式@see： i18n</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp; - 内建对CSRF以及XSS等常见web攻击的一般防御 @see security</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp; - 简单的二次开发模式 可以方便重写/扩展框架核心文件而无需覆盖 防止在之后框架升级中出现问题 @see dev.org</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp; - 支持多种URL模式， 支持URL伪静态化， 可自由扩展 @see dispatcher</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp; - 框架结构方便对核心进行扩展， 包括多种缓存/模板/I18N/URL样式等</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp; - 内置开发工具包， 包括开发者工具栏， trace工具等</p>
</div>
<div>
        <div class="float-left ml-20" id="index-decoration">         
            <p>Class UnamedFramework {</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;public $is_safe = true;</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;public $is_stable = true;</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;public $is_fast = true;</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;public function <a href="">GettingStartNow</a>() {}</p>
            <p>}</p>
        </div>
        <div class="float-right mr-20" style="_margin-top:-230px">
        <p>More links: </p>
            <p>- <a href="<{url action="documention"}>">Documention</a> - <a href="">Getting start</a></p>
            <p>- <a href="<{url action="documention"}>">Demo</a></p>
            <p>- <a href="<{url action="documention.category.api"}>">API Reference</a></p>
            <p>- <a href="">Extensions</a></p>
            <p>- <a href="">Pluggable</a></p>
            <p>- <a href="">Plugins</a></p>
        </div>
        <div class="clear"></div>
</div>
<{/block}>