<style type="text/css">
    #paginator{text-align:center; padding:3px 5px;float:right}
    #paginator li{border:1px solid #ddd;float:left;display:inline;margin-left:2px;padding:3px 10px;}
    #paginator li a{display:block;}
    #paginator li.current_page{background:#eee;color:#3c3c3c;padding:3px 10px;}
    #paginator .clear{clear:both;}
</style>
<div id="paginator">
    <ul>
        <li>共：<{$paginator->total_rows}>条记录</li>
        <{if $paginator->has_previous}>
            <li class="has-previous"><a href="<{$paginator->page_param}><{$paginator->previous}>">上一页</a></li>
        <{else}>
            <li class="has-not-previous"><a href="#nogo">上一页</a></li>
        <{/if}>
        <{if $paginator->current_page != 1 && $paginator->display_start != 1}>
            <li><a href="<{$paginator->page_param}>1">1</a></li>
            <li class="dotted"><a href="#nogo">...</a></li>
        <{/if}>
        <{foreach from=$paginator->pages_range item=page_number}>
            <{if $page_number == $paginator->current_page}>
                <li class="current_page"><{$page_number}></li>
            <{else}>
                <li><a href="<{$paginator->page_param}><{$page_number}>"><{$page_number}></a></li>
            <{/if}>
        <{/foreach}>
        <{if $paginator->display_end < $paginator->total_pages}>
            <li class="dotted"><a href="#nogo">...</a></li>
            <li><a href="<{$paginator->page_param}><{$paginator->total_pages}>"><{$paginator->total_pages}></a></li>
        <{/if}>
        <{if $paginator->has_next}>
            <li class="has-next"><a href="<{$paginator->page_param}><{$paginator->next}>">下一页</a></li>
        <{else}>
            <li class="has-not-previous"><a href="#nogo">下一页</a></li>
        <{/if}>
        <div class="clear"></div>
    </ul>
</div>
<div style="clear:both;"></div>