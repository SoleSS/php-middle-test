<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property int $num_code id Валюты во внешней системе
 * @property string $name Название валюты
 * @property string $rate Курс валюты к рублю
 * @property string $updated_at Время последнего обновления
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['num_code', 'name', 'rate', 'updated_at'], 'required'],
            [['num_code'], 'default', 'value' => null],
            [['num_code'], 'integer'],
            [['rate'], 'number'],
            [['updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num_code' => 'id Валюты во внешней системе',
            'name' => 'Название валюты',
            'rate' => 'Курс валюты к рублю',
            'updated_at' => 'Время последнего обновления',
        ];
    }
}
