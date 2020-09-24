<?php

/* @var $this yii\web\View */

use app\models\Posts;

$this->title = 'My Yii Application';
?>

<div class="site-index">



    <div class="main-container">
        <?php if (!Yii::$app->user->isGuest):?>
       <?= $this->render('/site/tweets') ?>
        <?php

        else:

            echo $this->render('/site/tweets_guest');
        endif;
        ?>

        <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>




    </div>
</div>
