<?php

namespace Modules\Base\Services\Rows\Abstracts;

use Modules\Base\Services\Concerns\HasColor;
use Modules\Base\Services\Concerns\HasDefault;
use Modules\Base\Services\Concerns\HasDescription;
use Modules\Base\Services\Concerns\HasHint;
use Modules\Base\Services\Concerns\HasId;
use Modules\Base\Services\Concerns\HasLabel;
use Modules\Base\Services\Concerns\HasMax;
use Modules\Base\Services\Concerns\HasMedia;
use Modules\Base\Services\Concerns\HasMin;
use Modules\Base\Services\Concerns\HasModel;
use Modules\Base\Services\Concerns\HasName;
use Modules\Base\Services\Concerns\HasOptions;
use Modules\Base\Services\Concerns\HasPlaceholder;
use Modules\Base\Services\Concerns\HasQuery;
use Modules\Base\Services\Concerns\HasReactiveBy;
use Modules\Base\Services\Concerns\HasReactiveRow;
use Modules\Base\Services\Concerns\HasRelation;
use Modules\Base\Services\Concerns\HasRoles;
use Modules\Base\Services\Concerns\HasTab;
use Modules\Base\Services\Concerns\HasTrack;
use Modules\Base\Services\Concerns\HasType;
use Modules\Base\Services\Concerns\HasValidation;
use Modules\Base\Services\Concerns\IsDisabled;
use Modules\Base\Services\Concerns\IsMulti;
use Modules\Base\Services\Concerns\IsOver;
use Modules\Base\Services\Concerns\IsReactive;
use Modules\Base\Services\Concerns\IsRequired;
use Modules\Base\Services\Concerns\IsSearchable;
use Modules\Base\Services\Concerns\IsSortable;
use Modules\Base\Services\Concerns\IsUnique;
use Modules\Base\Services\Rows\Interfaces\Component;

abstract class Base implements Component
{
    use HasName;
    use HasLabel;
    use HasDefault;
    use HasRoles;
    use HasPlaceholder;
    use HasHint;
    use HasTab;
    use HasReactiveBy;
    use HasType;
    use HasColor;
    use HasDescription;
    use HasID;
    use HasMax;
    use HasMin;
    use HasMedia;
    use HasModel;
    use HasQuery;
    use HasRelation;
    use HasTrack;
    use HasValidation;
    use HasOptions;
    use HasTrack;
    use HasValidation;
    use IsMulti;
    use IsOver;
    use IsDisabled;
    use IsRequired;
    use IsUnique;
    use IsReactive;
    use IsSearchable;
    use IsSortable;
}
