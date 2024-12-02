<?php

class MnbModel {
    private $client;

    public function __construct() {
        $this->client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");
    }

    public function getCurrentExchangeRates() {
        $response = $this->client->GetCurrentExchangeRates();
        return simplexml_load_string($response->GetCurrentExchangeRatesResult);
    }

    public function getCurrencies() {
        $response = $this->client->GetCurrencies();
        return simplexml_load_string($response->GetCurrenciesResult);
    }

    public function getExchangeRatesByDate($date, $currency) {
        $startDate = $date;
        $endDate = $date;

        $response = $this->client->GetExchangeRates([
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currencyNames' => $currency
        ]);
        
        return simplexml_load_string($response->GetExchangeRatesResult);
    }

    public function getMonthlyExchangeRates($currency, $year, $month) {
        $startDate = "$year-$month-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        $response = $this->client->GetExchangeRates([
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currencyNames' => $currency
        ]);
        
        return simplexml_load_string($response->GetExchangeRatesResult);
    }
}
?>
