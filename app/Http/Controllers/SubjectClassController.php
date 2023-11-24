<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Schoolclass;
use App\Models\Subjectclass;
USE App\Models\Broadsheet;
use App\Models\SubjectRegistrationStatus;
use App\Models\Subjectteacher;


class SubjectClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:subject-class-list|assign-subject-class|subject-class-edit|subject-class-delete', ['only' => ['index','store']]);
         $this->middleware('permission:assign-subject-class', ['only' => ['create','store']]);
         $this->middleware('permission:subject-class-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:subject-class-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        //
        $schoolclass = Schoolclass::all();
        $subjectteacher = Subjectteacher::leftJoin('subject', 'subject.id','=','subjectteacher.subjectid')
        ->leftJoin('users', 'users.id','=','subjectteacher.staffid')
        ->leftJoin('staffbioinfo', 'staffbioinfo.userid','=','users.id')
        ->get(['subject.id as subjectid','subject.subject as subject', 'subject.subject_code as subjectcode',
        'subjectteacher.id as id','subjectteacher.staffid as subtid','subjectteacher.subjectid as subid'
        ,'users.name as teachername','staffbioinfo.title as title'])
         ->sortBy('sdesc');


        $subjectclasses = Subjectclass::leftJoin('schoolclass', 'subjectclass.schoolclassid','=','schoolclass.id')
                                      ->leftJoin('subjectteacher', 'subjectteacher.id','=','subjectclass.subjectteacherid')
                                      ->leftJoin('subject', 'subject.id','=','subjectteacher.subjectid')
                                      ->leftJoin('users', 'users.id','=','subjectteacher.staffid')
                                      ->leftJoin('staffPicture', 'staffPicture.staffId','=','subjectteacher.staffid')
                                      ->get(['subjectclass.id as scid','schoolclass.schoolclass as sclass', 'schoolclass.arm as sarm',
                                      'subjectteacher.staffid as subtid','subjectteacher.subjectid as subid','subject.subject_code as subjectcode',
                                      'subject.subject as subjectname','schoolclass.description as sdesc','users.name as teachername',
                                      'subjectclass.updated_at as updated_at','staffPicture.picture as picture','schoolclass.id as did',
                                      'subject.id as subjectid','subjectteacher.id as subteacherid'])
                                       ->sortBy('sdesc');


      return view('subjectclass.index')->with('subjectclasses', $subjectclasses)
                                       ->with('schoolclasses',$schoolclass)
                                       ->with('subjectteacher',$subjectteacher);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $schoolclass = Schoolclass::all();
        $subjectteacher = Subjectteacher::leftJoin('subject', 'subject.id','=','subjectteacher.subjectid')
        ->leftJoin('users', 'users.id','=','subjectteacher.staffid')
        ->leftJoin('staffbioinfo', 'staffbioinfo.userid','=','users.id')
        ->get(['subject.id as subjectid','subject.subject as subject', 'subject.subject_code as subjectcode',
        'subjectteacher.id as id','subjectteacher.staffid as subtid','subjectteacher.subjectid as subid'
        ,'users.name as teachername','staffbioinfo.title as title'])
         ->sortBy('sdesc');


       return view('subjectclass.create')
                   ->with('schoolclasses',$schoolclass)
                   ->with('subjectteacher',$subjectteacher);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $subjectclass = new Subjectclass();
        $validator = Validator::make($request->all(), [
            'schoolclassid' => 'required',
            'subjectid' => 'required',
           //'subjectteacher' => 'required',
        ],
        ['subjectid.required'=>'Select Subject Teacher!',
        'schoolclassid.required'=>'Select a class Please!',
        ]
    );

        if ($validator->fails()) {

           return redirect()->back()->withErrors($validator)
                                    ->withInput();

        } else{
        $subjectclass->schoolclassid = $request->schoolclassid;
        $subjectclass->subjectid = "none";
        $subjectclass->subjectteacherid = $request->subjectid;

        //check if the record exists...

        $subjectclasscheck = Subjectclass::where('schoolclassid',$request->schoolclassid)
                                               ->where('subjectid','none')
                                               ->where('subjectteacherid',$request->subjectid)
                                                ->exists();
        if ($subjectclasscheck){


            return redirect()->route('subjectclass.index')
                              ->with('danger', 'Ooops! Record already exist!');
          }else{
             $subjectclass->save();
            if($subjectclass != null){

           return redirect()->route('subjectclass.index')
                             ->with('success', 'Subject has been assigned to the class Successfully!');

         }else{

            redirect()->route('subjectclass.index')
                       ->with('status', 'Something went wrong!');
         }
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
        $schoolclass = Schoolclass::all();
        $subjectteacher = Subjectteacher::leftJoin('subject', 'subject.id','=','subjectteacher.subjectid')
        ->leftJoin('users', 'users.id','=','subjectteacher.staffid')
        ->leftJoin('staffbioinfo', 'staffbioinfo.userid','=','users.id')
        ->get(['subject.id as subjectid','subject.subject as subject', 'subject.subject_code as subjectcode',
        'subjectteacher.id as id','subjectteacher.staffid as subtid','subjectteacher.subjectid as subid'
        ,'users.name as teachername','staffbioinfo.title as title'])
         ->sortBy('sdesc');

         $subjectclasses = Subjectclass::where('subjectclass.id',$id)
                                      ->leftJoin('schoolclass', 'subjectclass.schoolclassid','=','schoolclass.id')
                                      ->leftJoin('subjectteacher', 'subjectteacher.id','=','subjectclass.subjectteacherid')
                                      ->leftJoin('subject', 'subject.id','=','subjectteacher.subjectid')
                                      ->leftJoin('users', 'users.id','=','subjectteacher.staffid')
                                      ->leftJoin('staffPicture', 'staffPicture.staffId','=','subjectteacher.staffid')
                                      ->get(['subjectclass.id as scid','schoolclass.schoolclass as schoolclass', 'schoolclass.arm as arm',
                                      'subjectteacher.staffid as subtid','subjectteacher.subjectid as subid','subject.subject_code as subjectcode',
                                      'subject.subject as subjectname','schoolclass.description as sdesc','users.name as teachername',
                                      'subjectclass.updated_at as updated_at','staffPicture.picture as picture','schoolclass.id as sclassid',
                                      'subjectteacher.id as subteacherid'])
                                       ->sortBy('sdesc');

        return view('subjectclass.edit')->with('subjectclasses',$subjectclasses)
                                        ->with('subjectteachers',$subjectteacher)
                                        ->with('schoolclasses',$schoolclass);
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


       $input = $request->all();
       $subjectclass = Subjectclass::find($id);
       $subjectclass->update($input);
       return redirect()->route('subjectclass.index')
         ->with('success', 'Subject Class updated successfully.');

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
        Subjectclass::find($id)->delete();
        Broadsheet::where('subjectclassid',$id)->delete();
        SubjectRegistrationStatus::where('subjectclassid',$id)->delete();
        return redirect()->route('subjectclass.index')
            ->with('success', 'Subject class deleted successfully.');
    }
}
