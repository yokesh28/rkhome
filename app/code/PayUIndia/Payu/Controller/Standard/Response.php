<?php

namespace PayUIndia\Payu\Controller\Standard;

class Response extends \PayUIndia\Payu\Controller\PayuAbstract {

    public function execute() {
        $returnUrl = $this->getCheckoutHelper()->getUrl('checkout');
        $hashcheck = $this->getPaymentMethod()->buildCheckoutRequest();
        $ghash = $this->getPaymentMethod()->paymentAction();
        $rhash = $this->getPaymentMethod()->success();
         
       
        
        $genhash = $hashcheck['hash'];
         $rev = $hashcheck['hash2'];

        try {
            $paymentMethod = $this->getPaymentMethod();
            $params = $this->getRequest()->getParams();
           
          if($ghash != $rhash){
               $this->messageManager->addErrorMessage(__('Payment failed. Please try again or choose a different payment method'));
                $returnUrl = $this->getCheckoutHelper()->getUrl('checkout/onepage/failure');
           }
            elseif( $genhash != $rev    ){
                 $this->messageManager->addErrorMessage(__('Payment failed. Please try again or choose a different payment method'));
                $returnUrl = $this->getCheckoutHelper()->getUrl('checkout/onepage/failure');
            }

           
           elseif ($paymentMethod->validateResponse($params) ) {
            

                $returnUrl = $this->getCheckoutHelper()->getUrl('checkout/onepage/success');
                $order = $this->getOrder();
                $payment = $order->getPayment();
                $paymentMethod->postProcessing($order, $payment, $params, $genhash, $rev);
            }else {
                $this->messageManager->addErrorMessage(__('Payment failed. Please try again or choose a different payment method'));
                $returnUrl = $this->getCheckoutHelper()->getUrl('checkout/onepage/failure');
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addExceptionMessage($e, $e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('We can\'t place the order.'));
        }

        $this->getResponse()->setRedirect($returnUrl);
    }

}
