<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Proyecto extends ActiveRecord
{
    /**
     * Archivo de imagen cargado desde el formulario.
     */
    public $imagenFile;

    public static function tableName()
    {
        return '{{%proyectos}}';
    }

    public function rules()
    {
        return [
            [['titulo'], 'required'],

            [['descripcion'], 'string'],

            [['orden', 'estado'], 'integer'],

            [['created_at', 'updated_at'], 'safe'],

            [['titulo'], 'string', 'max' => 255],

            [['imagen'], 'string', 'max' => 255],

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
                'skipOnEmpty' => true,
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
            'imagen' => 'Imagen',
            'imagenFile' => 'Imagen del proyecto',
            'orden' => 'Orden',
            'estado' => 'Estado',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Obtiene el archivo enviado desde el formulario.
     */
    public function loadUploadedImage()
    {
        $this->imagenFile = UploadedFile::getInstance($this, 'imagenFile');

        return $this->imagenFile;
    }
}