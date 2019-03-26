{extends file="parent:frontend/detail/index.tpl"}

{block name='frontend_detail_description_properties'}
    {$smarty.block.parent}
    {if $sArticle.is_featured == 1}
        <div class="content--title">{s name="is_featured" }{/s}</div>
    {/if}
{/block}
