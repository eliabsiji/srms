@extends('layouts.master')
@section('content')
<div class="content">
            <div class="content-header">

                <div class="leftside-content-header">
                    <ul class="breadcrumbs">
                        <li><i class="fa fa-columns" aria-hidden="true"></i><a href="{{ route('subjectteacher.index') }}">Subject Teacher Management</a></li>
                        <li><a>Add New Subject Teacher</a></li>
                    </ul>
                </div>
            </div>
            @if (\Session::has('status'))
            <div class="alert alert-warning fade in">
             <a href="#" class="close" data-dismiss="alert">&times;</a>
                 <p>{{ \Session::get('status') }}</p>
             </div>
         @endif
             @if (\Session::has('success'))
            <div class="alert alert-success fade in">
             <a href="#" class="close" data-dismiss="alert">&times;</a>
                 <p>{{ \Session::get('success') }}</p>
             </div>
         @endif
            <div class="row animated fadeInUp">
                  @if (count($errors) > 0)
            <div class="alert alert-warning fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
                <div class="col-sm-12 col-md-8 col-md-offset-2">
                   <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('subjectteacher.index') }}"> Back to Subject Teacher Management</a>
                </span>
                    <div class="panel">
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <form  ole="form" id="inline-validation" class="form-horizontal form-stripe" action="{{ route('subjectteacher.store') }}" method="POST">
                                     @csrf


                                     <div class="form-group">
                                        <label for="password" class="col-sm-3 control-label">Select Teacher<span class="required">*</span></label>
                                        <div class="col-sm-9">
                                    <select name ="staffid" id="staffid"  class="form-control" required>
                                        <option value="" selected>Select staff</option>
                                        @foreach ($staffs as $staff => $name )
                                         <option value="{{$name->userid}}">{{ $name->name }} </option>
                                        @endforeach
                                    </select>
                                        </div>
                                </div>


                                        <div class="form-group">
                                            <label for="password" class="col-sm-3 control-label">Select Subject<span class="required">*</span></label>
                                            <div class="col-sm-9">
                                        <select name ="subjectid" id="subjectid"  class="form-control" >
                                            <option value="" selected>Select Subject</option>
                                            @foreach ($subjects as $subject => $name )
                                             <option value="{{$name->id}}">{{ $name->subject }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $name->subject_code }} </option>
                                            @endforeach
                                        </select>
                                            </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-sm-3 control-label">Select Term<span class="required">*</span></label>
                                        <div class="col-sm-9">
                                    <select name ="termid" id="termid"  class="form-control" >
                                        <option value="" selected>Select Term </option>
                                        @foreach ($terms as $term => $name )
                                         <option value="{{$name->id}}">{{ $name->term}}</option>
                                        @endforeach
                                    </select>
                                        </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-3 control-label">Select Session<span class="required">*</span></label>
                                    <div class="col-sm-9">
                                <select name ="sessionid" id="sessiionid"  class="form-control" >
                                    <option value="" selected>Select Session </option>
                                    @foreach ($schoolsessions as $schoolsession => $name )
                                     <option value="{{$name->id}}">{{ $name->session}}</option>
                                    @endforeach
                                </select>
                                    </div>
                            </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary">Assign Subject to Teacher</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @endsection
