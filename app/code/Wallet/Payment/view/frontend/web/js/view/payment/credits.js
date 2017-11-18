define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'credits',
                component: 'Wallet_Payment/js/view/payment/method-renderer/credits-method'
            }
        );
        return Component.extend({});
    }
);