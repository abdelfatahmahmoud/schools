<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use App\Repository\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    protected $student;

    public function __construct(StudentRepositoryInterface $student)
    {
        $this->student = $student;
    }

    public function index()
    {

        return  $this->student->Get_Student();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->student->Create_Student();
    }


    public function store(StoreStudentRequest $request)
    {


          return $this->student->Store_Student($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        return $this->student->Show_Student($id);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->student->Edit_Student($id);
    }

    public function update(StoreStudentRequest $request)
    {
        return $this->student->Update_Student($request);
    }




    public function destroy(Request $request)
    {
        return $this->student->Delete_Student($request);
    }


    public function Get_classrooms($id)
    {
        return $this->student->Get_classrooms($id);
    }

    public function Get_Sections($id)
    {
        return $this->student->Get_Sections($id);
    }

    public function Upload_attachment(Request $request)
    {
        return $this->student->Upload_attachment($request);
    }

    public function Download_attachment($studentsname,$filename)
    {
        return $this->student->Download_attachment($studentsname,$filename);
    }

    public function Delete_attachment(Request $request)
    {
        return $this->student->Delete_attachment($request);

    }


    public function Graduated(Request $request)
    {
      //  $students = Student::where('Grade_id',$request->Grade_id)->where('Classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->get();

       Student::where('id', $request->id)->Delete();

        toastr()->success(trans('messages.success'));
        return redirect()->route('Graduated.index');
    }


}
