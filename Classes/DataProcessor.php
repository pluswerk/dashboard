<?php

declare(strict_types=1);

namespace Pluswerk\Dashboard;

use stdClass;

final class DataProcessor
{
    private $jsonContainerData;
    private $processedData = [];

    public function __construct()
    {
        $this->jsonContainerData = json_decode(shell_exec('sudo docker inspect $(sudo docker ps -qa)'));
    }

    private function getVirtualHostEnvVariable(stdClass $container): array
    {
        return preg_grep('/VIRTUAL_HOST=.*$/', $container->Config->Env);
    }

    private function processVirtualHostEnvVariable(array $envVariableArray): array
    {
        $virtualHostArray = [];
        if (!empty($envVariableArray)) {
            $virtualHostEnv = $envVariableArray[0];
            $virtualHosts = explode('=', $virtualHostEnv)[1];
            $virtualHostArray = explode(',', $virtualHosts);
        }
        return $virtualHostArray;
    }

    public function process(): array
    {
        foreach ($this->jsonContainerData as $container) {
            $virtualHostsEnvArray = $this->getVirtualHostEnvVariable($container);
            $virtualHosts = $this->processVirtualHostEnvVariable($virtualHostsEnvArray);
            $dataEntry = ['name' => $container->Name, 'domains' => $virtualHosts];
            $this->processedData[] = $dataEntry;
        }
        return $this->processedData;
    }
}
