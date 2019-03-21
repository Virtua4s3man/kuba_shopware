// {block name="backend/swag_extend_backend/store/product"}
Ext.define('Shopware.apps.Customer.swagExtendBackend.store.Product', {
    extend: 'Shopware.store.Listing',
    model: 'Shopware.apps.Customer.swagExtendBackend.model.Product',

    configure: function() {
        return {
            controller: 'SwagExtendBackend'
        };
    }
});
// {/block}
