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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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

        $model->estado = 0;
        $model->monto_reserva = 99990;

        $now = date('Y-m-d H:i:s');
        $model->created_at = $now;
        $model->updated_at = $now;

        // Por ahora usamos una fecha y hora provisionales.
        // Luego las reemplazaremos por la fecha/hora real de la evaluación.
        $model->fecha = date('Y-m-d');
        $model->hora = date('H:i:s');

        // if ($model->save()) {
        //     Yii::$app->session->setFlash(
        //         'success',
        //         'Tu solicitud de reserva fue enviada correctamente.'
        //     );

        //     return $this->redirect(['index', '#' => 'pago']);
        // }
        if ($model->save()) {
            Yii::$app->session->setFlash(
                'success',
                'Tu solicitud de reserva fue enviada correctamente.'
            );

            return $this->redirect(['index', '#' => 'pago']);
        }

        Yii::$app->session->setFlash(
            'error',
            'No fue posible guardar la reserva: ' . implode(' | ', $model->getFirstErrors())
        );

        return $this->redirect(['index', '#' => 'pago']);
            }

    // Si existe un error de validación, volvemos al inicio.
    return $this->redirect(['index', '#' => 'pago']);
}
}
