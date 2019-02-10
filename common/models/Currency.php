<?php

namespace common\models;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property int $num_code id Валюты во внешней системе
 * @property string $name Название валюты
 * @property string $rate Курс валюты к рублю
 * @property string $updated_at Время последнего обновления
 */
class Currency extends base\Currency
{
    public function beforeValidate()
    {
        $this->updated_at = date('Y-m-d H:i:s');

        return parent::beforeValidate();
    }
}
