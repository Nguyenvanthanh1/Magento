define([
    'underscore',
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/url',
    'Magento_Customer/js/customer-data'
], function (_, $, modal, url,customerData) {
    'use strict';
    return function (widget) {
        $.widget('mage.catalogAddToCart', widget, {
            submitForm: function (form) {
                self=this;
                $.ajax({
                    url: url.build('advanced_checkout/index/index'),
                    type: 'POST',
                    data: { sku: form.data().productSku },
                    dataType: 'json',
                    beforeSend: function () {
                        $('body').trigger('processStart');
                    },
                    success: function (response) {
                        if (response.message === 'hide') {
                            $('body').trigger('processStop');
                            self.ajaxSubmit(form);
                        }
                        if (response.message === 'show') {
                            $('body').trigger('processStop');
                            var options = {
                                type: 'popup',
                                responsive: true,
                                title: 'Popup Check Allow Multiple',
                                buttons: [
                                    {
                                        text: $.mage.__('Proceed to Checkout'),
                                        class: '',
                                        click: function () {
                                            location.assign(url.build('checkout'))
                                        }
                                    }, {
                                        text: $.mage.__('Clean Cart'),
                                        class: '',
                                        click: function () {
                                            var sections = ['cart'];
                                            self=this;
                                            $.ajax({
                                                url:url.build('advanced_checkout/index/deleteQuote'),
                                                data:{request:true},
                                                type: 'POST',
                                                dataType: 'json',
                                                beforeSend: function () {
                                                    $('body').trigger('processStart');
                                                },success:function (response){
                                                    if(response.message==='success'){
                                                        $('body').trigger('processStop');
                                                        customerData.invalidate(sections)
                                                        customerData.reload(sections,true);
                                                        self.closeModal();
                                                    }else{
                                                        alert('Can not delete quote')
                                                    }
                                                }
                                            })
                                        }
                                    }
                                ]
                            };
                            var popup = modal(options, $('#modal'));
                            $('#modal').modal('openModal');
                        }
                    }
                });
            },
            ajaxSubmit: function (form) {
                return this._super(form);
            }

        });

        return $.mage.catalogAddToCart;
    };
});
