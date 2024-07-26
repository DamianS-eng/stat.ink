<?php

/**
 * @copyright Copyright (C) 2015-2024 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@fetus.jp>
 */

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "battle3_played_with".
 *
 * @property integer $user_id
 * @property string $name
 * @property string $number
 * @property string $ref_id
 * @property integer $count
 * @property integer $disconnect
 *
 * @property User $user
 */
class Battle3PlayedWith extends ActiveRecord
{
    public static function tableName()
    {
        return 'battle3_played_with';
    }

    public function rules()
    {
        return [
            [['user_id', 'name', 'number', 'ref_id', 'count', 'disconnect'], 'required'],
            [['user_id', 'count', 'disconnect'], 'default', 'value' => null],
            [['user_id', 'count', 'disconnect'], 'integer'],
            [['name'], 'string', 'max' => 10],
            [['number'], 'string', 'max' => 32],
            [['ref_id'], 'string', 'max' => 20],
            [['ref_id'], 'unique'],
            [['user_id', 'name', 'number'], 'unique', 'targetAttribute' => ['user_id', 'name', 'number']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'name' => 'Name',
            'number' => 'Number',
            'ref_id' => 'Ref ID',
            'count' => 'Count',
            'disconnect' => 'Disconnect',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
