<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getProjectList()
    {
        $data = [];
        $data['user_id'] = $this->request->post('user_id');
        $data['projects'] = Projects::where('user_id', $data['user_id'])->get();
        $data['total_projects'] = $data['projects']->count();
        $respHtml = view('project.listProjects', $data)->render();
        return response()->json([
            'status' => '1',
            'html' => $respHtml,
        ]);
    }

    public function saveProject()
    {
        try {
            $project = new Projects();
            $project->title = $this->request->post('title');
            $project->description = $this->request->post('description');
            $project->status = $this->request->post('status');
            $project->user_id = $this->request->post('user_id');
            $project->save();
            return response()->json([
                "status" => 1,
                "project" => $project
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 0
            ]);
        }
    }

    public function viewProject() {
        $data = [];
        $project_id = $this->request->post('project_id');
        $data['user_id'] = $this->request->post('user_id');
        try {
            $data['project'] = Projects::where('id', $project_id)->first();
            return response()->json([
                "status" => 1,
                "data" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 0
            ]);
        }
    }

    public function deleteProject() {

        $project_id = $this->request->post('project_id');
        try {
            Projects::where('id', $project_id)->firstOrFail()->delete();
            return response()->json([
                "status" => 1,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 0,
            ]);
        }
    }

    public function updateProject(){
        try {
            $project_id = $this->request->post('project_id');
            $project = Projects::findOrFail($project_id);
            $project->title = $this->request->post('title');
            $project->description = $this->request->post('description');
            $project->status = $this->request->post('status');
            $project->user_id = $this->request->post('user_id');
            $project->save();
            return response()->json([
                "status" => 1,
                "project" => $project
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 0,
                "message"=>$th->getMessage(),
            ]);
        }
    }
}
