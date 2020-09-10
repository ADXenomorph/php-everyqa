<?php
declare(strict_types=1);

namespace EveryQACli\EveryQAApi;

use EveryQA\Client\Api\ActionApi;
use EveryQA\Client\Api\CasesApi;
use EveryQA\Client\Api\RunsApi;
use EveryQA\Client\Api\TestsApi;
use EveryQA\Client\Api\UsersApi;
use EveryQA\Client\ApiException;
use EveryQA\Client\Configuration;
use EveryQA\Client\Model\ActionAction;
use EveryQA\Client\Model\ExecutionExecution;
use EveryQA\Client\Model\ModelAddActionToTestDto;
use EveryQA\Client\Model\ModelCreateTestRunDto;
use EveryQA\Client\Model\TestcaseCase;
use EveryQA\Client\Model\TestrunTestRun;
use EveryQA\Client\Model\UserUser;
use GuzzleHttp\Client;

class EveryQA
{
    private Configuration $config;
    private Client $guzzle;

    public function __construct(Configuration $config, Client $guzzle)
    {
        $this->config = $config;
        $this->guzzle = $guzzle;
    }

    private function usersApi(): UsersApi
    {
        return new UsersApi($this->guzzle, $this->config);
    }

    private function casesApi(): CasesApi
    {
        return new CasesApi($this->guzzle, $this->config);
    }

    private function runsApi(): RunsApi
    {
        return new RunsApi($this->guzzle, $this->config);
    }

    private function testsApi(): TestsApi
    {
        return new TestsApi($this->guzzle, $this->config);
    }

    private function actionApi(): ActionApi
    {
        return new ActionApi($this->guzzle, $this->config);
    }

    public function getCurrentUser(): UserUser
    {
        return $this->usersApi()->user();
    }

    /**
     * @param string $projectId
     *
     * @return TestcaseCase[]
     * @throws ApiException
     */
    public function getCases(string $projectId): array
    {
        return $this->casesApi()->getAllCasesByProjectId($projectId);
    }

    /**
     * @param string $projectId
     *
     * @return TestrunTestRun[]
     * @throws ApiException
     */
    public function getRuns(string $projectId): array
    {
        return $this->runsApi()->getAllRunsByProjectId($projectId);
    }

    public function createRun(string $projectId, string $assignTo, string $name, string $sprintId): TestrunTestRun
    {
        $dto = new ModelCreateTestRunDto();
        $dto->setAssignTo($assignTo);
        $dto->setName($name);
        $dto->setSprintId($sprintId);

        return $this->runsApi()->createRun($projectId, $dto);
    }

    public function closeRun(string $projectId, int $runId): TestrunTestRun
    {
        return $this->runsApi()->closeRunById($projectId, $runId);
    }

    public function createTest(string $projectId, int $runId): ExecutionExecution
    {
        return $this->testsApi()->createTestByCaseId($projectId, $runId);
    }

    public function createTestAction(
        string $projectId,
        int $runId,
        int $testId,
        string $notes,
        int $statusId
    ): ActionAction {
        $dto = new ModelAddActionToTestDto();
        $dto->setNotes($notes);
        $dto->setStatusId($statusId);

        return $this->actionApi()->createActionByTestId($projectId, $runId, $testId, $dto);
    }
}

