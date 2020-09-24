<?php
/**
 * Created by PhpStorm.
 * User: Php
 * Date: 23.09.2020
 * Time: 6:55
 */
use app\models\Comments;
use app\models\Likes;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

if(!isset($user) || !isset($list))
{

    echo '<h1>Not found user</h1>';
   return false;
}

?>
<div class="col-sm-12 search-for-help">

    <form action="/site/search" class="search-bar">
        <input type="text" name="q" placeholder="Search username...">
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
</div>
<div class="container main-content">
    <div class="row">
        <div class="col-md-4">
            <!-- Left column -->
            <div class="">
                <!-- Header information -->
                <h3>
                    <a><?= $user->first_name.' '.$user->last_name ?></a>
                    </h3>
                <h2 class="profile-element"><a></a><a>@<?= $user->username ?></a></h2>

                <button onclick="subscribe(true)" id="subscribe" >Subscribe </button>
                <button onclick="subscribe(false)" id="unsubscribe">Unsubscribe </button>
            </div>
        </div>
        <!-- End; Left column -->
        <!-- Center content column -->
        <div class="col-6">
            <ol class="list-inline list-unstyled">
                <?php foreach ($list as $item): ?>
                <li class="media-body">

                        <div class="header">
                <span class="fullname">
                  <strong><?= $user->first_name.' '.$user->last_name ?></strong>
                </span>
                            <span class="username"></span>
                            <span class="time"><?= $item->created_at ?></span>
                        </div>
                        <a>
                            <?= Html::img('@web/'.$item->image, ['alt'=>'','width'=>240,'height'=>240]) ?>
                        </a>
                        <div class="text-justify">
                            <p class="" lang="en" data-aria-label-part="0">

                                <?= $item->text
                                ?>
                                <br><i onclick="like(1,<?= $item->id ?>)" class="fa fa-thumbs-o-up" id="l<?= $item->id ?>">
                                    <?=Likes::find()->where(['post_id'=>$item->id,'is_like'=>true])->count()
                                    ?>
                                </i>
                                <i onclick="like(-1,<?= $item->id ?>)" class="fa fa-thumbs-o-down" id="dl<?= $item->id ?>">
                                    <?= Likes::find()->where(['post_id'=>$item->id,'is_dislike'=>true])->count()
                                    ?>
                                    <br>
                                </i>
                            </p>
                        </div>
                    <?php
                    $comments=Comments::findAll(['post_id'=>$item->id]);
                    foreach ($comments as $comment): ?>
                        <div class="col-md-9 ">
                            <?php
                            if(intval($comment->user_id)===Yii::$app->user->id):
                            ?>
                            <?= $comment->text ?>
<a href="/comment/update?id=<?= $comment->id ?>" title="Update" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="/comment/delete?id=<?= $comment->id ?>" title="Delete" aria-label="Delete" data-pjax="0" data-confirm="Are you sure you want to delete this item?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>
       <?php else:
                                echo $comment->text;
                       endif;
                        ?>

                        </div>
                    <?php endforeach; ?>

                    <?php $model = new Comments();
                    $form = ActiveForm::begin(['action'=>['/comment/create']]); ?>

                    <?= $form->field($model, 'text')->textInput() ?>

                    <?= $form->field($model, 'user_id')->hiddenInput(['value'=>Yii::$app->user->id])->label(false) ?>

                    <?= $form->field($model, 'post_id')->hiddenInput(['value'=>$item->id])->label(false) ?>


                    <div class="form-group">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </li>
              <?php endforeach; ?>
            </ol>
            <!-- End: tweet list -->
        </div>
        <!-- End: Center content column -->

    </div>
</div>
<script>

    function like(islike,id) {

        $.ajax({
            url: '/site/likes',
            type:'POST',
            data:{is_like: islike,id: id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {

                $('#l'+id).text(res.like);
                $('#dl'+id).text(res.dislike);
            },
            error:function () {

            }
        });
    }
    function subscribe(issub) {

        $.ajax({
            url: '/site/subscribe',
            type:'POST',
            data:{is: issub,id: <?=$user->id?>},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
if(res)
{
    $('#subscribe').attr('disabled','true');
    $('#unsubscribe').removeAttr('disabled','true');
}
else
{
    $('#unsubscribe').attr('disabled','true');
    $('#subscribe').removeAttr('disabled','true')
}


            },
            error:function () {

            }
        });
    }

</script>