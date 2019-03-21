// {block name="backend/swag_extend_backend/view/detail/product"}
Ext.define('Shopware.apps.Customer.swagExtendBackend.view.detail.Product', {
    extend: 'Shopware.grid.Panel',
    alias: 'widget.customer-products-grid',
    flex: 2,

    configure: function() {
        return {
            toolbar: false,
            editColumn: false,
            deleteColumn: false,
            columns: {
                name: {}
            }
        }
    },

    createActionColumnItems: function() {
        var me = this,
            items = me.callParent(arguments);

        items.push(me.createOpenProductItem());

        return items;
    },

    createOpenProductItem: function() {
        return {
            action: 'openProduct',
            iconCls: 'sprite-inbox',
            handler: function(view, rowIndex, colIndex, item, opts, record) {
                Shopware.app.Application.addSubApplication({
                    name: 'Shopware.apps.Article',
                    action: 'detail',
                    params: {
                        articleId: record.get('id')
                    }
                });
            }
        }
    }
});
// {/block}
