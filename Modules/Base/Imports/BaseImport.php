<?php

namespace Modules\Base\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;


class BaseImport implements ToModel, WithStartRow
{
    use Importable;

    protected ?array $data;
    protected ?string $model;
    protected $cols;

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function __construct(array $data, string $model, $cols)
    {
        $this->data = $data;
        $this->model = $model;
        $this->cols = $cols;
    }

    public function model(array $row)
    {
        $set =[];
        foreach($this->data as $i=>$item){
            if($item->list && $this->cols->{$item->name} && ($item->name !== 'id')){
                $set[] = $item->name;
            }
        }

        $setRow = [];
        foreach($set as $i=>$s){
            if(isset($row[$i+1])){
                $setRow[$s] = $row[$i+1];
            }
        }

        return $this->model::firstOrCreate($setRow);
    }
}
