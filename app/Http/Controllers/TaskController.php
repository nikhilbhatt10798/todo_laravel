<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(){
        $task = Task::orderBy('id', 'DESC')->where('status','Pending')->get();
        return view('index',compact('task'));
    }

    public function addTask(Request $request){
        $data= $request->all();
        unset($data['_token']);
        $create = Task::create($data);
        if($create){
            $data = Task::orderBy('id', 'DESC')->where('status','Pending')->get();
            return [
                'data'=>$data,
                'status'=>"success"
            ];
        }else{
            return [
            "status"=>"error"
            ];
        }
    }
    public function delete(Request $request){
        $id = $request->id;
        $del = Task::where('id',$id)->delete();
        if($del){
            $data = Task::orderBy('id', 'DESC')->where('status','Pending')->get();
            return [
                'data'=>$data,
                'status'=>"success"
            ];
        }else{
            return [
                "status"=>"error"
                ];
        }
    }

    public function showAllTask(Request $request){
        $data = Task::orderByDesc('id')->get();
        if($data){
            return [
                'data'=>$data,
                'status'=>"success"
            ];
        }else{
            return [
                "status"=>"error"
                ];
        }
    }
    public function completeTask(Request $request){
        $id = $request->id;
        $status = Task::where('id',$id)->update(['status'=>"Complete"]);
        if($status){
        $data = Task::orderBy('id', 'DESC')->where('status','Pending')->get();
        return [
            'data'=>$data,
            'status'=>"success"
        ];
        }else{
            return [
                "status"=>"error"
                ];
        }
    }
}
