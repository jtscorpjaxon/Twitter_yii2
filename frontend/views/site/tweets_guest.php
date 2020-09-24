<?php
/**
 * Created by PhpStorm.
 * User: Php
 * Date: 23.09.2020
 * Time: 6:55
 */
use app\models\Comments;
use app\models\Likes;
use app\models\Posts;
use common\models\User;
use yii\helpers\Html;

$list=Posts::find()->all();
?>
<div class="col-sm-12 search-for-help">

    <form action="/site/search" class="search-bar">
        <input type="text" name="q" placeholder="Search username...">
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
</div>
<div class="container main-content">
    <div class="row">

        <!-- Center content column -->
        <div class="col-6">
            <ol class="list-inline list-unstyled">
                <?php foreach ($list as $item):
                    $user=User::findOne($item->user_id);
                    ?>
                <li class="media-body"">
                    <div class="table-primary">
                        <div class="header">
                <span class="fullname">
                  <strong><?= $user->first_name.' '.$user->last_name ?></strong>
                </span>
                           <a> <span class="username">@<?= $user->username ?></span></a>
                            <span class="time">- Jul 18</span>
                        </div>
                        <a>
                            <?= Html::img('@web/'.$item->image, ['alt'=>'','width'=>240,'height'=>240]) ?>
                        </a>
                        <div class="text-justify">
                            <p class="" lang="en" data-aria-label-part="0">
                                <?= $item->text
                                ?>

                                <br ><i  class="fa fa-thumbs-o-up" id="l<?= $item->id ?>">
                                    <?=Likes::find()->where(['post_id'=>$item->id,'is_like'=>true])->count()
                                    ?>
                                </i>
                                <i class="fa fa-thumbs-o-down" id="dl<?= $item->id ?>">
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

                                <?= $comment->text
                                ?>



                        </div>
                    <?php endforeach; ?>

                    </div>
                </li>
              <?php endforeach; ?>
            </ol>
            <!-- End: tweet list -->
        </div>
        <!-- End: Center content column -->
        
    </div>
</div>
