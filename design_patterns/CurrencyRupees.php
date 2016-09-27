<?php
include_once('currencyInterface.php');

class CurrencyRupees implements CurrencyInterface{

    public function convert($price)
    {
        return (int)$price*60;
    }
}