{extends file='parent:frontend/detail/index.tpl'}

{block name="frontend_detail_tabs_navigation_inner"}
    {$smarty.block.parent}

    {block name="virtua_technology_detail_tabs_navigation_inner"}
        {if isset($technologies) and !empty($technologies)}
            <a href="#"
               class="tab--link"
               title="{s namespace="virtuaTechnology/index" name="technology"}{/s}"
               data-tabName="technologies">
                {s namespace="virtuaTechnology/index" name="technology"}{/s}
            </a>
        {/if}
    {/block}
{/block}

{block name="frontend_detail_tabs_content_inner"}
    {$smarty.block.parent}
    {* Technology container *}
    {block name="virtua_technology_content_description"}
        {if isset($technologies) and !empty($technologies)}
            <div class="tab--container">
                        <div class="tab--header">
                            <a href="#"
                               class="tab--title"
                               title="technology">
                                {s namespace="virtuaTechnology/index" name="technology"}{/s}
                            </a>
                        </div>
                        <div class="tab--preview">
                            <a href="#"
                               class="tab--link"
                               title="{s namespace="virtuaTechnology/index" name="technology"}{/s}">
                                {s namespace="virtuaTechnology/index" name="technology"}{/s}
                            </a>
                        </div>
                        <div class="tab--content">
                            <div class="content--description">
                                {foreach $technologies as $technology}
                                    {include file="frontend/technologies/_tabs_description.tpl"}
                                {/foreach}
                            </div>
                        </div>
            </div>
        {/if}
    {/block}
{/block}