<?php

namespace common\traits;

use Yii;

trait StatusTrait
{
    public function getStatus()
    {
        return ($this->deleted_at == null ? static::STATUS_ACTIVE : static::STATUS_DELETED);
    }

    public function getStatusName()
    {
        $statusName = '';
        switch ($this->getStatus()) {
            case static::STATUS_ACTIVE:  $statusName = Yii::t('app', 'Active');  break;
            case static::STATUS_DELETED: $statusName = Yii::t('app', 'Deleted'); break;
        }

        return $statusName;
    }

    public function getStatusHtml()
    {
        $html = '';

        $html .= $this->getStatusName();
        if ($this->getStatus() == $this::STATUS_DELETED) {
            $html .= '<div class="small-text m-t-xs">'.$this->deleted_at.'</div>';
        }

        return $html;
    }
}