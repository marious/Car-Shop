<?php

namespace Modules\Base\Services\Resource\Concerns\Handlers;

trait Roles
{
    public ?bool $canView = true;
    public ?bool $canViewAny = true;
    public ?bool $canCreate = true;
    public ?bool $canEdit = true;
    public ?bool $canDelete = true;
    public ?bool $canDeleteAny= true;

    public function loadRoles(string $auth = "web"): void
    {
        if(auth($auth)->user()){
            $this->canView = auth($auth)->user()->can('view_' . $this->table);
            $this->canViewAny = auth($auth)->user()->can('view_any_' . $this->table);
            $this->canCreate = auth($auth)->user()->can('create_' . $this->table);
            $this->canEdit = auth($auth)->user()->can('update_' . $this->table);
            $this->canDelete = auth('web')->user()->can('delete_' . $this->table);
            $this->canDeleteAny = auth('web')->user()->can('delete_any_' . $this->table);
        }
        else{
            $this->canView = false;
            $this->canViewAny = false;
            $this->canCreate = false;
            $this->canEdit = false;
            $this->canDelete = false;
            $this->canDeleteAny = false;
        }
    }

    public function checkRoles(string $view): \Inertia\Response | null
    {
        if (!$this->{$view}) {
            return inertia('403');
        }

        return null;
    }
}
