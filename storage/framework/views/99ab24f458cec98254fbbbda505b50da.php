
<?php $__env->startSection('content'); ?>

     <!-- Start Page title and tab -->
     <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center ">
                <div class="header-action">
                    <h1 class="page-title">School</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Class Teacher</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Class Teacher</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('class-teacher-list')): ?>
                        <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#myclass">My Class</a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add-class-teacher')): ?>
                    <li class="nav-item"><a class="nav-link" id="Library-tab-Boot" data-toggle="tab" href="#classteacher-add"></a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('class-teacher-list')): ?>
                        <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#classteacher"></a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add-class-teacher')): ?>
                    <li class="nav-item"><a class="nav-link" id="Library-tab-Boot" data-toggle="tab" href="#myclasshistory"> My Class History</a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('class-teacher-list')): ?>
                        <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#classteacher"></a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add-class-teacher')): ?>
                    <li class="nav-item"><a class="nav-link" id="Library-tab-Boot" data-toggle="tab" href="#classteacher-add"></a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add-classsettings')): ?>
                    <li class="nav-item"><a class="nav-link" id="Library-tab-Boot" data-toggle="tab" href="#myclasssettings"> My Class Settings</a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('class-teacher-list')): ?>
                        <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#classteacher"></a></li>
                    <?php endif; ?>


                    <li class="nav-item"><a class="nav-link" id="Library-tab-Boot" data-toggle="tab" href="#classteacher-add"></a></li>

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


    </div>
    <div class="section-body mt-4">
        <div class="container-fluid">
            <div class="tab-content">
                <div class="tab-pane active" id="myclass">
                    <div class="card">
                        <div class="card-header">

                            <h5 class="card-title">My Classes for curent session</h5>


                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-striped table_custom">
                                    <thead>

                                            <tr>
                                                <th>SN</th>
                                                <th>Class</th>
                                                <th>Arm</th>
                                                <th>Term</th>
                                                <th>Session</th>
                                               <th>Action</th>

                                            </tr>

                                    </thead>
                                    <tbody>
                                        <?php $sn = 1; ?>
                                     <?php $__currentLoopData = $myclass; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <tr id="sid<?php echo e($sc->id); ?>">
                                         <td><?php echo e($sn++); ?></td>
                                         <td><?php echo e($sc->schoolclass); ?> </td>
                                         <td><?php echo e($sc->schoolarm); ?></td>
                                         <td><?php echo e($sc->term); ?></td>
                                         <td><?php echo e($sc->session); ?></td>
                                          <td>
                                             <div class="btn-group">
                                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-student-list')): ?>
                                                 <a href="viewstudent/<?php echo e($sc->schoolclassID); ?>/<?php echo e($sc->termid); ?>/<?php echo e($sc->sessionid); ?>" class="btn fa fa-eye" data-toggle="tooltip" title="View Students <?php echo e($sc->schoolclass); ?>  <?php echo e($sc->schoolarm); ?> Class">View Students</a>
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

                <div class="tab-pane" id="myclasshistory">
                    <div class="card">
                        <div class="card-header">

                            <h3 class="card-title">My Class History</h3>


                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-striped table_custom">
                                    <thead>

                                            <tr>
                                                <th>SN</th>
                                                <th>Class</th>
                                                <th>Arm</th>
                                                <th>Term</th>
                                                <th>Session</th>
                                               <th>Action</th>

                                            </tr>

                                    </thead>
                                    <tbody>
                                        <?php $sn = 1; ?>
                                     <?php $__currentLoopData = $myclasshistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <tr id="sid<?php echo e($sc->id); ?>">
                                         <td><?php echo e($sn++); ?></td>
                                         <td><?php echo e($sc->schoolclass); ?> </td>
                                         <td><?php echo e($sc->schoolarm); ?></td>
                                         <td><?php echo e($sc->term); ?></td>
                                         <td><?php echo e($sc->session); ?></td>
                                          <td>
                                             <div class="btn-group">
                                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-student-list')): ?>
                                                 <a href="viewstudent/<?php echo e($sc->schoolclassID); ?>/<?php echo e($sc->termid); ?>/<?php echo e($sc->sessionid); ?>" class="btn fa fa-eye" data-toggle="tooltip" title="View Students <?php echo e($sc->schoolclass); ?>  <?php echo e($sc->schoolarm); ?> Class"></a>
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



                <div class="tab-pane" id="myclasssettings">
                    <div class="card">
                        <div class="card-header">

                            <h3 class="card-title">My Class Settings</h3>


                        </div>

                        <div class="card-body">

                            <form  role="form" id="inline-validation" class="form-horizontal form-stripe" action="<?php echo e(route('myclass.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="staffid" value="<?php echo e($sfid); ?>">


                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Select Class<span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                      <select name ="vschoolclassid" id="vschoolclassid"  class="form-control" required>
                                          <option value="" selected>Select Class </option>
                                           <?php $__currentLoopData = $myclasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($name->schoolclassID); ?>"><?php echo e($name->schoolclass); ?> <?php echo e($name->schoolarm); ?></option>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">No. of Time School Opened <span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                       <input type="number" name="noschoolopened" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Term ends <span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                        <input type="date" name="termends" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Next Term Begins <span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                        <input type="date" name="nexttermbegins" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Select Term<span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                      <select name ="termid" id="termid"  class="form-control" required>
                                          <option value="" selected>Select Term </option>
                                           <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($name->id); ?>"><?php echo e($name->term); ?></option>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Select Session <span class="text-danger">*</span></label>
                                    <div class="col-md-7">
                                        <select name ="sessionid" id="sessiionid"  class="form-control" >
                                            <option value="" selected>Select Session </option>
                                            <?php $__currentLoopData = $schoolsessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schoolsession => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <option value="<?php echo e($name->id); ?>"><?php echo e($name->session); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-7">
                                        <button type="submit" class="btn btn-primary">Submit</button>

                                    </div>
                                </div>
                            </form>



                            <div class="card">

                                <table class="table table-hover js-basic-example dataTable table-striped table_custom   ">
                                    <thead>
                                        <tr>

                                                <th>SN</th>
                                                <th>No. Times Sch. Opened</th>
                                                <th>Terms Ends</th>
                                                <th>Next Term Begins</th>
                                                <th>Term</th>
                                                <th>Session</th>
                                                <th>Actions</th>
                                                <th>Date Registered</th>



                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sn = 1; ?>
                                     <?php $__currentLoopData = $classsetting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                     <tr id="ssid<?php echo e($s->id); ?>">
                                         <td><?php echo e($sn++); ?></td>
                                         <td><?php echo e($s->noschoolopened); ?></td>
                                         <td><?php echo e($s->termends); ?></td>
                                         <td><?php echo e($s->nexttermbegins); ?></td>
                                         <td><?php echo e($s->term); ?></td>
                                         <td><?php echo e($s->session); ?></td>
                                         <td>
                                             <div class="btn-group">
                                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-classsettings')): ?>
                                             <a href="javascript:void(0)" class="btn fa fa-trash delete"
                                             data-toggle="tooltip" title="Delete Class Settings " onClick="check(<?php echo e($s->id); ?>)"></a>
                                         <?php endif; ?>
                                         </div></td>
                                         <td><?php echo e($s->created_at); ?></td>

                                     </tr>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>

        function check(id){

            var id = id;
            var spinner = $('#loader');

          Swal.fire({
          title: 'Are you sure?',
          text: "Deleting this record cannot be reversed",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            spinner.show();
            $.ajax({

                url: 'ajaxclasssettings/'+id,
                async: false,
                type: "DELETE",
                cache: false,
                data:{
                    _token:'<?php echo e(csrf_token()); ?>',
                   id: id
                },
                dataType: 'JSON',

            }).done(function(resp) {
          spinner.hide();

            });
            Swal.fire(
              'Deleted!',
              'This Record is now Deleted. ',
              'success'
            )

            var myobj = document.getElementById("ssid"+id);
             myobj.remove();

          }
        })

        }
    </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\srms\resources\views/myclass/index.blade.php ENDPATH**/ ?>