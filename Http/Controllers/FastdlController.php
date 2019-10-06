<?php

namespace GameapModules\FastDl\Http\Controllers;

use Gameap\Models\DedicatedServer;
use GameapModules\FastDl\Http\Requests\FastdlDsRequest;
use GameapModules\FastDl\Models\FastdlDs;
use GameapModules\FastDl\Repository\FastdlDsRepository;
use GameapModules\FastDl\Services\FastdlService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Gameap\Http\Controllers\AuthController;
use Gameap\Repositories\DedicatedServersRepository;

class FastdlController extends AuthController
{
    /**
     * @var FastdlDsRepository
     */
    protected $fastdlDsRepository;

    /**
     * @var FastdlService
     */
    protected $fastdlService;

    /**
     * FastDlController constructor.
     * @param DedicatedServersRepository $dedicatedServersRepository
     * @param FastdlDsRepository $fastdlDsRepository
     */
    public function __construct(FastdlDsRepository $fastdlDsRepository, FastdlService $fastdlService)
    {
        parent::__construct();

        $this->fastdlDsRepository = $fastdlDsRepository;
        $this->fastdlService = $fastdlService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $fastdlDedicatedServers = $this->fastdlDsRepository->getList();
        return view('fastdl::list', compact('fastdlDedicatedServers'));
    }

    /**
     * Show the specified resource.
     * @param FastdlDs $fastdlDs
     * @return Response
     */
    public function show(FastdlDs $fastdlDs)
    {
        if (!$fastdlDs->installed) {
            return redirect()->route('admin.fastdl.edit', route('id'));
        }

        return view('fastdl::show', compact('fastdlDs'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        $dedicatedServer = DedicatedServer::findOrFail($id);
        $fastdlDs = $this->fastdlDsRepository->get($id);
        return view('fastdl::edit', compact('dedicatedServer', 'fastdlDs'));
    }

    /**
     * Save the specified resource in storage.
     * @param FastdlDsRequest $request
     * @param int $id
     * @return Response
     */
    public function save(FastdlDsRequest $request, int $id)
    {
        $attributes = $request->all();

        $dedicatedServer = DedicatedServer::findOrFail($id);
        $fastdlDs = $this->fastdlDsRepository->get($dedicatedServer->id);

        $attributes['autoindex'] = isset($attributes['autoindex']);

        if ($fastdlDs === null) {
            $fastdlDs = FastdlDs::create(array_merge(['ds_id' => $id, 'installed' => true], $attributes));
            $gdaemonTaskId = $this->fastdlService->install($fastdlDs);
        } else {
            $fastdlDs->update($request->all());
        }

        return redirect()->route('admin.fastdl')
            ->with('success', __('main.success'));
    }
}
