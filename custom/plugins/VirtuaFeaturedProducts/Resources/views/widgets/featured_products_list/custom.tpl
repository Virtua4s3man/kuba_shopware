{block name="virtua_featured_products_list_widget"}
    {if $display}
        <div class="panel has--border is--rounded">
            <div class="panel--title is--underline">
                {s name="featured_products_title"}{/s}
            </div>
            {include file="frontend/_includes/product_slider.tpl" articles=$featuredProducts }
        </div>
    {/if}
{/block}
