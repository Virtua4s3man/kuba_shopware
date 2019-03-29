//

Ext.define('Shopware.apps.VirtuaTechnology.store.Technology', {
    extend: 'Shopware.store.Listing',

    configure: function () {
      return {
            controller: 'VirtuaTechnology'
        };
    },

    model: 'Shopware.apps.VirtuaTechnology.model.Technology'
});