Ext.define('Shopware.apps.VirtuaTechnology.view.detail.Technology', {
    extend: 'Shopware.model.Container',

    // logo: {
    //     xtype: 'shopware-media-field',
    //     fieldLabel: '{s name=picture}Bild{/s}',
    //     valueField: 'path',
    //     allowBlank: false
    // },

    configure: function () {
        return {
            controller: 'VirtuaTechnology'
        };
    }
});