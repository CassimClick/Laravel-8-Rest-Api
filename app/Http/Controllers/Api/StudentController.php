<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public $student;
    public $project;
    public function __construct()
    {
        $this->student = new Student();
        $this->project = new Project();

    }
    //=================Register student====================
    public function register(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:student',
            // 'mobile' => 'required',
            'password' => 'required|confirmed',
        ]);

        //create data

        $this->student->name = $request->name;
        $this->student->email = $request->email;
        $this->student->mobile = isset($request->mobile) ? $request->mobile : "";
        $this->student->password = Hash::make($request->password);

        $this->student->save();
        // $token = $this->student->createToken('auth-token')->plainTextToken;

        //send response
        return response()->json([
            'message' => 'Student Created Successfully',
            // 'token' => $token,

        ]);
    }
    //================= student Login====================
    public function login(Request $request)
    {
        //validation
        $request->validate([

            'email' => 'required|email',
            'password' => 'required',
        ]);

        // check student
        $student = $this->student->where('email', $request->email)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            return response()->json([
                'message' => 'Bad Credentials',

            ], 401);

        }

        $token = $student->createToken('auth-token')->plainTextToken;

        //send response
        return response()->json([
            'message' => 'Student Logged In Successfully',
            'token' => $token,

        ], 201);

    }
    //================= student Profile====================
    public function profile()
    {
        return response()->json([
            'message' => 'Student Logged In Successfully',
            'data' => auth()->user(),
        ]);
    }
    //================= student logout====================
    public function logout(Request $request)
    {
        // auth()->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged Out',

        ]);

    }
}