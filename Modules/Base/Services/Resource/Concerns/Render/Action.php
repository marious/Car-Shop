<?php

namespace Modules\Base\Services\Resource\Concerns\Render;

use Modules\Base\Services\Components\Base\Action as ActionComponent;
use Modules\Base\Services\Components\Base\Component;
use Modules\Base\Services\Components\Base\Modal as ModalComponent;
use Modules\Base\Services\Rows\Media;

trait Action
{
    public ?bool $export = true;
    public ?bool $import = true;

    public function actions(): array
    {
        return [];
    }

    public function components(): array
    {
        $components = [];

        if($this->import && config('base.excel_import')){
            $components[] =  ActionComponent::make('import')
                ->label(__('Import'))
                ->icon('bx bx-import mr-1')
                ->modal('import')
                ->classType('action');
            $components[] =  ModalComponent::make('import')
                ->rows([
                Media::make('excel')->label(__('Please Input Excel File'))
            ])->buttons([
                \Modules\Base\Services\Components\Base\Action::make('import')->label(__('Import'))->icon('bx bx-circle')->action($this->table.'.import')
            ])->classType('modal');
        }
        if($this->export&& config('base.excel_export')){
            $components[] =  ActionComponent::make('export')
                ->label(__('Export'))
                ->icon('bx bx-spreadsheet mr-1')
                ->classType('action')
                ->url(url('admin/' . str_replace('_', '-', $this->table) .'/export'));
        }

        return $components;
    }
}
