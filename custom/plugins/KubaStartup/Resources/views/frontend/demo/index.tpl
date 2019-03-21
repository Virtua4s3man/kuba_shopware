{extends file="parent:frontend/index/index.tpl"}

{block name='frontend_index_content'}
    <h1>{$action}nygo?</h1>
    <a href="{url module="frontend" controller='demo' action=$next}">next actino</a>
    {*{s name='demoSnippet'}fallback{/s}*}
{/block}