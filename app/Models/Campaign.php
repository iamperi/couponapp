<?php

namespace App\Models;

use App\Events\CampaignCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['starts_at', 'ends_at'];

    protected $dispatchesEvents = [
        'created' => CampaignCreated::class
    ];

    public function setPrefixAttribute($value)
    {
        $this->attributes['prefix'] = strtoupper($value);
    }

    public function setStartsAtAttribute($value)
    {
        $this->attributes['starts_at'] = Carbon::createFromFormat('d/m/Y H:i', $value);
    }

    public function setEndsAtAttribute($value)
    {
        if(!empty($value)) {
            $this->attributes['ends_at'] = Carbon::createFromFormat('d/m/Y H:i', $value);
        }
    }

    public function scopeActive($query)
    {
        return $query->whereNull('ends_at')->orWhere('ends_at', '>=', Carbon::now());
    }

    public function isActive()
    {
        if(is_null($this->ends_at) || $this->ends_at >= Carbon::now()) {
            return true;
        }
        return false;
    }
}
