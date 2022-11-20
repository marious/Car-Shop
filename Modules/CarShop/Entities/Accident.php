<?php
namespace Modules\CarShop\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Accident extends Model implements HasMedia
{

    use InteractsWithMedia;

    protected $fillable = [
        'quotation_id', 'policy_num', 'accident_date', 'description', 'admin_note', 'compensation',
        'payment_way', 'account_num', 'check_num',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
