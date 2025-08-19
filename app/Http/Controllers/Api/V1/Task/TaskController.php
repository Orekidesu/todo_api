<?php

namespace App\Http\Controllers\Api\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Task\StoreTaskRequest;
use App\Http\Requests\Api\V1\Task\UpdateTaskRequest;
use App\Http\Resources\Api\V1\Task\TaskResource;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $this->authorize('viewAny', Task::class);

            $tasks = auth()->user()->tasks()->with('category')->get();

            return TaskResource::collection($tasks)->additional([
                'message' => 'tasks retrieved successfully'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'message' => 'failed to retrieve tasks',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        //
        try {

            $this->authorize('create', Task::class);
            $task = Task::create([
                'title' => $request->validated()['title'],
                'description' => $request->validated()['description'],
                'due_date' => $request->validated()['due_date'],
                'is_completed' => $request->validated()['is_completed'],
                'category_id' => $request->validated(['category_id']),
                'user_id' => auth()->id(),
            ]);

            $task->user_id = auth()->id();

            return (new TaskResource($task->load('category')))->additional([
                'message' => 'task created successfully',
            ]);
        } catch (Exception $e) {

            return response()->json([
                'message' => 'failed to create task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
        try {
            $this->authorize('view', $task);

            return (new TaskResource($task->load('category')))->additional([
                'message' => 'task retrieved successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'failed to create task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
        try {
            $this->authorize('update', $task);

            $task->update($request->validated());

            return (new TaskResource($task->load('category')))->additional([
                'message' => 'task updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'failed to create task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        try {
            $this->authorize('delete', $task);

            $task->delete();

            return response()->json([
                'message' => 'task deleted successfuylly',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'failed to delete task',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
