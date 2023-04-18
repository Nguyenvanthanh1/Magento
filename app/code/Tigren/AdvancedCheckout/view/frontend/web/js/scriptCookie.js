define(['jquery','Magento_Ui/js/modal/modal','mage/cookies'], function ($,modal) {
    'use strict';

    return function scriptCookie(){

        $('.checkout').on('click', function(e){
            if($.mage.cookies.get('is_allow_order')){
                e.preventDefault();
                $('#popup').show();
                var options= {
                    type: 'popup',
                    modalClass: 'modal-popup',
                    responsive: true,
                    innerScroll: true,
                    clickableOverlay: true,
                    title: 'Alert Checkout'
                }
                var popup = modal(options, $('#popup'));
                $('#popup').modal('openModal');
            }
        })
    }
});
