<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public $project;
    public function __construct()
    {
        $this->project = new Project();

    }
    //=================Create Project====================
    public function createProject(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'duration' => 'required',

        ]);

        //get student id and create data
        $studentId = auth()->user()->id;

        $this->project->studentId = $studentId;
        $this->project->name = $request->name;
        $this->project->desc = $request->desc;
        $this->project->duration = $request->duration;

        $this->project->save();

        //send response

        return response()->json([
            'message' => 'Project Added',
        ]);
    }
    //=================List Project by Student id====================
    public function litProjects()
    {
        $studentId = auth()->user()->id;
        $projects = $this->project->where('studentId', $studentId)->get();
        return response()->json([
            'data' => $projects,
        ]);

    }
    //================= Project Details====================
    public function projectDetails($id)
    {

        if ($this->project->where([
            'id' => $id,
            'studentId' => auth()->user()->id,
        ])->exists()) {
            return response()->json([
                'status' => 1,
                'data' => $this->project->where('projects.id', $id)
                    ->select('student.name',
                        'email',
                        'projects.name as project',
                        'desc',
                        'duration',
                    )
                    ->join('student', 'projects.studentId', '=', 'student.id')
                    ->get(),
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'project Does not exist',
            ]);

        }
    }
    //================= Project Delete====================
    public function deleteProject($id)
    {
        $params = ['id' => $id,
            'studentId' => auth()->user()->id];

        if ($this->project->where(['id' => $id,
            'studentId' => auth()->user()->id])->exists()) {

            $project = $this->project->where(['id' => $id,
                'studentId' => auth()->user()->id])->first();
            $project->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Project Deleted',
            ]);

        } else {
            return response()->json([
                'status' => 0,
                'message' => 'project Does not exist',
            ]);

        }
    }
}