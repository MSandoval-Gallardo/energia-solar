<?php

namespace app\models;

use yii\db\ActiveRecord;

class Video extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%videos}}';
    }

    public function rules()
    {
        return [
            [['titulo', 'url'], 'required'],

            [['descripcion'], 'string'],

            [['orden', 'estado'], 'integer'],

            [['created_at', 'updated_at'], 'safe'],

            [['titulo'], 'string', 'max' => 255],

            [['url', 'miniatura'], 'string', 'max' => 500],

            [['estado'], 'in', 'range' => [0, 1]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
            'url' => 'URL del video',
            'miniatura' => 'Miniatura',
            'orden' => 'Orden',
            'estado' => 'Estado',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }
}