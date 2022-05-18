<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskStatus;

class TaskService
{
    protected Task $task;

    protected TaskStatus $taskStatuses;

    public function __construct(Task $task, TaskStatus $taskStatuses)
    {
        $this->task = $task;
        $this->taskStatuses = $taskStatuses;
    }


}
