{extends file="parent:frontend/detail/index.tpl"}

{block name="frontend_detail_index_buy_container_base_info"}
    {$smarty.block.parent}
    {if $sArticle.is_featured == 1}
        <div class="content--title">{s name="is_featured" }{/s}</div>
    {/if}
    {action module=widgets controller=featured_products_list action=show_list}
{/block}