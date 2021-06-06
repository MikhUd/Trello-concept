<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Desk;
class TaskController extends Controller
{
    public function getTasks($id){
        $desk = Desk::find($id);
        return $desk->tasks();
    }
    public function createTask(Request $request, $id){
        $task = new Task($request->all());
        $task->save();
        
        return $this->getTasks($id);
    }

    public function changeDesk(Request $request, $id){
        
        $task = Task::find($request['id']);
        $task->update($request->all());
        
        return $task;
    }

    public function deleteTask(Request $request){
        $task = Task::find($request['id']);
        $task->delete();
    }

    public function doneTask(Request $request){
        $task = Task::find($request['id']);

        if(!$task['is_done']){
            $task['is_done'] = 1;  
        }else{
            $task['is_done'] = 0;
        }
        $task->save();
        return $task;
    }
}
