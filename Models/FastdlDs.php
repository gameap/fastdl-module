<?php

namespace GameapModules\Fastdl\Models;

use Gameap\Models\DedicatedServer;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FastdlDs
 * @package GameapModules\Fastdl\Models
 *
 * @property integer $ds_id
 * @property boolean $installed
 * @property string $method
 * @property string $host
 * @property integer $port
 * @property boolean $autoindex
 * @property string $options
 *
 * @property FastdlServer[] $accounts
 */
class FastdlDs extends Model
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'ds_id';

    protected $fillable = [
        'ds_id',
        'installed',
        'method',
        'host',
        'port',
        'autoindex',
        'options',
    ];

    protected $casts = [
        'ds_id' => 'integer',
        'installed' => 'boolean',
        'method' => 'string',
        'host' => 'string',
        'port' => 'integer',
        'autoindex' => 'boolean',
        'options' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dedicatedServer()
    {
        return $this->belongsTo(DedicatedServer::class, 'ds_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(FastdlServer::class, 'ds_id', 'ds_id');
    }
}
