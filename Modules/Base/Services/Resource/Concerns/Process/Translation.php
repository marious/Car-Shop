<?php

namespace Modules\Base\Services\Resource\Concerns\Process;

use Illuminate\Http\Request;

trait Translation
{
    public function processTranslations(Request $data, $record = null): Request
    {
        $locals = config('translations.locals');
        foreach ($this->rows as $row) {
            if ($row->vue === 'ViltTrans.vue') {
                if ($record) {
                    if (isset($data->{$row->name}) && !empty($data->{$row->name})) {
                        $text = $data->{$row->name};
                        if (is_array($record->{$row->name})) {
                            $data->{$row->name} = $record->{$row->name};
                        } else {
                            $data->{$row->name} = [];
                        }
                        foreach ($locals as $key => $local) {
                            if ($key === app()->getLocale()) {
                                $data->{$row->name}->{$key} = $text;
                            }
                        }
                    }
                } else if (isset($data->{$row->name}) && !is_array($data->{$row->name}) && !empty($data->{$row->name})) {
                    $text = $data->{$row->name};
                    $data->{$row->name} = [];
                    foreach ($locals as $key => $local) {
                        if ($key === app()->getLocale()) {
                            $data->{$row->name}[$key] = $text;
                        } else {
                            $data->{$row->name}[$key] = "";
                        }
                    }
                }
            }
        }
        return $data;
    }
}
