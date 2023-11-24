<?php

namespace App\Imports;


use App\Models\Broadsheet;
use App\Models\Promotionstatus;
use App\Models\Subjectclass;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Validators\Failure;

class ScoresheetImport implements ToModel, WithUpserts, WithUpsertColumns, WithStartRow, WithValidation
{

    use Importable;


       public $id=0;


    public function model(array $row)
    {



        $current = "Current";
        $schoolclassid =  Session::get('schoolclassid');
        $subjectclassid =  Session::get('subjectclassid');
        $staffid = Session::get('staffid');
        $termid = Session::get('termid');
        $sessionid = Session::get('sessionid');



      broadsheet::updateOrCreate(
        ['id' => $row[6],
        'staffid' => $row[7],
        'subjectclassid' => $row[8],
        'termid' => $row[9],
        'session' => $row[10],
       ],
        [
        'ca1'     =>  $row[3],
        'ca2'     =>  $row[4],
        'exam'    =>  $row[5],
        'total'   =>  $row[3]+$row[4]+$row[5],
        'grade'   =>  $this->grade($row[3]+$row[4]+$row[5]),
        'remark'  =>  $this->remark($row[3]+$row[4]+$row[5]),
       ]);




      return $this->subjectscoresheetpos($schoolclassid,$subjectclassid,$staffid,$termid,$sessionid);



    }

    public function grade($total){
        $tgrade = "";
        switch ($total){

            case($total >= 70):
                $tgrade="A";
                break;
               case($total >= 60 && $total <= 69):
                   $tgrade="B";
                   break;
                 case($total >= 40 && $total <= 59):
                       $tgrade="C";
                       break;
                    case($total >= 30 && $total <=39):
                       $tgrade="D";
                       break;
                           case($total<=29):
                           $tgrade="F";
                           break;
        }

               return $tgrade;
    }


    public function remark($total){
        $remark = "";
        switch ($total){

            case($total >= 70):
                $remark="EXCELLENT";
                break;
                   case($total >= 60 && $total <= 69):
                   $remark="VERY GOOD";
                   break;
                       case($total >= 40 && $total <= 59):
                       $remark="GOOD";
                       break;
                           case($total >= 30 && $total <=39):
                           $remark="FAIRLY GOOD";
                           break;
                                case($total<=29):
                                $remark="POOR";
                                break;
        }

               return $remark;
    }


    public function rules(): array
    {
        global $id;
        $id = Session::get('subjectclassid');

        return [


            '3'=> function($attribute, $value, $onFailure) use(&$id) {

                $ca1score=0;

                $classcategory = Subjectclass::where('subjectclass.id',$id)
                ->leftJoin('schoolclass', 'schoolclass.id','=','subjectclass.schoolclassid')
                ->leftJoin('classcategories', 'classcategories.id','=','schoolclass.classcategoryid')
                ->get(['classcategories.ca1score as ca1']);

                foreach ($classcategory as $key => $val) {
                    # code...
                    $ca1score  = $val->ca1;


                }



                if ($value > $ca1score) {
                     $onFailure('Maximum score for CA1 which is '.'('.$ca1score.'%)'.  ' is exceeded');
                }
                if (!is_numeric($value)) {

                    $onFailure('Score entered is not a number');

               }
               if (is_null($value) || $value=="") {
                $onFailure('Field cannot be empty');
           }
            },

            '4'=> function($attribute, $value, $onFailure) use (&$id) {
                $id =  Session::get('subjectclassid');

                $ca2score = 0;

                $classcategory = Subjectclass::where('subjectclass.id',$id)
                ->leftJoin('schoolclass', 'schoolclass.id','=','subjectclass.schoolclassid')
                ->leftJoin('classcategories', 'classcategories.id','=','schoolclass.classcategoryid')
                ->get(['classcategories.ca2score as ca2']);

                foreach ($classcategory as $key => $val) {
                    # code...

                    $ca2score  = $val->ca2;


                }




                if ($value > $ca2score) {
                    $onFailure('Maximum score for CA2 which is '.'('.$ca2score.')'.  ' is exceeded');
                }
                if (!is_numeric($value)) {
                    $onFailure('Score entered is not a number');
               }
               if (is_null($value) || $value=="") {
                $onFailure('Field cannot be empty');
           }
            },

            '5'=> function($attribute, $value, $onFailure)  use (&$id){
                $id =  Session::get('subjectclassid');

                $examscore = 0;
                $classcategory = Subjectclass::where('subjectclass.id',$id)
                ->leftJoin('schoolclass', 'schoolclass.id','=','subjectclass.schoolclassid')
                ->leftJoin('classcategories', 'classcategories.id','=','schoolclass.classcategoryid')
                ->get(['classcategories.examscore as exam']);

                foreach ($classcategory as $key => $val) {
                    # code...

                    $examscore  = $val->exam;

                }



                if ($value > $examscore) {
                    $onFailure('Maximum score for EXAM which is '.'('.$examscore.'%)'.  ' is exceeded');
                }
                if (!is_numeric($value)) {
                    $onFailure('Score entered is not a number');
               }
               if (is_null($value) || $value=="") {
                $onFailure('Field cannot be empty');
           }
            },
        ];
    }
    public function customValidationMessages()
    {
        return [
            '3.in' => 'Custom message for :attribute.',
            '4.in' => 'Custom message for :attribute.',
            '5.in' => 'Custom message for :attribute.',
        ];
    }

    public function customValidationAttributes()
    {
        return ['3' =>  'CA1',
                '4' =>  'CA2',
                '5' =>  'EXAM'
            ];
    }
    public function startRow(): int
    {
        return 2;
    }

    public function uniqueBy()
    {
        return 'id';
    }

    public function upsertColumns()
    {
        return ['ca1', 'ca2','exam'];
    }

    public function onFailure(Failure $failure){

            echo "failure";

    }

    public function subjectscoresheetpos($schoolclassid,$subjectclassid,$staffid,$termid,$sessionid){

        $current = "Current";
        //class category model..

        // echo $schoolclassid;
        $Broadsheets = Broadsheet::where('subjectclassid',$subjectclassid)
        ->where('Broadsheet.staffid',$staffid)
        ->where('Broadsheet.termid',$termid)
        ->where('Broadsheet.session',$sessionid)
        ->leftJoin('subjectclass', 'subjectclass.id','=','Broadsheet.subjectclassid')
        ->leftJoin('schoolclass', 'schoolclass.id','=','subjectclass.schoolclassid')
        ->leftJoin('classcategories', 'classcategories.id','=','schoolclass.classcategoryid')
        ->leftJoin('subjectteacher','subjectteacher.id','=','subjectclass.subjectteacherid')
        ->leftJoin('subject', 'subject.id','=','subjectteacher.subjectid')
        ->leftJoin('schoolterm', 'schoolterm.id','=','subjectteacher.termid')
        ->leftJoin('schoolsession', 'schoolsession.id','=','subjectteacher.sessionid')
        ->where('schoolsession.status','=',$current)
        ->leftJoin('studentRegistration', 'studentRegistration.id','=','Broadsheet.studentId')
        ->leftJoin('studentpicture','studentpicture.studentid','=','studentRegistration.id')
        ->get(['Broadsheet.id as id','studentRegistration.admissionNO as admissionno',
            'studentRegistration.firstname as fname','studentRegistration.lastname as lname',
              'subject.subject as subject','subject.subject_code as subjectcode',
              'schoolclass.schoolclass as schoolclass','schoolclass.arm as arm',
              'schoolterm.term as term','schoolsession.session as session',
              'subjectclass.id as subjectclid','Broadsheet.staffid as staffid',
              'Broadsheet.termid as termid','Broadsheet.session as sessionid',
              'classcategories.ca2score as ca2score','classcategories.ca1score as ca1score',
              'classcategories.examscore as examscore','studentPicture.picture as picture'
              ,'Broadsheet.ca1 as ca1','Broadsheet.ca2 as ca2',
             'Broadsheet.exam as exam','Broadsheet.total  as total','Broadsheet.grade as grade',
            'Broadsheet.subjectpositionclass as position','Broadsheet.remark as remark'])
              ->sortBy('admissionno');

            if($Broadsheets){
             foreach($Broadsheets as $r){$r->Broadsheetid;$r->subjectclid;$r->staffid;$r->termid;$r->sessionid; }

             $this->scorescheck($r->ca1score,$r->ca2score,$r->examscore);


            //get minimun score....
                $classmin = Broadsheet::where('subjectclassid',$subjectclassid)
                ->where('Broadsheet.staffid',$staffid)
                ->where('Broadsheet.termid',$termid)
                ->where('Broadsheet.session',$sessionid)
                ->min('total');

            // echo (float)$classmin;


                Broadsheet::where('subjectclassid',$subjectclassid)
                ->where('Broadsheet.staffid',$staffid)
                ->where('Broadsheet.termid',$termid)
                ->where('Broadsheet.session',$sessionid)
                ->update(array('cmin'=>$classmin));
                //get maximun score....
                $classmax = Broadsheet::where('subjectclassid',$subjectclassid)
                ->where('Broadsheet.staffid',$staffid)
                ->where('Broadsheet.termid',$termid)
                ->where('Broadsheet.session',$sessionid)
                ->max('total');
                Broadsheet::where('subjectclassid',$subjectclassid)
                ->where('Broadsheet.staffid',$staffid)
                ->where('Broadsheet.termid',$termid)
                ->where('Broadsheet.session',$sessionid)
                ->update(array('cmax'=>$classmax));
                //get average score...
                $classavg = ($classmin + $classmax)/2;
                Broadsheet::where('subjectclassid',$subjectclassid)
                ->where('Broadsheet.staffid',$staffid)
                ->where('Broadsheet.termid',$termid)
                ->where('Broadsheet.session',$sessionid)
                ->update(array('avg'=>round($classavg, 1)));
                //calculating position in subject per class...
                $rank = 0;
                $last_score = false;
                $rows = 0;
                $position="";

                $classpos = Broadsheet::select("*")
                ->where('subjectclassid',$subjectclassid)
                ->where('Broadsheet.staffid',$staffid)
                ->where('Broadsheet.termid',$termid)
                ->where('Broadsheet.session',$sessionid)
            // ->orderBy('studentId','DESC')
                ->orderBy('total','DESC')
                ->get();



            foreach ($classpos as $row){

            $studentId =  $row->studentId;
            $rows++;
            if($last_score != $row->total){

                $last_score = $row->total;
                $rank = $rows;

            }
            if($rank == 1){
                $position = "st";

                }elseif ($rank == 2) {
                $position = "nd";

                }elseif ($rank== 3) {
                $position = "rd";

                }else{
                $position = "th";
                }

                        $rank_pos = $rank.$position;
                    //  echo "<br>";
                    // echo $row->studentId." "."$row->total"." ".gettype(strval($rank_pos))." "."<br>";

                    Broadsheet::where('subjectclassid',$subjectclassid)
                        ->where('Broadsheet.studentId',$studentId)
                        ->where('Broadsheet.staffid',$staffid)
                        ->where('Broadsheet.termid',$termid)
                        ->where('Broadsheet.session',$sessionid)
                        ->update(array('subjectpositionclass'=> $rank_pos));

                    }



                      //calculating position  per class...
                      $rank2 = 0;
                      $last_score2 = false;
                      $rows2 = 0;
                      $position2 ="";


                      $pos = Promotionstatus::where('schoolclassid',$schoolclassid)
                       ->leftJoin('schoolclass', 'schoolclass.id','=','promotionstatus.schoolclassid')
                       ->where('termid',$termid)
                       ->where('sessionid',$sessionid)
                       ->orderBy('subjectstotalscores','DESC')
                       ->get();


                         foreach ($pos as $row2){
                          $studentId2 =  $row2->studentId;
                          $rows2++;
                          if($last_score2 != $row2->subjectstotalscores){
                              $last_score2 = $row2->subjectstotalscores;
                              $rank2 = $rows2;
                          }
                          if($rank2 == 1){
                              $position2 = "st";
                              }elseif ($rank2 == 2) {
                              $position2 = "nd";
                              }elseif ($rank2== 3) {
                              $position2 = "rd";
                              }else{
                              $position2 = "th";
                              }

                              $rank_pos2 = $rank2.$position2;
                             // echo "<br>";
                             // echo $row2->studentId2." "."$row2->subjectstotalscores"." ".gettype(strval($rank_pos2))." "."<br>";

                            Promotionstatus::where('studentId',$studentId2)
                              ->leftJoin('schoolclass', 'schoolclass.id','=','promotionstatus.schoolclassid')
                              ->where('schoolclassid',$schoolclassid)
                              ->where('termid',$termid)
                              ->where('sessionid',$sessionid)
                              ->update(array('position'=> $rank_pos2));

                          }

                Session::put('Broadsheetid',$r->Broadsheetid);
                Session::put('subjectclassid',$r->subjectclid);
                Session::put('staffid', $r->staffid);
                Session::put('termid', $r->termid);
                Session::put('sessionid',$r->sessionid);


        }else{

            echo "ERROR 112O";
        }




    }


     public function scorescheck($ca1,$ca2,$exam){

        $allscores = array($ca1,$ca1,$exam);
        return $allscores;
     }



}
