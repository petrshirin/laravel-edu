<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskType;

class ListTaskController extends Controller
{
    public function render(Request $request) {
        $query = $request->query();
        if (isset($query['listType'])){
            $tasks = Task::all();

        }
        else {
            $tasks = Task::where('user_id', $request->user()->id)->get();
        }
        return view('homeList', array("tasks" => $tasks,
            "listHeader" => "Список заданий",
            "taskTypes" => TaskType::all()
        ));
    }
}
