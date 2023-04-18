define([
        'ko',
        'jquery',
        'mage/storage',
        'Magento_Ui/js/modal/modal',
        'Magento_Checkout/js/action/redirect-on-success',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/url-builder',
        'Magento_Checkout/js/model/payment/additional-validators',
        'mage/cookies'
    ]
    , function (ko,$, storage, modal, redirectOnSuccessAction, quote, url, additionalValidators) {

        var mixi = {
            redirectAfterPlaceOrder: true,
            isPlaceOrderActionAllowed: ko.observable(quote.billingAddress() != null),
            placeOrder: function (data, event) {
                self = this;
                var validate = {
                    request: true
                };
                storage.post(
                    url.createUrl('/rest/checkStatus', {}), JSON.stringify(validate), false
                ).done(function (result) {
                    if (result === 'show') {
                        event.preventDefault();
                        $('#popup').show();
                        var options = {
                            type: 'popup',
                            modalClass: 'modal-popup',
                            responsive: true,
                            innerScroll: true,
                            clickableOverlay: true,
                            title: 'Alert Checkout'
                        };
                        var popup = modal(options, $('#popup'));
                        $('#popup').modal('openModal');
                    } else {
                        if (self.validate() &&
                            additionalValidators.validate() &&
                            self.isPlaceOrderActionAllowed() === true
                        ) {
                            self.isPlaceOrderActionAllowed(false);

                            self.getPlaceOrderDeferredObject().done(
                                function () {
                                    self.afterPlaceOrder();

                                    if (self.redirectAfterPlaceOrder) {
                                        redirectOnSuccessAction.execute();
                                    }
                                }
                            ).always(
                                function () {
                                    self.isPlaceOrderActionAllowed(true);
                                }
                            );

                            return true;
                        }
                    }
                });
            },
            getPlaceOrderDeferredObject: function () {
                return this._super();
            },
            afterPlaceOrder:function () {
                return this._super();
            },
            validate:function () {
              return this._super()
            }
        };
        return function (target) {
            return target.extend(mixi);
        };
    });
