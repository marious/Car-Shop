<?php

namespace Modules\Base\Services\Resource\Concerns\Filters;

trait Relation
{
    public function filterRelation($query)
    {
        foreach($this->rows() as $row){
            if($row->vue === 'ViltRelation.vue' || $row->vue === 'ViltHasOne.vue'){
                if(!empty($row->relation)){
                    $query->with($row->relation);
                }
                else {
                    $query->with($row->name);
                }
            }
        }

        return $query;
    }
}
