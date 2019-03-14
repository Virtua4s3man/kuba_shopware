{extends file="frontend/demo/index.tpl"}

{block name='frontend_index_content'}
    {$smarty.block.parent}
    <h1>from nextAction</h1>
    {$index}
    {s name='demoSnippet'}{/s}
    {action module="widgets" controller="listing" action="topSeller"}
{/block}