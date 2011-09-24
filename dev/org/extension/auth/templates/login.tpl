<{extends file="$layout"}>

<{block content}>
<form method="POST" action="">
<{if $error_message}>
    <ul>
    <{foreach $error_message as $ms}>
        <li><{$ms}></li>
    <{/foreach}>
    </ul>
<{/if}>
<{$login_form|as_p}>
<input type="submit" />
</form>
<{/block}>