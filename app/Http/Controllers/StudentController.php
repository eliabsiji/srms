<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Broadsheet;
use App\Models\Schoolterm;
use App\Models\Schoolclass;
use App\Models\Studentclass;
use App\Models\Studenthouse;
use Illuminate\Http\Request;
USE App\Models\Promotionstatus;
use App\Models\Schoolsession;
use App\Models\Studentpicture;
use App\Imports\StudentsImport;
use App\Models\ParentRegistration;
use App\Models\StudentBatchModel;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Studentpersonalityprofile;

use App\Models\SubjectRegistrationStatus;
use Illuminate\Support\Facades\Validator;
use App\Traits\ImageManager as TraitsImageManager;


class StudentController extends Controller
{

    use TraitsImageManager;

    function __construct()
    {
         $this->middleware('permission:student-list|student-create|student-edit|student-delete', ['only' => ['index','store']]);
         $this->middleware('permission:student-create', ['only' => ['create','store']]);
         $this->middleware('permission:student-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:student-delete', ['only' => ['destroy','deletestudent']]);
         $this->middleware('permission:student_bulk-upload', ['only' => ['bulkupload']]);
         $this->middleware('permission:student_bulk-uploadsave', ['only' => ['bulkuploadsave']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //


        $student = Student::leftJoin('parentRegistration', 'parentRegistration.id','=','studentRegistration.id')
                         ->leftJoin('studentpicture','studentpicture.studentid','=','studentRegistration.id')
                         ->leftJoin('studenthouses','studenthouses.studentid','=','studentRegistration.id')
                         ->leftJoin('schoolhouses','schoolhouses.id','=','studenthouses.schoolhouse')
                        ->get(['studentRegistration.id as id','studentRegistration.admissionNo as admissionNo','studentRegistration.registeredBy as registeredBy',
                               'studentRegistration.firstname as firstname','schoolhouses.house as house',
                              'studentRegistration.lastname as lastname','studentRegistration.dateofbirth as dateofbirth','studentRegistration.age as age',
                              'studentRegistration.gender as gender',
                              'studentRegistration.updated_at as updated_at','studentpicture.picture as picture']);

        $schoolclass = Schoolclass::all();
        $schoolterm = Schoolterm::all();
        $schoolsession = Schoolsession::all();

        return view('student.index')->with('student',$student)
                                    ->with('schoolclass',$schoolclass)
                                    ->with('schoolterm',$schoolterm)
                                    ->with('schoolsession', $schoolsession);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $schoolclass = Schoolclass::leftJoin('schoolarm', 'schoolarm.id','=','schoolclass.arm')
        ->get(['schoolclass.id as id','schoolclass.schoolclass as schoolclass','schoolarm.arm as arm'])
         ->sortBy('sdesc');
        $schoolterm = Schoolterm::all();
        $schoolsession = Schoolsession::all();

        return view('student.create')->with('schoolclass',$schoolclass)
                                    ->with('schoolterm',$schoolterm)
                                    ->with('schoolsession', $schoolsession);

    }


    public function bulkupload()
    {

        $schoolclass = Schoolclass::leftJoin('schoolarm', 'schoolarm.id','=','schoolclass.arm')
        ->get(['schoolclass.id as id','schoolclass.schoolclass as schoolclass','schoolarm.arm as arm'])
        ->sortBy('sdesc');
        $schoolterm = Schoolterm::all();
        $schoolsession = Schoolsession::all();

        return view('student.bulkupload')->with('schoolclass',$schoolclass)
                                    ->with('schoolterm',$schoolterm)
                                    ->with('schoolsession', $schoolsession);

    }



    public function batchindex()
    {


        $batch = StudentBatchModel::leftJoin('schoolclass', 'schoolclass.id','=','student_batch_upload.schoolclassid')
        ->leftJoin('schoolsession','schoolsession.id','=','student_batch_upload.session')
        ->leftJoin('schoolterm','schoolterm.id','=','student_batch_upload.termid')
        ->leftJoin('schoolarm','schoolarm.id','=','schoolclass.arm')
       ->get(['student_batch_upload.id as id','student_batch_upload.title as title','schoolclass.schoolclass as schoolclass',
              'schoolterm.term as term','schoolsession.session as session','schoolarm.arm as arm',
              'student_batch_upload.status as status','student_batch_upload.updated_at as upload_date']) ->sortBy('upload_date');


                return view('student.batchindex')->with('batch',$batch);
    }


    public function bulkuploadsave(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'filesheet' => 'required|mimes:xlsx, csv, xls',
            'title' => 'required',
            'termid' => 'required',
            'sessionid' => 'required',
            'schoolclassid' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)
                                    ->withInput();

        }
        $batchchk = StudentBatchModel::where('title',$request->title)->exists();
        if($batchchk){
            return redirect()->back()->with('success', 'Title  is already choose,  Please choosen another Title for this Batch Upload');
        }else{


        Session::put('sclassid',$request->schoolclassid);
        Session::put('tid', $request->termid);
        Session::put('sid',$request->sessionid);
        // Session::put('batchid',$batch->id);
        $file =  $request->file('filesheet');
        //Excel::import(new StudentsImport(),$file );
        (new StudentsImport())->import($file, null, \Maatwebsite\Excel\Excel::XLSX);
        $batch = new StudentBatchModel();
        $batch->title = $request->title;
        $batch->schoolclassid = $request->schoolclassid;
        $batch->termid = $request->termid;
        $batch->session = $request->sessionid;
        $batch->status = "";
        $batch->save();

       return redirect()->back()->with('success', 'Student Batch File Imported  Successfully');
        }
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'avatar' => 'required',
            'admissionNo' => 'required',
            'title' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'othername' => 'required',
            'home_address' => 'required',
            'gender' => 'required',
            'home_address2' => 'required',
            'dateofbirth' => 'required',
            'age1' => 'required',
            'placeofbirth' => 'required',
            'nationality' => 'required',
            'religion' => 'required',
            'last_school' => 'required',
            'last_class' => 'required',
            'schoolclassid' => 'required',
            'termid' => 'required',
            'sessionid' => 'required',

        ],
        ['schoolclassid.required'=>'Select Class Please!',
        'termid.required'=>'Select a School Term Please!',
        'sessionid.required'=>'Select a School Sessions Please!',
        'avatar.required'=>'Upload a picture Please!',
        'placeofbirth.required'=>'Place of Birth is required!',
        ]
    );


        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)
                                    ->withInput();

        }

        $studentbiodata = new Student();
        $studentclass = new Studentclass();
        $promotion = new Promotionstatus();
        $parent = new ParentRegistration();
        $picture = new Studentpicture();
        $studenthouse = new Studenthouse();
        $studentpersonalityprofile = new Studentpersonalityprofile();
        $broadsheet = new Broadsheet();

        $studentcheck = Student::where('admissionNo',$request->admissionNo)
                                ->exists();


        if ($studentcheck){

            return redirect()->back()->with('status', 'Ooops! Record already exist! OR Adminssion Number Registered already.');

        }else{

               //for student biodata...
               $studentbiodata->admissionNo = $request->admissionNo;
               $studentbiodata->tittle = $request->title;
               $studentbiodata->firstname = $request->firstname;
               $studentbiodata->lastname = $request->lastname;
               $studentbiodata->othername = $request->othername;
               $studentbiodata->gender = $request->gender;
               $studentbiodata->home_address = $request->home_address;
               $studentbiodata->home_address2 = $request->home_address;
               $studentbiodata->dateofbirth = $request->dateofbirth;
               $studentbiodata->age = $request->age1;
               $studentbiodata->placeofbirth = $request->placeofbirth;
               $studentbiodata->religion = $request->religion;
               $studentbiodata->nationlity = $request->nationality;
               $studentbiodata->state = $request->state;
               $studentbiodata->local = $request->local;
               $studentbiodata->last_school = $request->last_school;
               $studentbiodata->last_class = $request->last_class;
               $studentbiodata->registeredBy= $request->registeredBy;
               $studentbiodata->save();
               $studentId = $studentbiodata->id;

               // for parent....
               $parent->studentId = $studentId;
               $parent->father_title ="";
               $parent->mother_title ="";
               $parent->father  ="";
               $parent->mother ="";
               $parent->father_phone ="";
               $parent->mother_phone ="";
               $parent->parent_address ="";
               $parent->office_address ="";
               $parent->father_occupation ="";
               $parent->religion ="";
               $parent->save();

               //for student class

               $studentclass->studentId = $studentId;
               $studentclass->schoolclassid = $request->schoolclassid;
               $studentclass->termid = $request->termid;
               $studentclass->sessionid = $request->sessionid;
               $studentclass->save();

               //for class history...
               $promotion->studentId = $studentId;
               $promotion->schoolclassid = $request->schoolclassid;
               $promotion->termid = $request->termid;
               $promotion->sessionid = $request->sessionid;
               $promotion->promotionStatus = "PROMOTED";
               $promotion->classstatus = "CURRENT";
               $promotion->save();


               //for student picture...
            //    $picture->studentid = $studentId;
            //    $picture->save();

            $request->validate(['avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', ]);
            $path = storage_path('images/studentavatar');
            !is_dir($path) && mkdir($path, 0775, true);

                if( $file = $request->file('avatar')) {
                    //$filename = $request->firstname.'_'. $request->lastname;
                    $filename   = $studentId.'_'.$file->getClientOriginalName();
                    if( Storage::disk('public')->exists('images/studentavatar/'.$filename)){
                        Storage::disk('public')->delete('images/studentavatar/'.$filename);
                        $this->studentuploads($file,$path,$studentId);
                    }else{
                        $this->studentuploads($file,$path,$studentId);
                        // dd('File does not exist.');
                    }

                        //updateOrCreate
                    Studentpicture::updateOrCreate(
                        ['studentid' =>  $studentId],
                        ['picture' => $filename]
                    );

                }

                //for student house...
                $studenthouse->studentid = $studentId;
                $studenthouse->termid = $request->termid;
                $studenthouse->sessionid = $request->sessionid;
                $studenthouse->save();

                //for student personality profile...
                $studentpersonalityprofile->studentid = $studentId;
                $studentpersonalityprofile->schoolclassid = $request->schoolclassid;
                $studentpersonalityprofile->termid = $request->termid;
                $studentpersonalityprofile->sessionid = $request->sessionid;
                $studentpersonalityprofile->save();





           if($studentbiodata != null){

            return redirect()->back()->with('success', 'Student Details captured  Successfully!!');

            }else{

            return redirect()->back()->with('status', 'Something went wrong!');
            }

         }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $student = student::where('studentRegistration.id', $id)
                         ->leftJoin('parentRegistration', 'parentRegistration.studentId','=','studentRegistration.id')
                         ->leftJoin('studentpicture','studentpicture.studentid','=','studentRegistration.id')
                         ->leftJoin('studentclass','studentclass.studentId','=','studentRegistration.id')
                         ->leftJoin('schoolclass','schoolclass.id','=','studentclass.schoolclassid')
                         ->leftJoin('schoolterm','schoolterm.id','=','studentclass.termid')
                         ->leftJoin('schoolsession','schoolsession.id','=','studentclass.sessionid')
        ->get(['studentRegistration.id as sid','studentRegistration.admissionNo as admissionNo','studentRegistration.tittle as title','studentRegistration.firstname as firstname',
        'studentRegistration.lastname as lastname','studentRegistration.othername as othername','studentRegistration.dateofbirth as dob',
        'studentRegistration.gender as gender','studentRegistration.placeofbirth as pob','studentRegistration.home_address as homeadd',
        'studentRegistration.home_address2 as homeadd2','studentRegistration.religion as religion','studentRegistration.nationlity as nation',
        'studentRegistration.state as state','studentRegistration.local as local','studentRegistration.last_school as lastsch','studentRegistration.last_class as lastclass',
        'studentRegistration.updated_at as updated_at','studentRegistration.tittle as title','studentpicture.picture as picture',
      'studentclass.schoolclassid as sclassid', 'schoolclass.schoolclass as schoolclass','schoolclass.arm as arm','schoolterm.term as term','studentclass.termid as termid','studentclass.sessionid as sessionid','schoolsession.session as session']);


        $schoolclass = Schoolclass::all();
        $schoolterm = Schoolterm::all();
        $schoolsession = Schoolsession::all();


        return view('student.edit')->with('student',$student)
                                   ->with('schoolclass',$schoolclass)
                                  ->with('schoolterm',$schoolterm)
                                 ->with('schoolsession', $schoolsession);
    }


     public function setting($id){



    }


    public function overview($id){


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $studentbiodata = student::find($id);
        $studentclass =   studentclass::find($id);
        $promotion = promotionstatus::find($id);


        //for student biodata...
        $input = $request->only(['admissionNo', 'tittle','firstname','lastname','other','gneder','home_address','home_address2',
                                 'dateofbirth','placeofbirth','religion','nationality','state','local','last_school','last_class']);
         $studentbiodata->update($input);

        //for student class...
        $input2 = $request->only(['schoolclassid', 'termid','sessionid']);
         $studentclass->update($input2);
       // print_r($input2);


       //for  class promotion...
         $input3 = $request->only(['schoolclassid', 'termid','sessionid','PROMOTED','CURRENT']);
        // print_r($input3);
         $promotion->update($input3);



      // for broadsheet...
      if(broadsheet::Where('studentId',$id)->exists())
        broadsheet::Where('studentId',$id)->delete();

      // for subject registratio status...
      if(subjectRegistrationStatus::Where('studentId',$id)->exists())
        subjectRegistrationStatus::Where('studentId',$id)->delete();







      return redirect()->back()->with('success', 'Student updated  Successfully!!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        Student::find($id)->delete();
        Studentclass::where('studentId',$id)->delete();
        Promotionstatus::where('studentId',$id)->delete();
        ParentRegistration::where('studentId',$id)->delete();
        Studentpicture::where('studentid',$id)->delete();
        Broadsheet::where('studentId',$id)->delete();
        SubjectRegistrationStatus::where('studentId',$id)->delete();

        return redirect()->back()->with('success', 'Student data deleted Successfully!!');


    }

    public function deletestudent(Request $request)
    {

        Student::find($s)->delete();
        Studentclass::where('studentId',$s)->delete();
        Studenthouse::where('studentid',$s)->delete();
        Promotionstatus::where('studentId',$s)->delete();
        ParentRegistration::where('studentId',$s)->delete();
        Studentpicture::where('studentid',$s)->delete();
        Broadsheet::where('studentId',$s)->delete();
        SubjectRegistrationStatus::where('studentId',$s)->delete();
       // check data deleted or not
        if ($s) {
            $success = true;
            $message = "Student has been removed";
        } else {
            $success = true;
            $message = "Student not found";
        }

        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }


    public function deletestudentbatch(Request $request)
    {

       // StudentBatchModel::find($request->studentbatchid)->delete();
        $batch =StudentBatchModel::where('id',$request->studentbatchid)->pluck('id')->first();
        $sc = Student::where('batchid',$batch)->pluck('id');

                 foreach($sc as $s){

                    Studentclass::where('studentId',$s)->delete();
                    Studenthouse::where('studentid',$s)->delete();
                    Promotionstatus::where('studentId',$s)->delete();
                    ParentRegistration::where('studentId',$s)->delete();
                    Studentpicture::where('studentid',$s)->delete();
                    Broadsheet::where('studentId',$s)->delete();
                    SubjectRegistrationStatus::where('studentId',$s)->delete();
                    Studentpersonalityprofile::where('studentId',$s)->delete();

                 }
        StudentBatchModel::where('id',$request->studentbatchid)->delete();
        Student::where('batchid',$batch)->delete();
       //check data deleted or not
        if ($request->studentbatchid) {
            $success = true;
            $message = "Batch Upload has been removed";
        } else {
            $success = true;
            $message = "Batch Upload not found";
        }
        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }
}
