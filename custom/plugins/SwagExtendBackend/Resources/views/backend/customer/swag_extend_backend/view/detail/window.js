//{block name="backend/customer/view/detail/window"}
//{$smarty.block.parent}
Ext.define('Shopware.apps.Customer.swagExtendBackend.view.detail.Window', {
    override: 'Shopware.apps.Customer.view.detail.Window',

    getTabs: function() {
        var me = this,
            items = me.callParent(arguments);

        items.push(me.createProductTab());

        return items;
    },

    createProductTab: function() {
        var me = this;

        var store = Ext.create('Shopware.apps.Customer.swagExtendBackend.store.Product');
        store.getProxy().extraParams.customerId = me.record.get('id');
        store.load();

        me.gridPanel = Ext.create('Shopware.apps.Customer.swagExtendBackend.view.detail.Product', {
            store: store,
            subApp: me.subApplication
        });

        return Ext.create('Ext.container.Container', {
            title: 'Ordered products',
            layout: {
                type: 'hbox',
                align: 'stretch'
            },
            items: [
                me.gridPanel
            ]
        });
    }
});
//{/block}
