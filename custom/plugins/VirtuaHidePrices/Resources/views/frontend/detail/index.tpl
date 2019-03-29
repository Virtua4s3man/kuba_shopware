{extends file="parent:frontend/detail/index.tpl"}

{block name='frontend_detail_data_price_configurator'}
    {if $displayPrice === true}
        {$smarty.block.parent}
    {/if}
{/block}