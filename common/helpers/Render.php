<?php
namespace common\helpers;

use Yii;
use yii\web\JsExpression;
use kartik\select2\Select2;


/**
 * @package frontend\helpers
 */
class Render
{
    private $form;
    private $model;
    private $viewMode;
    private $disabledFields;
    
    public function __construct($form, $model, $viewMode = false, $disabledFields = [])
    {
        $this->form = $form;
        $this->model = $model;
        $this->viewMode = $viewMode;
        $this->disabledFields = (array)$disabledFields;
    }
    
    function textField($attribute, $class = '')
    {
        $fieldOptions = ['options' => ['class' => 'form-group ' .$class]];
        $inputOptions = ['class' => 'form-control'];
        
        if ($this->viewMode || in_array($attribute, $this->disabledFields)) {
            $fieldOptions['enableClientValidation'] = false;
            $inputOptions['readonly'] = 'readonly';
        }
        
        return $this->form->field($this->model, $attribute, $fieldOptions)->textInput($inputOptions);
    }
    
    function selectField($attribute, $data, $inputOptions = [], $minimumResultsForSearch = -1)
    {
        $fieldOptions = ['options' => ['class' => 'form-group']];
        $defaultInputOptions = [
            'class' => 'form-control select',
            'placeholder' => $this->model->getAttributeLabel($attribute).'...',
        ];
        $inputOptions = array_replace_recursive($defaultInputOptions, $inputOptions);
        
        if ($this->viewMode || in_array($attribute, $this->disabledFields)) {
            $fieldOptions['enableClientValidation'] = false;
            $inputOptions['disabled'] = 'disabled';
        }
        
        return $this->form->field($this->model, $attribute, $fieldOptions)->widget(Select2::classname(), [
            'data' => $data,
            'options' => $inputOptions,
            'pluginOptions' => [
                'allowClear' => true,
                'minimumResultsForSearch' => $minimumResultsForSearch,
            ],
        ]);
    }
    
    function checkboxField($attribute, $class = '')
    {
        $fieldOptions = [
            'options' => ['class' => 'form-group icheckbox ' .$class],
            'template' => "
                <div>
                    <label class=\"control-label\">&nbsp;</label>
                </div>
                <div class=\"icheckbox-label\">{label}</div>
                {input}\n{hint}\n{error}
            ",
        ];
        $inputOptions = [
            'class' => 'icheck',
        ];
        if ($this->viewMode || in_array($attribute, $this->disabledFields)) {
            $fieldOptions['enableClientValidation'] = false;
            $inputOptions['disabled'] = 'disabled';
        }
        
        return $this->form->field($this->model, $attribute, $fieldOptions)->checkbox($inputOptions, false);
    }
}

