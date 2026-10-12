<?php

namespace app\models;

use yii\db\ActiveRecord;

class Pago extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%pagos}}';
    }

    public function rules()
    {
        return [
            [['reserva_id', 'orden_compra', 'monto', 'created_at', 'updated_at'], 'required'],
            [['reserva_id', 'monto'], 'integer'],
            [['monto'], 'integer', 'min' => 1],
            [['fecha_pago'], 'safe'],
            [['respuesta_transbank'], 'string'],
            [['orden_compra'], 'string', 'max' => 100],
            [['token_transbank'], 'string', 'max' => 255],
            [['estado'], 'string', 'max' => 30],
            [['codigo_autorizacion'], 'string', 'max' => 100],
            [['tipo_pago'], 'string', 'max' => 50],
            [['orden_compra'], 'unique'],
            [
                ['estado'],
                'in',
                'range' => [
                    'iniciado',
                    'aprobado',
                    'rechazado',
                    'anulado',
                    'error',
                ],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reserva_id' => 'Reserva',
            'orden_compra' => 'Orden de compra',
            'token_transbank' => 'Token Transbank',
            'monto' => 'Monto',
            'estado' => 'Estado del pago',
            'codigo_autorizacion' => 'Código de autorización',
            'tipo_pago' => 'Tipo de pago',
            'fecha_pago' => 'Fecha del pago',
            'respuesta_transbank' => 'Respuesta de Transbank',
            'created_at' => 'Fecha de creación',
            'updated_at' => 'Última actualización',
        ];
    }

    public function getReserva()
    {
        return $this->hasOne(Reserva::class, ['id' => 'reserva_id']);
    }
}