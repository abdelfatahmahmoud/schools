<?php

namespace App\Http\Controllers\Grades;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
      $grades = Grade::all();

    return view('pages.Grades.Grades',compact('grades'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(StoreRequest $request)
  {
      try {



          $validate = $request->validated();

          $grade =new Grade();
          $grade->Name = ['en' => $request->Name_en, 'ar' => $request->Name];

          $grade->Notes = $request->Notes;

          $grade->save();

          toastr()->success(trans('messages.success'));

          return redirect()->route('Grades.index');

      } catch(\Exception $e) {
          return redirect()->back()->withErrors(['error' => $e->getMessage()]);
      }

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
    public function update(StoreRequest $request)
    {
     //   if (Grade::where('Name->ar', $request->Name)->orWhere('Name->en',$request->Name_en)->exists()) {
        //    return redirect()->back()->withErrors(trans('grades_trans.exists'));}

        try {

            $validated = $request->validated();
            $grade = Grade::findOrFail($request->id);
            $grade->update([
                $grade->Name = ['ar' => $request->Name, 'en' => $request->Name_en],
                $grade->Notes = $request->Notes,
            ]);

            toastr()->success(trans('messages.Update'));
            return redirect()->route('Grades.index');
        }

      catch (\Exception $e) {
       return redirect()->back()->withErrors(['error' => $e->getMessage()]);
      }

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
      public function destroy(Request $request)
  {
      $myclasses = Classroom::where('Gardes_id',$request->id)->pluck('Gardes_id');
if ($myclasses->count()==0) {
    $grade = Grade::findOrFail($request->id)->Delete();
    toastr()->success(trans('messages.Delete'));
    return redirect()->route('Grades.index');
}
else
    {
    toastr()->error(trans('grades_trans.delete_Grade_Error'));
    return redirect()->route('Grades.index');
}

  }

}

?>
