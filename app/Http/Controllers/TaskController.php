<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\TaskRequest;


class TaskController extends Controller
{
    public function index(Request $request){
       
        $projects = Project::all();
        $selected = null;
        if($request->query('project')){
            $selected = Project::findorFail($request->query('project'));
            $tasks = $selected->tasks()->orderBy('priority','ASC')->orderBy('id','DESC')->get();
        }else{
            $tasks = Task::with('project')->orderBy('priority','ASC')->orderBy('id','DESC')->get();
        }
        return view('home',compact('tasks','projects','selected'));
    }

    public function create(){
        $projects = Project::all();
        return view('create',compact('projects'));
    }

    public function store(TaskRequest $request){
        try{
            $task = Task::create([
                'name'=>$request->name,
                'priority'=>$request->priority,
                'project_id'=>$request->project
            ]);
    
            return redirect()->route('tasks.index')->with('success', "Task added successfully!");
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong');   
        }
       
    }

    public function edit(Task $task){
        $projects = Project::all();
        return view('edit',compact('task','projects'));
    }

    public function update(TaskRequest $request, Task $task){
        try{
            $task->update([
                'name'=>$request->name,
                'priority'=>$request->priority,
                'project_id'=>$request->project,
            ]);
            $task->save();
            return redirect()->route('tasks.index')->with('success', "Task updated successfully!");
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong');   
        }
       
    }

    public function delete(Task $task){
        try{
            $task->delete();
            return redirect()->route('tasks.index')->with('success', "Task deleted successfully!");
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong');   
        }

    }

    public function updatePriority(Request $request){
        $order = $request->order;
        foreach($order as $index=>$item){
            $task = Task::findorFail($item);
            $task->priority = $index + 1;$task->save();
        }
        return response()->json(['success'=>'Priority Successfully updated!']);
    }
}