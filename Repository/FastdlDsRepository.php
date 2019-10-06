<?php

namespace GameapModules\FastDl\Repository;

use Gameap\Models\DedicatedServer;
use Gameap\Repositories\Repository;
use GameapModules\FastDl\Models\FastdlDs;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FastdlDsRepository extends Repository
{
    /**
     * @var DedicatedServer
     */
    protected $dedicatedServer;

    /**
     * FastdlDsRepository constructor.
     *
     * @param FastdlDs $fastdlDs
     * @param DedicatedServer $dedicatedServer
     */
    public function __construct(FastdlDs $fastdlDs, DedicatedServer $dedicatedServer)
    {
        $this->model = $fastdlDs;
        $this->dedicatedServer = $dedicatedServer;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->where($this->model->getKeyName(), $id)->get()->first();
    }

    /**
     * @return Collection
     */
    public function getList()
    {
        $allDedicatedServers = $this->dedicatedServer->select('id', 'name')->get();
        $installedFastdlDedicatedServers = $this->model->select($this->model->getKeyName())->where(['installed' => true])->get()->pluck('ds_id');

        $list = collect();

        foreach ($allDedicatedServers as $dedicatedServer) {
            $list->add([
                'id' => $dedicatedServer->id,
                'name' => $dedicatedServer->name,
                'installed' => $installedFastdlDedicatedServers->contains($dedicatedServer->id),
            ]);
        }

        return $list;
    }
}