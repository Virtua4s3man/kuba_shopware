// {block name="backend/swag_extend_backend/model/product"}
Ext.define('Shopware.apps.Customer.swagExtendBackend.model.Product', {
    extend: 'Shopware.data.Model',

    fields: [
        { name: 'id', type: 'int' },
        { name: 'mainDetailId', type: 'int' },
        { name: 'name', type: 'string' }
    ]
});
// {/block}
