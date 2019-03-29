{extends file='parent:frontend/listing/product-box/product-price.tpl'}

{block name='frontend_listing_box_article_price_default'}
    {if $displayPrice === true}
        {$smarty.block.parent}
    {/if}
{/block}