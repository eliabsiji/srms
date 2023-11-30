"use strict";

// Class definition
var KTUsersUpdatePermissions = function () {
    // Shared variables
    const element = document.getElementById('kt_modal_update_role');
    const form = element.querySelector('#kt_modal_update_role_form');
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initUpdatePermissions = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'house': {
                        validators: {
                            notEmpty: {
                                message: 'House name is required'
                            }
                        }
                    },
                    'housecolour': {
                        validators: {
                            notEmpty: {
                                message: 'House Colour  is required'
                            }
                        }
                    },
                    'housemasterid': {
                        validators: {
                            notEmpty: {
                                message: 'House master  is required'
                            }
                        }
                    },
                    'termid': {
                        validators: {
                            notEmpty: {
                                message: 'Term is required'
                            }
                        }
                    },
                    'sessionid': {
                        validators: {
                            notEmpty: {
                                message: 'Session is required'
                            }
                        }
                    },

                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Close button handler
        const closeButton = element.querySelector('[data-kt-roles-modal-action="close"]');
        closeButton.addEventListener('click', e => {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to close?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, close it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    modal.hide(); // Hide modal
                }
            });
        });

        // Cancel button handler
        const cancelButton = element.querySelector('[data-kt-roles-modal-action="cancel"]');
        cancelButton.addEventListener('click', e => {
            e.preventDefault();

            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form
                    modal.hide(); // Hide modal
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });

        // Submit button handler
        const submitButton = element.querySelector('[data-kt-roles-modal-action="submit"]');
        submitButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;

                        // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        setTimeout(function () {
                            // Remove loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;

                            // Show popup confirmation
                            Swal.fire({
                                text: "Form has been successfully submitted!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    modal.hide();
                                }
                            });

                            form.submit(); // Submit form
                        }, 2000);
                    } else {
                        // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        });
    }

    // Select all handler
    const handleSelectAll = () => {
        // Define variables
        const selectAll = form.querySelector('#kt_roles_select_all');
        const allCheckboxes = form.querySelectorAll('[type="checkbox"]');

        // Handle check state
        selectAll.addEventListener('change', e => {

            // Apply check state to all checkboxes
            allCheckboxes.forEach(c => {
                c.checked = e.target.checked;
            });
        });
    }

    return {
        // Public functions
        init: function () {
            initUpdatePermissions();
            handleSelectAll();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdatePermissions.init();
});


$(function () {


        var arr = [];
        $("#elmt").find('option').each(function() {
            arr.push($(this).text());
        });

    // ON SELECTING ROW
    $(".sel-house").click(function () {
      //FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
        var id = $(this).parents("tr").find("#tid").val();
        var a = $.trim($(this).parents("tr").find(".schoolhouse").text());
        var b = $.trim($(this).parents("tr").find(".housecolour").text());
        var c = $(this).parents("tr").find("#housemaster").val();
        var d = $.trim($(this).parents("tr").find(".termid").text());
        var e = $.trim($(this).parents("tr").find(".sessionid").text());

     var term_options = $('#termid option');
     var term_values = $('#termid option');
     var option_term = $.map(term_options, e=>$(e).val());
     var value_term = $.map(term_values, e=>$(e).text());
        alert(option_term);
        alert(value_term);


        function createAssociativeArray(arr1, arr2) {
            var arr = new Object();
            for(var i = 0, ii = arr1.length; i<ii; i++) {
                arr[arr1[i]] = arr2[i];
            }
            return arr;
        }

        function getObjectPropertiesLength(obj) {
            var propNum = 0;
            for(prop in obj) {
                if(obj.hasOwnProperty(prop)) propNum++;
            }
            return propNum;
        }

        var p = getObjectPropertiesLength(associativeArray);
        var array1 = ["key1", "Key2", "Key3"];
        var array2 = ["Value1", "Value2", "Value3"];
        var associativeArray = createAssociativeArray(array1, array2);
        // getting keys using getOwnPropertyNames
        const keys = Object.getOwnPropertyNames(associativeArray);
        console.log("Keys are listed below ");

        // Display output
        console.log(keys);



        // CREATING DATA TO SHOW ON MODEL

        var  content = "";
        content +='<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">'

       + '<div class="fv-row mb-10">'
        +'<input type="hidden"  name="id" value="'+id+'" />'



        +'<div class="fv-row mb-7">'

        +'<label class="required fw-semibold fs-6 mb-2">House Name</label>'



        +'<input type="text" name="house" id="house" value="'+a+'" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="House Name ..."  />'

        +'</div>'




        +' <div class="fv-row mb-7">'

        +'<label class="required fw-semibold fs-6 mb-2">House Colour</label>'



        +'<input type="text" name="housecolour" id="housecolour" value="'+b+'" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="House Colour ..."  />'

        +'</div>'




        +'<div class="mb-7">'

        +'<label class="required fw-semibold fs-6 mb-5">Select House Master</label>'

        +'<div class="fv-row mb-7">'


        +' <select name ="housemasterid" id="housemasterid" class="form-control form-control-solid mb-3 mb-lg-0"  >'
        +'<option value="" selected>Select House master</option>'
        +'@foreach ($staff as $st => $name )'
        +' <option value="{{$name->userid}}">{{ $name->name }}  </option>'
        +' @endforeach'
        +'</select>'

        +'<input class="form-control form-control-solid"  value="'+c+'" readonly/>'
        +' </div>'

        +' </div>'



                    +'  </div>';

        var sel= "";
            sel += '<select name ="sessionid" id="sessionid" class="form-control form-control-solid mb-3 mb-lg-0">'
            +'<option value="" selected>Select Session </option>'
            +'<?php print_r($staff);?>'
            +' @foreach ($schoolsession as $schoolsession => $name )'
            +' <option value="{{$name->id}}">{{ $name->session}}</option>'
            +' @endforeach'
            +'</select>';
        //CLEARING THE PREFILLED DATA
        //$("#content").empty();

        //WRITING THE DATA ON MODEL
        $("#content").append(sel);


    });
});
