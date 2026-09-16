<?php

namespace app\models;

use yii\db\ActiveRecord;

class Presupuesto extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%presupuestos}}';
    }

    public function rules()
    {
        return [
            [['codigo', 'cliente', 'monto_total'], 'required'],

            [['monto_total', 'porcentaje_reserva', 'monto_reserva', 'estado'], 'integer'],

            [['created_at', 'updated_at'], 'safe'],

            [['codigo'], 'string', 'max' => 100],

            [['cliente'], 'string', 'max' => 150],

            [['email'], 'email'],

            [['email'], 'string', 'max' => 255],

            [['telefono'], 'string', 'max' => 30],

            [['porcentaje_reserva'], 'in',
                'range' => [10, 20, 30, 40, 50, 60, 70, 80, 90, 100]
            ],

            [['estado'], 'in',
                'range' => [0, 1]
            ],

            [['monto_total'], 'integer', 'min' => 1],

            [['codigo'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Código de presupuesto',
            'cliente' => 'Cliente',
            'email' => 'Correo electrónico',
            'telefono' => 'Teléfono',
            'monto_total' => 'Monto total',
            'porcentaje_reserva' => 'Porcentaje de reserva',
            'monto_reserva' => 'Monto de reserva',
            'estado' => 'Estado',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Calcula el monto de reserva según
     * el porcentaje seleccionado.
     */
    public function calcularMontoReserva()
    {
        $this->monto_reserva = (int) round(
            $this->monto_total * ($this->porcentaje_reserva / 100)
        );

        return $this->monto_reserva;
    }
}