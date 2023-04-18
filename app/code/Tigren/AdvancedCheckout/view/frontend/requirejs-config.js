var config = {
    config: {
        mixins: {
            'Magento_Catalog/js/catalog-add-to-cart': {
                'Tigren_AdvancedCheckout/js/catalog-add-to-cart-mixin': true
            },
            'Magento_Checkout/js/view/payment/default':{
                'Tigren_AdvancedCheckout/js/view/payment/default-mixin':true
            }
        }
    }
    ,
    map: {
        '*': {
            scriptCookie: 'Tigren_AdvancedCheckout/js/scriptCookie'
        }
    }
};
