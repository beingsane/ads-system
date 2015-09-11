<?php

namespace backend\controllers;

use Yii;
use backend\controllers\BaseCrudController;

class JobController extends BaseCrudController
{
	public function init()
	{
		$this->modelClass = \common\models\Job::className();
		$this->searchModelClass = \backend\models\JobSearch::className();
	}
}
