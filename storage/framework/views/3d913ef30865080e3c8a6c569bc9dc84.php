
<?php $__env->startSection('content'); ?>

     <!-- Start Page title and tab -->
     <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center ">
                <div class="header-action">
                    <h1 class="page-title">School</h1>
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Session</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Session</li>
                    </ol>
                </div>
                <ul class="nav nav-tabs page-header-tab">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('session-list')): ?>
                        <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#session">List View</a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add-session')): ?>
                    <li class="nav-item"><a class="nav-link" id="Library-tab-Boot" data-toggle="tab" href="#session-add"></a></li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('session-list')): ?>
                    <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#session"></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add-session')): ?>
                <li class="nav-item"><a class="nav-link" id="Library-tab-Boot" data-toggle="tab" href="#session-add">Add Session </a></li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('session-list')): ?>
                <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#session"></a></li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add-session')): ?>
            <li class="nav-item"><a class="nav-link" id="Library-tab-Boot" data-toggle="tab" href="#session-add"></a></li>
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


    </div>
    <div class="section-body mt-4">
        <div class="container-fluid">
            <div class="tab-content">
                <div class="tab-pane active" id="session">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-striped table_custom   ">
                                    <thead>
                                        <tr>

                                                <th>SN</th>
                                                <th>Session</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th>Date Registered</th>
                                                <th>Date Updated</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sn = 1; ?>
                                     <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                     <tr id="sid<?php echo e($session->id); ?>">
                                         <td><?php echo e($sn++); ?></td>
                                         <td><?php echo e($session->session); ?></td>
                                         <td><?php echo e($session->status); ?></td>

                                         <td>
                                             <div class="btn-group">
                                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-session')): ?>
                                             <a href="<?php echo e(route('session.edit',$session->id)); ?>" class="btn fa fa-pencil" data-toggle="tooltip" title="Edit Session"></a>
                                             <?php endif; ?>
                                             </div>
                                             <div class="btn-group">
                                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-session')): ?>
                                             <a href="javascript:void(0)" class="btn fa fa-trash delete"
                                             data-toggle="tooltip" title="Delete Session " onClick="check(<?php echo e($session->id); ?>)"></a>
                                         <?php endif; ?>
                                         </div></td>
                                         <td><?php echo e($session->created_at); ?></td>
                                         <td><?php echo e($session->updated_at); ?></td>
                                     </tr>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="session-add">
                    <div class="card">

                        <div class="card-header">

                            <h3 class="card-title">Add Session</h3>

                            <?php if(count($errors) > 0): ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"></button>
                                <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                            <div class="card-options ">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                            </div>
                        </div>
                        <form  role="form" id="inline-validation" class="form-horizontal form-stripe" action="<?php echo e(route('session.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Session Name <span class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="session" name="session" placeholder="Session" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Select Session Status <span class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <select name ="status" id="status"  class="form-control" >
                                        <option value="" selected>Select Session Status</option>
                                        <option value="Current">Current</option>
                                        <option value="Past">Past</option>
                                         </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"></label>
                                <div class="col-md-7">
                                    <button type="submit" class="btn btn-primary">Submit</button>

                                </div>
                            </div>
                            <?php echo Form::close(); ?>

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
          text: "Deleting this record will affect other associated records (e.g Any Record where this Session is featured)",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            spinner.show();
            $.ajax({

                url: 'ajaxsession/'+id,
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
              'This Session Record Has Been Deleted!',
              'success'
            )

            var myobj = document.getElementById("sid"+id);
             myobj.remove();

          }
        })

        }
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\srms\resources\views/session/index.blade.php ENDPATH**/ ?>