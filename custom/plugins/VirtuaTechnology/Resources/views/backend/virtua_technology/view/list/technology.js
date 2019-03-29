Ext.define('Shopware.apps.VirtuaTechnology.view.list.Technology', {
    extend: 'Shopware.grid.Panel',
    alias: 'widget.technology-list-grid',
    region: 'center',

    configure: function () {
        return {
            detailWindow: 'Shopware.apps.VirtuaTechnology.view.detail.Window'
        };
    }
});