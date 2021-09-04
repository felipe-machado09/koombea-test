<?php

namespace App\Helpers;


class Helpers
{
    public static function getCreditCardFranchise($cardNumber){
         // Remove non-digits from the number
         $cardNumber = preg_replace('/\D/', '', $cardNumber);

        // Validate the length
        $len = strlen($cardNumber);
        if ($len < 15 || $len > 16) {
            throw new Exception("Invalid credit card number. Length does not match");
        }else{
            switch($cardNumber) {
                case(preg_match ('/^4/', $cardNumber) >= 1):
                    return 'Visa';
                case(preg_match ('/^5[1-5]/', $cardNumber) >= 1):
                    return 'Mastercard';
                case(preg_match ('/^3[47]/', $cardNumber) >= 1):
                    return 'American Express';
                case(preg_match ('/^3(?:0[0-5]|[68])/', $cardNumber) >= 1):
                    return 'Diners Club';
                case(preg_match ('/^6(?:011|5)/', $cardNumber) >= 1):
                    return 'Discover';
                case(preg_match ('/^(?:2131|1800|35\d{3})/', $cardNumber) >= 1):
                    return 'JCB';
                default:
                    throw new Exception("Could not determine the credit card type.");
                    break;
            }
        }
    }


    public static function hashCreditCard($cardNumber){
        $lastNumbers = substr($cardNumber, -4);
        $numbers = substr($cardNumber, 0,-4);
        $hashNumbers = str_repeat("*", strlen($numbers));

        return $hashNumbers.$lastNumbers;
    }

}
