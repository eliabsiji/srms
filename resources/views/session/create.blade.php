@extends('layouts.master')
@section('content')
<div class="content">
            <div class="content-header">

                <div class="leftside-content-header">
                    <ul class="breadcrumbs">
                        <li><i class="fa fa-columns" aria-hidden="true"></i><a href="#">Session Management</a></li>
                        <li><a>Add New Session</a></li>
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
            <div class="alert alert-warning fade in">
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
                    <a class="btn btn-primary" href="{{ route('session.index') }}"> Back to Session Management</a>
                </span>
                    <div class="panel">
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <form  role="form" id="inline-validation" class="form-horizontal form-stripe" action="{{ route('session.store') }}" method="POST">
                                     @csrf
                                        <div class="form-group">
                                            <label for="name" class="col-sm-3 control-label">Session<span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="session" name="session" placeholder="Session" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-sm-3 control-label">Select Status<span class="required">*</span></label>
                                            <div class="col-sm-9">
                                          <select name ="status" id="status"  class="form-control" >
                                            <option value="" selected>Select Session</option>
                                            <option value="Current">Current</option>
                                            <option value="Past">Past</option>
                                             </select>
                                            </div>
                                       </div>




                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-primary">Submit</button>
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
