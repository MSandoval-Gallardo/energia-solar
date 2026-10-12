<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Presupuesto;

class Reserva extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%reservas}}';
    }

    public function rules()
    {
        return [
            [['nombre', 'email', 'telefono', 'fecha', 'hora'], 'required'],

            [['fecha'], 'date', 'format' => 'php:Y-m-d'],

            [['hora'], 'time', 'format' => 'php:H:i:s'],

            [['mensaje'], 'string'],

            [['estado'], 'integer'],

            [['estado'], 'in', 'range' => [0, 1, 2]],

            [['nombre'], 'string', 'max' => 150],

            [['email'], 'email'],

            [['email'], 'string', 'max' => 255],

            [['telefono'], 'string', 'max' => 30],

            [['presupuesto'], 'string', 'max' => 100],
            [['direccion'], 'string', 'max' => 255],
            [['monto_reserva'], 'integer'],

            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'email' => 'Correo electrónico',
            'telefono' => 'Teléfono',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'mensaje' => 'Mensaje',
            'estado' => 'Estado',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
            'presupuesto' => 'Número de presupuesto',
            'direccion' => 'Dirección del proyecto',
            'monto_reserva' => 'Monto de reserva',
        ];
    }

    public function getEstadoTexto()
    {
        return match ((int) $this->estado) {
            0 => 'Pendiente',
            1 => 'Confirmada',
            2 => 'Cancelada',
            default => 'Desconocido',
        };
    }
    public function getPresupuesto()
    {
        return $this->hasOne(Presupuesto::class, ['id' => 'presupuesto_id']);
    }
}