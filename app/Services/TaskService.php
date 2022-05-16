<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskStatuses;

class TaskService
{
    protected Task $task;

    protected TaskStatuses $taskStatuses;

    public function __construct(Task $task, TaskStatuses $taskStatuses)
    {
        $this->task = $task;
        $this->taskStatuses = $taskStatuses;
    }


}
