Ext.define('Shopware.apps.VirtuaTechnology', {
    extend: 'Enlight.app.SubApplication',

    name: 'Shopware.apps.VirtuaTechnology',

    loadPath: '{url action=load}',
    bulkLoad: true,

    controllers: ['Main'],

    views: [
        'list.Window',
        'list.Technology',

        'detail.Window',
        'detail.Technology'
    ],

    models: [ 'Technology' ],
    stores: [ 'Technology' ],

    launch: function () {
        return this.getController('Main').mainWindow;
    }
});