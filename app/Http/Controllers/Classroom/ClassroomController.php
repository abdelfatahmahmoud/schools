<?php



namespace App\Http\Controllers\Classroom;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClass;
use App\models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;


class ClassroomController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

      $Grades = Grade::all();
      $Classs = Classroom::all();
      return view('pages.My_Classes.classroom',compact('Grades','Classs'));

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
    public function store(StoreClass $request)
    {

        $List_Classes = $request->List_Classes;

        try {

            $validate = $request->validated();
            foreach ($List_Classes as $List_Class) {

                $My_Classes = new Classroom();

                $My_Classes->Name_Class = ['en' => $List_Class['Name_class_en'], 'ar' => $List_Class['Name']];

                $My_Classes->Gardes_id = $List_Class['Grade_id'];

                $My_Classes->save();

            }

            toastr()->success(trans('messages.success'));
            return redirect()->route('classroom.index');
        } catch (\Exception $e) {
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
  public function update(Request $request)
  {
try {

     //  $validate = $request->validated();
    $My_Classes = Classroom::findOrFail($request->id);
    $My_Classes->update([
    $My_Classes->Name_Class =['ar' => $request->Name, 'en' => $request->Name_en],
    $My_Classes->Gardes_id   = $request->Grade_id,

    ]);

          toastr()->success(trans('messages.success'));
          return redirect()->route('classroom.index');

      } catch(\Exception $e) {
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
      $My_Classes = Classroom::findOrFail($request->id)->Delete();
      toastr()->danger(trans('messages.Delete'));
      return redirect()->route('classroom.index');

  }


    public function delete_all(Request $request)
    {

        $delete_all_id = explode(",", $request->delete_all_id);
        Classroom::whereIn('id', $delete_all_id)->Delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('classroom.index');

    }

    public function Filter_Classes(Request $request)
    {
        $Grades = Grade::all();
        $Search = Classroom::select('*')->where('Gardes_id','=',$request->Grade_id)->get();
        return view('pages.My_Classes.Classroom',compact('Grades'))->withDetails($Search);

    }

}

?>
