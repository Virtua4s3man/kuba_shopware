{extends file="parent:frontend/index/index.tpl" }

{block name="frontend_index_left_categories_inner"}

{/block}

{block name="frontend_listing_listing_container"}
    <div class="listing--container">

        {block name="frontend_listing_no_filter_result"}
            <div class="listing-no-filter-result">
                {s name="noFilterResult" assign="snippetNoFilterResult"}Für die Filterung wurden keine Ergebnisse gefunden!{/s}
                {include file="frontend/_includes/messages.tpl" type="info" content=$snippetNoFilterResult visible=false}
            </div>
        {/block}

        {block name="frontend_listing_listing_content"}
            <div class="listing"
                 data-ajax-wishlist="true"
                 data-compare-ajax="true"
                    {if $theme.infiniteScrolling}
                data-infinite-scrolling="true"
                data-loadPreviousSnippet="{s name="ListingActionsLoadPrevious"}{/s}"
                data-loadMoreSnippet="{s name="ListingActionsLoadMore"}{/s}"
                data-categoryId="{$sCategoryContent.id}"
                data-pages="{$pages}"
                data-threshold="{$theme.infiniteThreshold}"
                data-pageShortParameter="{$shortParameters.sPage}"
                    {/if}>

                {* Actual listing *}
                {block name="frontend_listing_list_inline"}
                    {foreach $technologies as $sArticle}
                        {include file="frontend/listing/box_article.tpl"}
                    {/foreach}
                {/block}
            </div>
        {/block}
    </div>
{/block}

