<?php

namespace GameapModules\FastDL\Http\Controllers;

use Gameap\Repositories\ServerRepository;
use GameapModules\FastDl\Http\Requests\FastdlAccountRequest;
use GameapModules\FastDl\Models\FastdlDs;
use GameapModules\FastDl\Models\FastdlServer;
use GameapModules\FastDl\Services\FastdlService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class FastdlAccountsController extends Controller
{
    const EXEC_SUCCESS_CODE = 0;

    const AVAILABLE_ENGINES = [
        'goldsource',
        'source',
    ];

    /**
     * @var ServerRepository
     */
    protected $serverRepository;

    /**
     * @var FastdlService
     */
    protected $fastdlService;

    /**
     * FastdlAccountsController constructor.
     * @param ServerRepository $serverRepository
     */
    public function __construct(ServerRepository $serverRepository, FastdlService $fastdlService)
    {
        $this->serverRepository = $serverRepository;
        $this->fastdlService = $fastdlService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function list(int $id)
    {
        $fastdlDs = FastdlDs::find($id);

        if (!$fastdlDs) {
            return redirect()->route('admin.fastdl.edit', $id);
        }

        return view('fastdl::accounts.list', compact('fastdlDs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FastdlDs $fastdlDs)
    {
        $gameServers = $this->serverRepository
            ->getServersForEngine(
                self::AVAILABLE_ENGINES,
                [$fastdlDs->ds_id],
                $fastdlDs->accounts->pluck('server_id')
            );

        return view('fastdl::accounts.create',
            compact('fastdlDs', 'gameServers')
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(FastdlAccountRequest $request, FastdlDs $fastdlDs)
    {
        $attributes = $request->all();

        $attributes['ds_id'] = $fastdlDs->ds_id;
        $attributes['address'] = $fastdlDs->host . ($fastdlDs->port != 80 ? ':' . $fastdlDs->port : '');
        $attributes['remote'] = false;

        $fastdlServer = new FastdlServer($attributes);

        $result = $this->fastdlService->addAccount($fastdlServer, $exitCode);

        $resultExpl = explode(':', $result);

        if ($exitCode === self::EXEC_SUCCESS_CODE) {
            $fastdlServer->save();
        }

        return ($exitCode === self::EXEC_SUCCESS_CODE)
            ? redirect()->route('admin.fastdl.accounts', $fastdlDs->ds_id)->with('success', 'Success')
            : redirect()->route('admin.fastdl.accounts', $fastdlDs->ds_id)->with('error', 'Fail');
    }

    /**
     * Show the specified resource.
     * @param FastdlServer $fastdlServer
     * @return Response
     */
    public function show(FastdlServer $fastdlServer)
    {
        return view('fastdl::accounts.show', compact('fastdlServer'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FastdlServer $fastdlServer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(FastdlServer $fastdlServer)
    {
        $result = $this->fastdlService->deleteAccount($fastdlServer, $exitCode);

        if ($exitCode === self::EXEC_SUCCESS_CODE) {
            $fastdlServer->delete();
        }

        return ($exitCode === self::EXEC_SUCCESS_CODE)
            ? redirect()->route('admin.fastdl.accounts', $fastdlServer->ds_id)->with('success', 'Success')
            : redirect()->route('admin.fastdl.accounts', $fastdlServer->ds_id)->with('error', 'Fail');
    }
}
