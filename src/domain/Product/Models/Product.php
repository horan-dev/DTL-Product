<?php

namespace Domain\Product\Models;

use Auth;
use Domain\Client\Models\User;
use Spatie\ModelStates\HasStates;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Domain\Product\Observers\ProductObserver;
use Illuminate\Database\Eloquent\SoftDeletes;
use Database\Factories\Product\ProductFactory;
use Spatie\Activitylog\Facades\CauserResolver;
use Domain\Product\States\Product\ProductState;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use SoftDeletes, HasFactory, HasStates,LogsActivity;
    protected $table = 'products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'admin_id',
        'product_type',

    ];



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'string',
        'status' => ProductState::class,
        'admin_id' => 'int',
        'product_type' => 'string'

    ];


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public static function boot()
    {
        parent::boot();
        self::observe(ProductObserver::class);
    }


    public function getActivitylogOptions(): LogOptions
    {
        CauserResolver::setCauser(Auth::user());
        return LogOptions::defaults()
        ->logAll();;

    }

}
