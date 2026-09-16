<?php

namespace app\commands;

use Yii;
use app\models\User;
use yii\console\Controller;

class UserController extends Controller
{
    public function actionCreate()
    {
        $username = $this->prompt('Usuario administrador:');
        $email = $this->prompt('Correo electrónico:');
        $password = $this->prompt('Contraseña:', [
            'required' => true,
            'validator' => function ($value) {
                if (strlen($value) < 8) {
                    return 'La contraseña debe tener al menos 8 caracteres.';
                }

                return true;
            },
        ]);

        if (User::find()->where(['username' => $username])->exists()) {
            $this->stdout("El usuario ya existe.\n");
            return self::EXIT_CODE_ERROR;
        }

        if (User::find()->where(['email' => $email])->exists()) {
            $this->stdout("El correo ya está registrado.\n");
            return self::EXIT_CODE_ERROR;
        }

        $user = new User();

        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();

        if ($user->save()) {
            $this->stdout("Administrador creado correctamente.\n");
            return self::EXIT_CODE_NORMAL;
        }

        $this->stdout("No se pudo crear el administrador.\n");
        print_r($user->errors);

        return self::EXIT_CODE_ERROR;
    }
}