<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\FormatConverter;

class DatePicker extends \yii\jui\DatePicker
{
    public $saveDateFormat = 'Y-m-d';
    
    
    public function run()
    {
        parent::run();
        
        echo $this->renderSavedValueInput();
        $this->registerScript();
    }
    
    public function renderSavedValueInput()
    {
        if ($this->hasModel()) {
            $value = Html::getAttributeValue($this->model, $this->attribute);
        } else {
            $value = $this->value;
        }
        
        if ($value !== null && $value !== '') {
            // format value according to saveDateFormat
            try {
                $value = Yii::$app->formatter->asDate($value, $this->saveDateFormat);
            } catch(InvalidParamException $e) {
                // ignore exception and keep original value if it is not a valid date
            }
        }
        
        $this->options['savedValueInputID'] = $this->options['id'].'-saved-value';
        
        $options = $this->options;
        $options['id'] = $options['savedValueInputID'];
        $options['value'] = $value;
        
        // render hidden input
        if ($this->hasModel()) {
            $contents = Html::activeHiddenInput($this->model, $this->attribute, $options);
        } else {
            $contents = Html::hiddenInput($this->name, $value, $options);
        }
        
        return $contents;
    }
    
    public function registerScript()
    {
        $language = $this->language ? $this->language : Yii::$app->language;
        if (strncmp($this->saveDateFormat, 'php:', 4) === 0) {
            $saveDateFormat = FormatConverter::convertDatePhpToJui(substr($this->saveDateFormat, 4));
        } else {
            $saveDateFormat = FormatConverter::convertDateIcuToJui($this->saveDateFormat, 'date', $language);
        }
        
        $containerID = $this->inline ? $this->containerOptions['id'] : $this->options['id'];
        $hiddenInputID = $this->options['savedValueInputID'];
        $script = "
            $('#{$containerID}').change(function() {
                var savedValue = $.datepicker.formatDate('{$saveDateFormat}', $(this).datepicker('getDate'));
                $('#{$hiddenInputID}').val(savedValue).trigger('change');
            });
        ";
        $view = $this->getView();
        $view->registerJs($script);
    }
}
