<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Tasks;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function projectTasks($project_id = null) {
        $data = [];
        $projects_arr = [];
        $data['heading'] = "All tasks";
        $data['project_id'] = 0;
        $data['user_id'] = Auth::user()->id;
        $data['projects'] = Projects::where('user_id', '=', $data['user_id'])->get();

        if($data['projects']->count() > 0){
            foreach($data['projects'] as $prj){
                $projects_arr[$prj->id] = $prj->title;
            }
        }
        $data['projects_json'] = json_encode($projects_arr);
        $data['projects_counter'] = $data['projects']->count();
        if($project_id !== null){
            try {
                $project = Projects::findOrfail($project_id);
                $data['project_id'] = $project_id;
                $data['heading'] = "Tasks under: {$project->title}";
            } catch (\Throwable $th) {
                return redirect()->route('home');
            }
        }
        return view('task.listTasks', $data);

    }

    public function getTaskList() {
        $data = [];
        $project_id = $this->request->post('project_id');
        $user_id = $this->request->post('user_id');
        $status = $this->request->post('status');
        try {
            if($project_id) {
                $data['tasks'] = Tasks::where([
                    ['project_id', '=', $project_id],
                    ['status', '=', $status] ])->orderBy('dead_line', 'asc')->get();
            } else {
                $data['tasks'] = Tasks::where([
                    ['user_id', '=', $user_id],
                    ['status', '=', $status] ])->orderBy('dead_line', 'asc')->get();
            }
            $data['task_count'] = $data['tasks']->count();
            $respHtml = view('task.listTasksByStatus', $data)->render();
            return response()->json([
                'status' => '1',
                'html' => $respHtml,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '0',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function storeTask(){
        $mode = $this->request->input('mode');
        if($mode == 'add'){
            try {
                $task = new Tasks();
                $task->project_id = $this->request->post('project_id');
                $task->title = $this->request->post('title');
                $task->description = $this->request->post('description');
                $task->user_id = $this->request->post('user_id');
                $task->priority_level = $this->request->post('priority_level');
                $task->dead_line = Carbon::createFromFormat('m/d/Y', $this->request->post('dead_line'))->toDateTimeString() ;
                $task->status = $this->request->post('status');
                $task->save();
                return response()->json([
                    'status' => '1',
                    'task' => $task,
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => '0',
                    'message' => $th->getMessage(),
                ]);
            }
        } elseif ($mode == 'edit') {
            try {
                $task = Tasks::where('id', $this->request->post('task_id'))->firstOrFail();
                $task->project_id = $this->request->post('project_id');
                $task->title = $this->request->post('title');
                $task->description = $this->request->post('description');
                $task->user_id = $this->request->post('user_id');
                $task->priority_level = $this->request->post('priority_level');
                $task->dead_line = Carbon::createFromFormat('m/d/Y', $this->request->post('dead_line'))->toDateTimeString() ;
                $task->status = $this->request->post('status');
                $task->save();
                return response()->json([
                    'status' => '1',
                    'task' => $task,
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => '0',
                    'message' => $th->getMessage(),
                ]);
            }
        }
    }


    public function getTaskInfo(){
        $task_id = $this->request->post('task_id');
        try {
            $task = Tasks::where('id',$task_id)->firstOrFail();
            return response()->json([
                'status' => '1',
                'task' => $task
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '0',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function deleteTask(){
        $id = $this->request->post('id');
        try {
            $task = Tasks::where('id', $id)->firstOrFail();
            $task->delete();
            return response()->json([
                'status' => '1',
                'message' => 'Task deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '0',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function viewTask($id){
        $data = [];
        try {
            $data['task'] = Tasks::with('project')->where('id', $id)->first();

            $data['comments'] = Comments::where('task_id', $id)->with('children')->get();
            $comment_arr = [];
            foreach($data['comments'] as $key => $comment){
                $temp_arr = [];
                if(!isset($comment_arr[$comment->id])){
                    $temp_arr['id'] = $comment->id;
                    $temp_arr['description'] = $comment->description;
                    $temp_arr['col'] = 12;
                    $comment_arr[$comment->id] = $temp_arr;
                }
                if($comment->children){
                    foreach($comment->children as $children){
                        if(!isset($comment_arr[$children->id]) ){
                            $temp_arr['id'] = $children->id;
                            $temp_arr['description'] = $children->description;
                            $temp_arr['col'] = $comment_arr[$children->parent_comment_id]['col'] - 1;
                            $comment_arr[$children->id] = $temp_arr;
                        }
                    }
                }
            }
            $data['comment_arr'] = $comment_arr;
            return view('task.viewTask', $data);
        } catch (\Throwable $th) {
            return redirect()->route('all-tasks-list');
        }


    }
}
