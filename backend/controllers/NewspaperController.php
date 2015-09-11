<?php

namespace backend\controllers;

use Yii;
use backend\controllers\BaseCrudController;

class NewspaperController extends BaseCrudController
{
	public function init()
	{
		$this->modelClass = \common\models\Newspaper::className();
		$this->searchModelClass = \backend\models\NewspaperSearch::className();
	}
}
