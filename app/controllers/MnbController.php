<?php


require_once rtrim(BASE_PATH, '/') . '/app/models/MnbModel.php';

class MnbController {
    private $model;

    public function __construct() {
        $this->model = new MnbModel();
    }

    public function index() {
        $currencies = $this->model->getCurrencies();
        return [
            'currencies' => $currencies
        ];
    }

    public function getRateByDate($date, $currency) {
        return $this->model->getExchangeRatesByDate($date, $currency);
    }

    public function getMonthlyRates($currency, $year, $month) {
        return $this->model->getMonthlyExchangeRates($currency, $year, $month);
    }
}
?>
