<?php

namespace GameapModules\Fastdl\Models;

use Gameap\Models\DedicatedServer;
use Gameap\Models\Server;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FastdlServer
 * @package GameapModules\Fastdl\Models
 *
 * @property integer $id
 * @property integer $ds_id
 * @property integer $server_id
 * @property string $address
 * @property string $last_sync
 * @property boolean $remote
 * @property string $created_at
 * @property string $updated_at
 *
 */
class FastdlServer extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ds_id',
        'server_id',
        'address',
        'last_sync',
        'remote',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'ds_id' => 'integer',
        'server_id' => 'integer',
        'address' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dedicatedServer()
    {
        return $this->belongsTo(DedicatedServer::class, 'ds_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fastdlDs()
    {
        return $this->belongsTo(FastdlDs::class, 'ds_id', 'ds_id');
    }
}
