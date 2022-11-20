<?php

namespace Modules\Base\Services\Resource\Concerns\Actions;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Base\Exports\BaseExport;

trait Export
{
    public function export(Request $request)
    {
        $cols = $_COOKIE[$this->table . '-cols'];
        if ($cols) {
            $cols = json_decode($cols);
            $q = $this->model::query();

            $select = [];
            $hide = [];
            foreach ($this->rows() as $row) {
                if (($row->vue === 'ViltRelation.vue') && $row->list && $cols->{$row->name}) {
                    $q->with($row->name);
                }
                if (($row->vue === 'ViltHasOne') && $row->list && $cols->{$row->name}) {
                    $q->with($row->relation);
                    $hide[] = $row->name;
                }
                if ($row->list && $cols->{$row->name} && (!$row->over) && ($row->vue !== 'ViltRelation.vue')) {
                    $select[] = $row->name;
                } else {
                    $hide[] = $row->name;
                }
            }
            $q->select($select);

            $data = $q->get()->makeHidden(array_merge($hide, ['fcm', 'fcmID', 'media']))->toArray();
            foreach ($data as $item) {
                foreach ($this->rows() as $row) {
                    if ($row->list && ($row->vue === 'ViltRelation.vue') && $cols->{$row->name}) {
                        if (isset($item[$row->name])) {
                            $item->{$row->name} = $item[$row->name][$row->trackByName];
                        }
                    }
                    if ($row->list && ($row->vue === 'ViltHasOne.vue') && $cols->{$row->name}) {
                        if (isset($item[$row->relation])) {
                            $item[$row->name] = $item[$row->relation][$row->trackByName];
                        }
                        unset($item[$row->relation]);
                    }
                }
            }
            return Excel::download(new BaseExport($data, $this->rows(), $cols), $this->table . '.xlsx');

        }
    }
}
