<?php

namespace GameapModules\FastDl\Services;

use Gameap\Models\GdaemonTask;
use Gameap\Services\GdaemonCommandsService;
use GameapModules\FastDl\Models\FastdlDs;
use GameapModules\FastDl\Models\FastdlServer;
use Knik\Gameap\GdaemonCommands;

class FastdlService extends GdaemonCommandsService
{
    const FASTDL_SCRIPT_NAME = 'fastdl.sh';
    const FASTDL_SCRIPT_DOWNLOAD_LINK = 'https://raw.githubusercontent.com/gameap/scripts/master/fastdl/fastdl.sh';

    const CREATE_ACCOUNT_CMD = './fastdl.sh add';
    const REMOVE_ACCOUNT_CMD = './fastdl.sh remove';
    const INSTALL_REQUIREMENTS = './fastdl.sh install';

    /**
     * @var GdaemonCommands
     */
    protected $gdaemonCommands;

    /**
     * @param FastdlServer $fastdlServer
     * @param integer $exitCode
     * @return string
     */
    public function addAccount(FastdlServer $fastdlServer, &$exitCode = null)
    {
        $this->configureGdaemon($fastdlServer->ds_id);

        $command = $this->generateCommand(self::CREATE_ACCOUNT_CMD, $fastdlServer);

        return $this->gdaemonCommands->exec($command, $exitCode);
    }

    /**
     * @param FastdlServer $fastdlServer
     * @param integer $exitCode
     * @return string
     */
    public function deleteAccount(FastdlServer $fastdlServer, &$exitCode = null)
    {
        $this->configureGdaemon($fastdlServer->ds_id);

        $command = $this->generateCommand(self::REMOVE_ACCOUNT_CMD, $fastdlServer);

        return $this->gdaemonCommands->exec($command, $exitCode);
    }

    /**
     * @param FastdlDs $fastdlDs
     * @return integer
     */
    public function install(FastdlDs $fastdlDs)
    {
        $this->configureGdaemon($fastdlDs->ds_id);

        $installRequirementsCmd = $this->generateInstallCommand(self::INSTALL_REQUIREMENTS, $fastdlDs);

        $executeCommand = 'curl -O ' . self::FASTDL_SCRIPT_DOWNLOAD_LINK
            . ' && ' . 'chmod +x ' . self::FASTDL_SCRIPT_NAME
            . ' && ' . $installRequirementsCmd;

        return GdaemonTask::create([
            'run_aft_id' => 0,
            'dedicated_server_id' => $fastdlDs->ds_id,
            'task' => GdaemonTask::TASK_CMD_EXEC,
            'cmd' => $executeCommand,
        ])->id;
    }

    /**
     * @param string $command
     * @param FastdlServer $fastdlServer
     * @return string
     */
    private function generateCommand(string $command, FastdlServer $fastdlServer)
    {
        $fastdlDs = $fastdlServer->fastdlDs;

        $options = $fastdlDs->options;
        $options['server-path'] = $fastdlServer->server->full_path . '/' . $fastdlServer->server->game->start_code;
        $options['method'] = $fastdlDs->method;

        $cmdOptions = '';
        foreach ($options as $optionName => $optionValue) {
            $cmdOptions .= " --{$optionName}=\"{$optionValue}\"";
        }

        return $command . $cmdOptions;
    }

    /**
     * @param string $command
     * @param FastdlDs $fastdlDs
     * @return string
     */
    private function generateInstallCommand(string $command, FastdlDs $fastdlDs)
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
}