<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskPutRequest;
use App\Http\Requests\TaskRequest;
use App\Models\TaskType;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Task;

class ApiTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request) {
        if ($request->query('TypeList')) {
            $listId = $request->query('TypeList', 'AllTasks');
            $tasks = $this->filterTasks($listId, $request->user());
        }
        else {
            $tasks = Task::where('user_id', $request->user()->id)->get();
        }

        return response()->json([
            'success' => true,
            'data' => $tasks,
            'user' => $request->user()
        ], 200);
    }


    private function filterTasks($list_id, $user, $date=null) {
        if ($list_id == 0) {
            return Task::where('user_id', $user->id)->get();
        }
        elseif ($list_id == 1) {
            $nowDate = new DateTime('now');
            return Task::where('date', '>=', $nowDate)->where('done', false)->where('user_id', $user->id)->get();
        }
        elseif ($list_id == 2) {
            return Task::where('done', true)->where('user_id', $user->id)->get();

        }
        elseif ($list_id == 3) {
            $dateToLost = new DateTime('now');
            return Task::where('done', false, 'date')->where('date', '<', $dateToLost)->where('user_id', $user->id)->get();

        }
        elseif ($list_id == 4) {
            if ($date == null)
                return [];
            $currentDate = DateTime::createFromFormat("d.m.Y", $date);
            return Task::where('date', '=', $currentDate)->where('user_id', $user->id)->get();

        }
        else {
            return [];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TaskRequest  $request
     * @return JsonResponse
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $taskType = TaskType::where('name', $data['type_name'])->first();
        $data['type_id'] = $taskType->id;
        $data['user_id'] = $request->user()->id;
        $new_task = Task::create($data);
        return response()->json([
            'success' => true,
            'data' => $new_task
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function show(Request $request, $id)
    {
        $task = Task::where('id', $id)->first();

        if ($request->user()->id != $task->user->id) {
            return response()->json([
                'success' => false,
                'errors' => "you do not have permissions"
            ], 403);
        }

        return response()->json([
                'success' => true,
                'data' => Task::where('id', $id)->first()
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskPutRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TaskPutRequest $request, int $id)
    {
        $task = Task::where('id', $id)->first();

        if ($request->user()->id != $task->user->id) {
            return response()->json([
                'success' => false,
                'errors' => "you do not have permissions"
            ], 403);
        }

        if (isset($task)) {
            try {

                $data = $request->validated();
                if (isset($data['type_name'])) {
                    $taskType = TaskType::where('name', $data['type_name'])->first();
                    $data['type_id'] = $taskType->id;
                }


                $task->update($data);
            }
            catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'errors' => $e
                ], 422);
            }
            return response()->json([
                'success' => true,
                'data' => Task::where('id', $id)->first()
            ], 201);
        }
        else {
            return response()->json([
                'success' => false,
                'errors' => 'Task not found'
            ], 402);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(Request $request, $id)
    {

        $task = Task::where('id', $id)->first();

        if ($request->user()->id != $task->user->id) {
            return response()->json([
                'success' => false,
                'errors' => "you do not have permissions"
            ], 403);
        }

        $task->delete();
        return response()->json([
            'success' => true,
            'data' => "ok"
        ], 203);
    }
}
