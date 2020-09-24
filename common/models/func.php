<?php

use common\models\User;
use yii\web\UploadedFile;

function vd($data) {
    echo "<pre>", var_dump($data), "</pre>";
}

  function vdd($data) {
    echo "<pre>", var_dump($data), "</pre>";
    die;
}
function UpImages($model,$upload){
    if ($upload) {
        if(!empty($model->image)){
            $ex= json_decode($model->image,false);
            if(is_array($ex))
                foreach ($ex as $fayl)
                    if (file_exists($fayl))unlink($fayl);
        }

        $dir=User::findOne(Yii::$app->user->getId())->market_id;
        $model->market_id=$dir;
        $model->img = $upload;
        $model->save();
        $id=$model->id;
        $model->image = '[';
        foreach($model->img as $file) {
            $model->image .='"';
            $model->image .= "images/$dir/$id/" . $file->baseName . '.' . $file->extension;;
            $model->image .='"';
            $model->image .= ',';
        }
        $model->image=rtrim($model->image, ",");
        $model->image .= ']';
        $model->save();
        if ($model->uploadGallery($dir)) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return 'Ok';
        }
    }
}
function MarketId(){
    return User::findOne(Yii::$app->user->getId())->market_id;
}
function key_map(){
    return 'AIzaSyBkxS5l87lclaC6MIWSGejdCXL13wSShRo';
}