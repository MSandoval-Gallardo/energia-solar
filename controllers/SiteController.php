<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use app\models\ContactForm;
use app\models\LoginForm;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\Security;
use yii\mail\MailerInterface;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;
use app\models\Fotografia;
use app\models\Video;

class SiteController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly MailerInterface $mailer,
        private readonly Security $security,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
   
    
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                            'about',
                            'contact',
                            'login',
                            'error',
                            'captcha',
                            'buscar-presupuesto',
                            'reserva',
                        ],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'reserva' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'transparent' => true,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
{
    $fotografias = \app\models\Fotografia::find()
        ->where(['estado' => 1])
        ->orderBy([
            'orden' => SORT_ASC,
            'id' => SORT_ASC,
        ])
        ->all();

    $videos = \app\models\Video::find()
        ->where(['estado' => 1])
        ->orderBy([
            'orden' => SORT_ASC,
            'id' => SORT_ASC,
        ])
        ->all();

    $proyectos = \app\models\Proyecto::find()
        ->where(['estado' => 1])
        ->orderBy([
            'orden' => SORT_ASC,
            'id' => SORT_ASC,
        ])
        ->all();

    $reserva = new \app\models\Reserva();

    return $this->render('index', [
        'fotografias' => $fotografias,
        'videos' => $videos,
        'proyectos' => $proyectos,
        'reserva' => $reserva,
    ]);
}

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load($this->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact(): Response|string
    {
        $model = new ContactForm();

        $contact = $model->load($this->request->post()) && $model->contact(
            $this->mailer,
            Yii::$app->params['adminEmail'],
            Yii::$app->params['senderEmail'],
            Yii::$app->params['senderName'],
        );

        if ($contact) {
            Yii::$app->session->setFlash(
                'success',
                'Thank you for contacting us. We will respond to you as soon as possible.',
            );

            return $this->refresh();
        }

        return $this->render('contact', ['model' => $model]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout(): string
    {
        return $this->render('about');
    }

    public function actionReserva()
{
    $model = new \app\models\Reserva();

    if ($model->load(Yii::$app->request->post())) {

        // Buscar presupuesto por código
        $presupuesto = \app\models\Presupuesto::find()
            ->where([
                'codigo' => $model->presupuesto,
                'estado' => 1,
            ])
            ->one();

        // Verificar que el presupuesto exista
        if ($presupuesto === null) {

            Yii::$app->session->setFlash(
                'error',
                'El número de presupuesto ingresado no existe o no está disponible.'
            );

            return $this->redirect(['index', '#' => 'pago']);
        }

        // Asociar la reserva al presupuesto
        $model->presupuesto_id = $presupuesto->id;

        // Guardar el porcentaje configurado en el presupuesto
        $model->porcentaje_reserva = $presupuesto->porcentaje_reserva;

        // Guardar el monto calculado del presupuesto
        $model->monto_reserva = $presupuesto->monto_reserva;

        // Estado inicial
        $model->estado = 0;

        // Fechas de registro
        $now = date('Y-m-d H:i:s');

        $model->created_at = $now;
        $model->updated_at = $now;

        // Por ahora usamos fecha y hora provisionales
        $model->fecha = date('Y-m-d');
        $model->hora = date('H:i:s');

        if ($model->save()) {

            Yii::$app->session->setFlash(
                'success',
                'Tu solicitud de reserva fue enviada correctamente. Monto de reserva: $' .
                number_format($model->monto_reserva, 0, ',', '.')
            );

            return $this->redirect(['index', '#' => 'pago']);
        }

        Yii::$app->session->setFlash(
            'error',
            'No fue posible guardar la reserva: ' .
            implode(' | ', $model->getFirstErrors())
        );

        return $this->redirect(['index', '#' => 'pago']);
    }

    return $this->redirect(['index', '#' => 'pago']);
}
    public function actionBuscarPresupuesto($codigo)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $codigo = trim($codigo);

        if ($codigo === '') {
            return [
                'success' => false,
                'message' => 'Ingresa un número de presupuesto.',
            ];
        }

        $presupuesto = \app\models\Presupuesto::find()
            ->where([
                'codigo' => $codigo,
                'estado' => 1,
            ])
            ->one();

        if ($presupuesto === null) {
            return [
                'success' => false,
                'message' => 'El presupuesto no existe o no está disponible.',
            ];
        }

        return [
            'success' => true,
            'codigo' => $presupuesto->codigo,
            'monto_total' => $presupuesto->monto_total,
            'porcentaje_reserva' => $presupuesto->porcentaje_reserva,
            'monto_reserva' => $presupuesto->monto_reserva,
        ];
    }
}
