<?php $__env->startSection('content'); ?>

            <!--begin::Main-->
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">

                <!--begin::Toolbar-->
                <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">

                            <!--begin::Toolbar container-->
                        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">

                            <!--begin::Page title-->
                            <div  class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                                <!--begin::Title-->
                                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                             MY Record Room
                                        </h1>
                                <!--end::Title-->


                                    <!--begin::Breadcrumb-->
                                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                                        <!--begin::Item-->
                                                        <li class="breadcrumb-item text-muted">
                                                            <a href="<?php echo e(route('myresultroom.index')); ?>" class="text-muted text-hover-primary">School House </a>
                                                                        </li>
                                                            <!--end::Item-->
                                                                <!--begin::Item-->
                                                <li class="breadcrumb-item">
                                                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                                </li>
                                                <!--end::Item-->

                                                        <!--begin::Item-->
                                                                <li class="breadcrumb-item text-muted">My Result Room</li>
                                                            <!--end::Item-->

                                                </ul>
                                    <!--end::Breadcrumb-->
                                </div>
                            <!--end::Page title-->
                                <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <?php endif; ?>

                                <?php if(\Session::has('status')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo e(\Session::get('status')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php endif; ?>
                                <?php if(\Session::has('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo e(\Session::get('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php endif; ?>

                            </div>
                            <!--end::Toolbar container-->
                        </div>
                    <!--end::Toolbar-->


                    <div id="kt_app_content" class="app-content  flex-column-fluid " >
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container  container-xxl ">

                   <!--begin::Toolbar-->
                        <div class="d-flex flex-wrap flex-stack my-5">
                            <!--begin::Heading-->
                            <h2 class="fs-2 fw-semibold my-2">
                             MY Record Room
                                <span class="fs-6 text-gray-400 ms-1">Database</span>
                            </h2>
                            <!--end::Heading-->


                        </div>
                    <!--end::Toolbar-->



        <!--begin::Card-->
    <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">

                  <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                              <!--begin::Toolbar-->
                                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                                <!--begin::Add user-->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                                                   My Result Room
                                                </button>
                                                <!--end::Add user-->
                                    </div>



                                    </div>
                                    <!--end::Card toolbar-->
                                            <!--begin::Card toolbar-->
                                            <div class="card-toolbar">
                                                <!--begin::Search-->
                                                <div class="d-flex align-items-center position-relative my-1"  data-kt-view-roles-table-toolbar="base">
                                                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>                <input type="text" data-kt-roles-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search ..." />
                                                </div>
                                                <!--end::Search-->

                                                <!--begin::Group actions-->
                                                <div class="d-flex justify-content-end align-items-center d-none" data-kt-view-roles-table-toolbar="selected">
                                                    <div class="fw-bold me-5">
                                                        <span class="me-2" data-kt-view-roles-table-select="selected_count"></span> Selected
                                                    </div>

                                                    <button type="button" class="btn btn-danger" data-kt-view-roles-table-select="delete_selected">
                                                        Delete Selected
                                                    </button>
                                                </div>
                                                <!--end::Group actions-->
                                            </div>
                                            <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <?php if(count($errors) > 0): ?>
            <div class="row animated fadeInUp">
                <?php if(count($errors) > 0): ?>
            <div class="alert alert-warning fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>
            </div>
            <?php endif; ?>
            <!--begin::Card body-->
            <div class="card-body py-4">
                <?php
                use App\Models\Broadsheet;

                ?>

             <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_roles_view_table">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_roles_view_table .form-check-input" value="1" />
                        </div>
                    </th>
                    <th class="min-w-125px" style="color: rgb(51, 35, 200)">SN</th>
                    <th class="min-w-125px" style="color: rgb(51, 35, 200)">Class</th>
                    <th class="min-w-125px" style="color: rgb(51, 35, 200)">Arm</th>

                    <th class="min-w-125px" style="color: rgb(51, 35, 200)">Subject</th>
                    <th class="min-w-125px" style="color: rgb(51, 35, 200)">Subject Code</th>
                    <th class="min-w-125px" style="color: rgb(51, 35, 200)">Term</th>
                    <th class="min-w-125px" style="color: rgb(51, 35, 200)">Session</th>
                    <th class="min-w-125px" style="color: rgb(51, 35, 200)">Score Sheet</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                <?php
                 $i = 0
               ?>
              <?php $__currentLoopData = $mysubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-url="">
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td ><?php echo e(++$i); ?></td>
                        <td ><?php echo e($subject->schoolclass); ?> </td>
                        <td ><?php echo e($subject->arm); ?></td>
                        <td ><?php echo e($subject->subject); ?> </td>
                        <td ><?php echo e($subject->subjectcode); ?> </td>
                        <td><?php echo e($subject->term); ?></td>
                        <td><?php echo e($subject->session); ?></td>
                        <td >
                            <?php

                            $broadsheetchk = Broadsheet::where('staffid',$subject->userid)
                             ->where('subjectclassid',$subject->subclassid)
                             ->where('termid',$subject->termid)
                             ->where('session',$subject->sessionid)->exists();

                                   ?>
                             <?php if($broadsheetchk): ?>

                             <a href="subjectscoresheet/<?php echo e($subject->schoolclassid); ?>/<?php echo e($subject->subclassid); ?>/<?php echo e($subject->userid); ?>/<?php echo e($subject->termid); ?>/<?php echo e($subject->sessionid); ?>" class="btn btn-success" data-toggle="tooltip" title="Open Score Sheet for <?php echo e($subject->subject); ?>  <?php echo e($subject->subjectcode); ?> " >Open Score Sheet</a>

                             <?php else: ?>
                             <a href="#" class="btn btn-warning" data-toggle="tooltip" title=" <?php echo e($subject->subject); ?>  <?php echo e($subject->subjectcode); ?> has not been registered by any student yet ">No Scoresheet yet</a>
                             <?php endif; ?>
                        </td>

             </tr>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
        </table>
        <!--end::Table-->
            </div>
            <!--end::Card body-->
      </div>
            <!--end::Card-->
    </div>

            <!--end::Content container-->
</div>
        <!--end::Content-->


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\srms\resources\views/myresultroom/index.blade.php ENDPATH**/ ?>