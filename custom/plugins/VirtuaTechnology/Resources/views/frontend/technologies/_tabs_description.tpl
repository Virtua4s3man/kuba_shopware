{* Headline *}
{block name='virtua_technology_description_title'}
    <div class="content--title">
        {$technology.t_name}
    </div>
{/block}

{* Technology image*}
{block name='virtua_technology_description_text'}
    <div class="product--info">
        <a href="" class="product--image">
            <span class="image--element">
                <span class="image--media">
                    <img src="{link file=$technology.path}" alt="{$technology.name}" itemprop="image" />
                </span>
            </span>
        </a>
    </div>
{/block}

{* Technology description *}
{block name='virtua_technology_description_text'}
    <div class="product--description" itemprop="description">
        {$technology.t_description}
    </div>
{/block}
