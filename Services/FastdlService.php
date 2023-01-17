<?php

namespace GameapModules\Fastdl\Services;

use Gameap\Models\GdaemonTask;
use Gameap\Services\GdaemonCommandsService;
use GameapModules\Fastdl\Models\FastdlDs;
use GameapModules\Fastdl\Models\FastdlServer;
use Knik\Gameap\GdaemonCommands;

class FastdlService extends GdaemonCommandsService
{
    const FASTDL_INSTALL_COMMAND = 'get-tool https://raw.githubusercontent.com/gameap/scripts/master/fastdl/fastdl.sh';

    const CREATE_ACCOUNT_CMD = '{node_tools_path}/fastdl.sh add';
    const REMOVE_ACCOUNT_CMD = '{node_tools_path}/fastdl.sh remove';
    const INSTALL_REQUIREMENTS_CMD = '{node_tools_path}/fastdl.sh install';
    const SYNC_CMD = '{node_tools_path}/fastdl.sh sync';

    public function addAccount(FastdlServer $fastdlServer, ?int &$exitCode = null): string
    {
        $this->configureGdaemon($fastdlServer->ds_id);

        $command = $this->generateCommand(self::CREATE_ACCOUNT_CMD, $fastdlServer);

        return $this->gdaemonCommands->exec($command, $exitCode);
    }

    public function deleteAccount(FastdlServer $fastdlServer, ?int &$exitCode = null): string
    {
        $this->configureGdaemon($fastdlServer->ds_id);

        $command = $this->generateCommand(self::REMOVE_ACCOUNT_CMD, $fastdlServer);

        return $this->gdaemonCommands->exec($command, $exitCode);
    }

    public function install(FastdlDs $fastdlDs): int
    {
        $this->configureGdaemon($fastdlDs->ds_id);

        $getTask = GdaemonTask::create([
            'run_aft_id' => 0,
            'dedicated_server_id' => $fastdlDs->ds_id,
            'task' => GdaemonTask::TASK_CMD_EXEC,
            'cmd' => self::FASTDL_INSTALL_COMMAND,
        ]);

        $installRequirementsCmd = $this->addCommandOptions(self::INSTALL_REQUIREMENTS_CMD, $fastdlDs);
        $installTask = GdaemonTask::create([
            'run_aft_id' => 0,
            'dedicated_server_id' => $fastdlDs->ds_id,
            'task' => GdaemonTask::TASK_CMD_EXEC,
            'cmd' => $installRequirementsCmd,
        ]);

        return $getTask->id;
    }

    public function startSync(FastdlDs $fastdlDs): int
    {
        $this->configureGdaemon($fastdlDs->ds_id);

        $syncCmd = $this->generateServiceCommand(self::SYNC_CMD, $fastdlDs);

        return GdaemonTask::create([
            'run_aft_id' => 0,
            'dedicated_server_id' => $fastdlDs->ds_id,
            'task' => GdaemonTask::TASK_CMD_EXEC,
            'cmd' => $syncCmd,
        ])->id;
    }

    private function generateCommand(string $command, FastdlServer $fastdlServer): string
    {
        $fastdlDs = $fastdlServer->fastdlDs;

        $options = collect($fastdlDs->options)->pluck('value', 'option');
        $options['server-path'] = $fastdlServer->server->full_path . '/' . $fastdlServer->server->game->start_code;
        $options['method'] = $fastdlDs->method;

        $cmdOptions = '';
        foreach ($options as $optionName => $optionValue) {
            $cmdOptions .= " --{$optionName}=\"{$optionValue}\"";
        }

        return $this->replaceShortCodes($fastdlServer->server, $command . $cmdOptions);
    }

    private function generateServiceCommand(string $command, FastdlDs $fastdlDs): string
    {
        $options = collect($fastdlDs->options)->pluck('value', 'option');
        $options['method'] = $fastdlDs->method;

        $cmdOptions = '';
        foreach ($options as $optionName => $optionValue) {
            $cmdOptions .= " --{$optionName}=\"{$optionValue}\"";
        }

        return $command . $cmdOptions;
    }

    private function addCommandOptions(string $command, FastdlDs $fastdlDs): string
    {
        $options = [
            'host' => $fastdlDs->host,
            'port' => $fastdlDs->port,
            'autoindex' => (int)$fastdlDs->autoindex,
        ];

        $cmdOptions = '';
        foreach ($options as $optionName => $optionValue) {
            $cmdOptions .= " --{$optionName}=\"{$optionValue}\"";
        }

        return $command . $cmdOptions;
    }

    private function replaceShortCodes(Server $server, string $command, array $extraData = []): string
    {
        foreach ($extraData as $key => $value) {
            $command = str_replace('{' . $key . '}', $value, $command);
        }

        $replaceArray = [
            'node_work_path'    => $server->dedicatedServer->work_path,
            'node_tools_path'   => $server->dedicatedServer->work_path . "/tools",
            'host'              => $server->server_ip,
            'port'              => $server->server_port,
            'query_port'        => $server->query_port,
            'rcon_port'         => $server->rcon_port,
            'dir'               => $server->full_path,
            'uuid'              => $server->uuid,
            'uuid_short'        => $server->uuid_short,
            'game'              => $server->game_id,
            'user'              => $server->su_user,
        ];

        foreach ($replaceArray as $key => $value) {
            $command = str_replace('{' . $key . '}', $value, $command);
        }

        return $command;
    }
}
