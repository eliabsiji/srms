
<?php $__env->startSection('content'); ?>

     <!-- Start Page title and tab -->
     <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center ">
                <div class="header-action">
                    <h1 class="page-title">School</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Class Category</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Class Category</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('classcategory-list')): ?>
                        <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#category">List View</a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add-subject')): ?>
                    <li class="nav-item"><a class="nav-link" id="Library-tab-Boot" data-toggle="tab" href="#student-add"> </a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subject-class-list')): ?>
                        <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#classsubject"></a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add-student')): ?>
                    <li class="nav-item"><a class="nav-link" id="Library-tab-Boot" data-toggle="tab" href="#category-add">Add Class Category </a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subject-class-list')): ?>
                        <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#classsubject"></a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assign-subject-class')): ?>
                    <li class="nav-item"><a class="nav-link" id="Library-tab-Boot" data-toggle="tab" href="#student-add"> </a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <?php if(\Session::has('status')): ?>
           <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"></button>
                <p><?php echo e(\Session::get('status')); ?></p>
            </div>
        <?php endif; ?>
        <?php if(\Session::has('success')): ?>
           <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"></button>
                <p><?php echo e(\Session::get('success')); ?></p>
            </div>
        <?php endif; ?>
        <?php if(\Session::has('danger')): ?>
        <div class="alert alert-danger alert-dismissible">
         <button type="button" class="close" data-dismiss="alert"></button>
             <p><?php echo e(\Session::get('danger')); ?></p>
         </div>
     <?php endif; ?>

     <?php if(count($errors) > 0): ?>
     <div class="alert alert-success alert-dismissible">
        <a class="btn btn-primary" href="<?php echo e(route('student.index')); ?>"> Back to Class Category</a>
         <button type="button" class="close" data-dismiss="alert"></button>
         <strong>Opps!</strong> Something went wrong, please check where you  add data .<br><br>
         <ul>
             <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <li><?php echo e($error); ?></li>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </ul>
     </div>
 <?php endif; ?>
    </div>
    <div class="section-body mt-4">
        <div class="container-fluid">
            <div class="tab-content">



                <div class="tab-pane active" id="category">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-striped table_custom">
                                    <thead>

                                            <tr>
                                                <th>SN</th>
                                                <th>Class Category</th>
                                                <th>CA 1 Score</th>
                                                <th>CA 2 Score</th>
                                                <th>Exam Score</th>
                                                <th>Action</th>

                                            </tr>

                                    </thead>
                                    <tbody>
                                        <?php $sn = 1; ?>
                                     <?php $__currentLoopData = $classcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <tr id="sid<?php echo e($sc->id); ?>">
                                         <td><?php echo e($sn++); ?></td>
                                         <td><?php echo e($sc->category); ?> </td>
                                         <td><?php echo e($sc->ca1score); ?></td>
                                         <td><?php echo e($sc->ca2score); ?></td>
                                         <td><?php echo e($sc->examscore); ?></td>
                                         <td>
                                            <div class="btn-group">

                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-classcategory')): ?>
                                                <a href="<?php echo e(route('classcategories.edit',$sc->id)); ?>" class="btn fa fa-pencil" data-toggle="tooltip" title="Edit class Category"></a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-classcategory')): ?>
                                                <?php echo Form::open(['method' => 'DELETE','route' => ['classcategories.destroy', $sc->id],]); ?>

                                                <button class="btn  fa fa-trash" data-toggle="tooltip" title="Delete class Category"></button>
                                                <?php echo Form::close(); ?>

                                            <?php endif; ?>
                                                </div>
                                            <div class="btn-group">

                                           </div>
                                     </td>

                                    </tr>

                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="tab-pane" id="category-add">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">





                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Create Class Category Info</h3>
                                    <div class="card-options ">
                                        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-body">

                            <form  role="form" id="inline-validation" class="form-horizontal form-stripe"
                            action="<?php echo e(route('classcategories.store')); ?>"  onsubmit="return check()" method="POST">
                                <?php echo csrf_field(); ?>
                               <div class="form-group row">
                                <label class="col-md-3 col-form-label">Category Name <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                   <input type="text" name="category" id="category" class="form-control" placeholder="Class Category Name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">CA 1 Score (%)<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                   <input type="text" name="ca1score" id="ca1score" class="form-control" onkeyup="check()" placeholder="scores (%)" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">CA 2 Score (%) <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                   <input type="text" name="ca2score" id="ca2score" class="form-control" onkeyup="check()" placeholder="scores (%)" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">EXAM Score (%)<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                   <input type="text" name="examscore" id="examscore" class="form-control" onkeyup="check()" placeholder="scores (%)" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Total Score (%)<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                   <input type="text" name="totalscore" id="totalscore" class="form-control" onkeyup="check()" placeholder="scores (%)" required readonly>
                                </div>
                            </div>


                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label"></label>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-primary">Submit Data</button>

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
        </div>
    </div>


<script>


 function check() {


        var txtFirsttextValue= 0;
        var txtSecondtextValue = 0;
        var txtExamtextValue = 0;
        var result = 0;
        var total = 0;

            var txtFirsttextValue = document.getElementById('ca1score').value;
            var txtSecondtextValue = document.getElementById('ca2score').value;
            var txtExamtextValue = document.getElementById('examscore').value;

            if(isNaN(txtFirsttextValue)){
                alert("First CA  is not a digit please");
                return false;
            }

            if(isNaN(txtSecondtextValue) ){
                alert("Second CA is not a digit please");
                return false;
            }

            if(isNaN(txtExamtextValue)){
                alert("Exam score is not a digit please");
                return false;
            }

            var result = parseFloat(txtFirsttextValue) +
                         parseFloat(txtSecondtextValue) +
                         parseFloat(txtExamtextValue) ;
            total = parseFloat(result);

            if (!isNaN(result)) {

                document.getElementById('totalscore').value = total;

                if (total != 100){
                    alert("Score should not be more or less than 100%");
                    return false;
                }




            }
  }


</script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\srms\resources\views/classcategories/index.blade.php ENDPATH**/ ?>