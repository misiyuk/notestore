<?php

namespace frontend\widgets;

use store\forms\frontend\TitleSearchForm;
use yii\base\Widget;

/**
 * Class TitleSearchWidget
 * @package frontend\widgets
 */
class TitleSearchWidget extends Widget
{
    public function run()
    {
        $model = new TitleSearchForm();
        $params = \Yii::$app->request->queryParams;
        $elements = $model->search($params);
        return $this->render('titleSearch', [
            'elements' => $elements,
            'model' => $model,
        ]);
    }
}