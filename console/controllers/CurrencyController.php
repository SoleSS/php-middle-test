<?php
namespace console\controllers;

use \common\models\Currency;
use yii\console\ExitCode;

class CurrencyController extends \yii\console\Controller {
    const API_URL = 'http://www.cbr.ru/scripts/XML_daily.asp';

    public function actionImport() {
        foreach ($this->getData()['Valute'] as $item) {
            $model = Currency::find()
                ->where(['num_code' => $item['NumCode']])
                ->limit(1)
                ->one();
            if ($model === null) $model = new Currency();

            $model->num_code = $item['NumCode'];
            $model->name = $item['Name'];
            $model->rate = (float)str_replace(',', '.', $item['Value']);

            if (!$model->save()) {
                print_r($model->errors);
                \Yii::error("[{$item['Name']}] Не удалось сохранить данные о курсе");
                \Yii::error($model->errors);
            }
        }

        return ExitCode::OK;
    }

    private function getData(): array {
        $client = new \yii\httpclient\Client([
            'transport' => 'yii\httpclient\CurlTransport'
        ]);

        $data_arr = [

        ];

        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(static::API_URL)
            ->setData($data_arr);

        $response = $response->send();
        if ($response->isOk) {
            return $response->data;
        }
        else {
            \Yii::error("Не удалось получить данные о текущем курсе валют");
            return [];
        }
    }
}