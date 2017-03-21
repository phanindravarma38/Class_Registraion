<?php
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
/*echo '<pre>';
print_r(Yii::$app->user->identity);
echo '</pre>';exit;*/
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::t('app', Yii::$app->name),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top',
                ],
            ]);

            // everyone can see Home page
            $menuItems[] = ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']];
            $menuItems[] = ['label' => Yii::t('app', 'Courses'), 'url' => ['/site/courses']];
            //$menuItems[] = ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']];
            $menuItems[] = ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']];            
            // display Signup and Login pages to guests of the site
            if (Yii::$app->user->isGuest) 
            {
                $menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
                $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
            }
            // display Logout to all logged in users
            else 
            {
            	$menuItems1[] = ['label' => Yii::t('app', 'Profile'), 'url' => ['/site/profile']];
                $menuItems1[] = [
                    'label' => Yii::t('app', 'Logout'),
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            	$menuItems[] = [
            			'label' => Yii::$app->user->identity->name,
            			'items' => $menuItems1,
            	];
            }
           
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; <?= Yii::t('app', Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="pull-right">Developed By: <strong style="color:#FFF;">Nikhil Marri, Noah-Al-Hadidi</strong></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
