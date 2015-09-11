<?php

namespace common\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\Expression;
use yii\db\Query;

class SoftDeleteBehavior extends AttributeBehavior
{
    /**
     * Don't delete record, set $deletedAtAttribute to $value
     */
    const SOFT_TYPE = 'soft';
    
    /**
     * If related records exist in related tables, don't delete record, set $deletedAtAttribute to $value
     * Otherwise delete record
     */
    const SOFT_HARD_TYPE = 'soft-hard';
    
    /**
     * Delete record anyway. Equals to usual delete
     */
    const HARD_TYPE = 'hard';
    
    
    public $type = 'soft';
    
    public $deletedAtAttribute = 'deleted_at';
    
    /**
     * Tables which related records can be found in
     * 'relatedTables' => [
     *     'user_comments' => ['column' => 'id', 'foreignColumn' => 'user_id'],
     *     ...
     * ]
     */
    public $relatedTables = [];
    
    public $value;
    
    public $restoredValue = null;
    
    
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [ActiveRecord::EVENT_BEFORE_DELETE => 'makeDelete'];
    }
    
    /**
     * Allow to delete record or set $deletedAtAttribute value and save model
     * @param $event yii\base\Event
     */
    public function makeDelete($event)
    {
        $canDelete = false;
        
        if ($this->type == self::SOFT_TYPE) {
            $this->makeSoftDelete($event);
            $canDelete = false;
        } else if ($this->type == self::SOFT_HARD_TYPE) {
            $canDelete = $this->makeSoftHardDelete();
        } else if ($this->type == self::HARD_TYPE) {
            $canDelete = true;
        }
        
        $event->isValid = $canDelete;
    }
    
    public function makeSoftDelete($event)
    {
        $attribute = $this->deletedAtAttribute;
        $this->owner->$attribute = $this->getValue($event);
        $this->owner->save(false, [$attribute]);
    }
    
    public function makeSoftHardDelete($event)
    {
        $recordsExist = false;
        $model = $this->owner;
        
        foreach ($this->relatedTables as $tableName => $tableParams) {
            $column = $tableParams['column'];
            $foreignColumn = $tableParams['foreignColumn'];
            
            // "SELECT 1 FROM `{$tableName}` WHERE `{$foreignColumn}` = {$model->$column} LIMIT 1";
            $query = new Query();
            $query->select('1')
                ->from($tableName)
                ->where([$foreignColumn => $model->$column])
                ->limit(1);
            $records = $query->all();
            
            if (!empty($records)) {
                $recordsExist = true;
                break;
            }
        }
        
        if ($recordsExist) {
            $this->makeSoftDelete($event);
        }
        
        $canDelete = !$recordsExist;
        return $canDelete;
    }
    
    /**
     * Restore record
     */
    public function restore() {
        $attribute = $this->attribute;
        $this->owner->$attribute = $this->restoredValue;
        $this->owner->save(false, [$attribute]);
    }
    
    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        if ($this->value instanceof Expression) {
            return $this->value;
        } else {
            return $this->value !== null ? call_user_func($this->value, $event) : time();
        }
    }
}
