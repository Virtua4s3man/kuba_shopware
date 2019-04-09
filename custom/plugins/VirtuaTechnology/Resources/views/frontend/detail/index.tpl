{extends file='parent:frontend/detail/index.tpl'}

{block name="frontend_detail_tabs_navigation_inner"}
    {$smarty.block.parent}

    {block name="virtua_technology_detail_tabs_navigation_inner"}
        <a href="#" class="tab--link" title="technology" data-tabName="technologies">technology</a>
    {/block}

{/block}

{* todo osnippetsować!!*}
{block name="frontend_detail_tabs_content_inner"}
    {$smarty.block.parent}
    {* Technology container *}
    {block name="virtua_technology_content_description"}
        <div class="tab--container">
                    <div class="tab--header">
                        <a href="#" class="tab--title" title="technology">technology</a>
                    </div>
                    <div class="tab--preview">
                        <a href="#" class="tab--link" title="technology"></a>
                    </div>
                    <div class="tab--content">
                        <div class="content--description">
                            {foreach $technologies as $technology}
                                {include file="frontend/technologies/_tabs_description.tpl"}
                            {/foreach}
                        </div>
                    </div>
        </div>
    {/block}
{/block}