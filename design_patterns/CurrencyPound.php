<?php
include_once('currencyInterface.php');
class CurrencyPound implements CurrencyInterface{
    public function convert($price)
    {
        return (int)$price/1.3845;
    }

}