{extends file="parent:frontend/detail/index.tpl"}

{block name="frontend_detail_data_delivery"}
    {* Delivery informations *}
    {if ($sArticle.sConfiguratorSettings.type != 1 && $sArticle.sConfiguratorSettings.type != 2) || $activeConfiguratorSelection == true}
        {include file="virtua_shipping/virtua_delivery_informations.tpl" sArticle=$sArticle}
    {/if}
{/block}
