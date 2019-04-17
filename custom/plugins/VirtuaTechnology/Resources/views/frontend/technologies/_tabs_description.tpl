{* Headline *}
{block name='virtua_technology_description_title'}
    <div class="content--title">
        {$technology.t_name}
    </div>
{/block}

{* Technology image*}
{block name='virtua_technology_description_text'}
    <div style="max-height: 10rem;max-width: 10rem;">
        {if $technology.path != null}
            <img src="{link file=$technology.path}" alt="{$technology.name}" itemprop="image" />
        {else}
            <img style="position:relative;" src="{link file='frontend/_public/src/img/no-picture.jpg'}" alt="{$alt}" itemprop="image" />
        {/if}
    </div>
{/block}

{* Technology description *}
{block name='virtua_technology_description_text'}
    <div class="product--description" itemprop="description">
        {$technology.t_description}
    </div>
{/block}
