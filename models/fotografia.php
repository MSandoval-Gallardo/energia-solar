<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Fotografia extends ActiveRecord
{
    public $imagenFile;

    public static function tableName()
    {
        return '{{%fotografias}}';
    }

    public function rules()
    {
        return [
            [['titulo'], 'required'],

            [['descripcion'], 'string'],

            [['orden', 'estado'], 'integer'],
            
            [[ 'created_at', 'updated_at'], 'safe'],

            [['titulo'], 'string', 'max' => 255],

            [['archivo'], 'string', 'max' => 255],

            [['estado'], 'in', 'range' => [0, 1]],

            [
                ['imagenFile'],
                'file',
                'extensions' => ['jpg', 'jpeg', 'png', 'webp'],
                'mimeTypes' => [
                    'image/jpeg',
                    'image/png',
                    'image/webp',
                ],
                'maxSize' => 5 * 1024 * 1024,
                'checkExtensionByMimeType' => true,
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'descripcion' => 'Descripción / Reseña',
            'archivo' => 'Archivo',
            'imagenFile' => 'Fotografía',
            'orden' => 'Orden',
            'estado' => 'Estado',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }
}