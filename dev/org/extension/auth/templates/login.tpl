<{extends file="$layout"}>
<{block extra_style}>
<link href="<{$ini.base.media_url}>public/css/form.css" type="text/css" rel="stylesheet" />
<{/block}>
<{block content}>
<form method="POST" action="" class="mt-20">
<table class="m-lr-auto">
    <tr>
        <td colspan="2">
            <{if $error_message}>
                <ul>
                <{foreach $error_message as $ms}>
                    <li> - <{$ms}></li>
                <{/foreach}>
                </ul>
            <{/if}>
        </td>
    </tr>
    <{$login_form|as_table}>
    <tr>
        <td colspan="2" align="center"><input type="submit" class="normal-button" /></td>
    </tr>
</table>
</form>
<{/block}>