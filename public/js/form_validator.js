(function ($, W, D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
            {
                setupFormValidation: function ()
                {
                    //form validation rules
                    $("#login-form").validate({
                        rules: {
                            username: "required",
                            password: {
                                required: true,
//                                minlength: 5
                            }
                        },
                        messages: {
                            username: "Please enter your username",
                            password: {
                                required: "Please provide a password",
//                                minlength: "Your password must be at least 5 characters long"
                            }
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_dir").validate({
                        rules: {
                            dir_name: "required"
                        },
                        messages: {
                            dir_name: "Please enter directorate name"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_mm").validate({
                        rules: {
                            main_menu_name: "required"
                        },
                        messages: {
                            main_menu_name: "Please enter main menu"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_sm").validate({
                        rules: {
                            sub_menu_name: "required"
                        },
                        messages: {
                            sub_menu_name: "Please enter sub menu"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_flr").validate({
                        rules: {
                            flr_name: "required"
                        },
                        messages: {
                            dir_name: "Please enter floor name"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_pos").validate({
                        rules: {
                            pos_name: "required"
                        },
                        messages: {
                            pos_name: "Please enter position name"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_bui").validate({
                        rules: {
                            pos_name: "required"
                        },
                        messages: {
                            pos_name: "Please enter building name"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_ds").validate({
                        rules: {
                            ds_name: "required"
                        },
                        messages: {
                            ds_name: "Please enter device status name"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_dt").validate({
                        rules: {
                            dt_name: "required"
                        },
                        messages: {
                            dt_name: "Please enter device type"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_db").validate({
                        rules: {
                            db_name: "required",
                            dt_name: "required"
                        },
                        messages: {
                            db_name: "Please enter device brand",
                            dt_name: "Please enter device type"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_tea").validate({
                        rules: {
                            directorate_name: "required",
                            team_name: "required",
                            team_leader: "required"
                        },
                        messages: {
                            directorate_name: "Please select directorate name",
                            team_name: "Please enter team name",
                            team_leader: "Please enter team leader"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_page").validate({
                        rules: {
                            main_menu: "required",
                            sub_menu: "required",
                            func_id: "required",
                            'page[]': {
                                required: true
                            }
                        },
                        messages: {
                            main_menu: "Please select main menu",
                            sub_menu: "Please select sub menu",
                            func_id: "Please select functionality",
                            'page[]': {
                                required: " Please select at least one page"
                            }
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_cas").validate({
                        rules: {
                            case_id: "required",
                            //case_area: "required",
                            case_type: "required",
                            case_name: "required",
                            case_details: "required"
//                        solution_name: "required",
//                        solution_details: "required"
                        },
                        messages: {
                            case_id: "Please enter case id",
                            //case_area: "Please enter case area",
                            case_type: "Please select case type",
                            case_name: "Please enter case name",
                            case_details: "Please enter case details"
//                        solution_name: "Please enter solution name",
//                        solution_details: "Please enter solution details"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_fun").validate({
                        rules: {
                            functionality_name: "required",
                            role_id: "required",
                        },
                        messages: {
                            functionality_name: "Please enter functionality name",
                            role_id: "Please select role id"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_rof").validate({
                        rules: {
                            role_id: "required",
                            'functionality_id[]': {
                                required: true
                            }
                        },
                        messages: {
                            role_id: "Please select role name",
                            'functionality_id[]': {
                                required: " Please select at least one permission"
                            }
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_pf_edit").validate({
                        rules: {
                            'page[]': {
                                required: true
                            }
                        },
                        messages: {
                            'page[]': {
                                required: " Please select at least one page"
                            }
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_sta").validate({
                        rules: {
                            status_name: "required",
                            status_for: "required"

                        },
                        messages: {
                            status_name: "Please enter status name",
                            status_for: "Please select status for"

                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_rol").validate({
                        rules: {
                            role_name: "required"

                        },
                        messages: {
                            role_name: "Please enter role name"

                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_req").validate({
                        rules: {
                            request_area: "required",
                            request_type: "required",
                            request_details: "required"
                        },
                        messages: {
                            request_area: "Please select request area",
                            request_type: "Please select request type",
                            request_details: "Please enter request detail"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });
                    $("#frm_sol").validate({
                        rules: {
                            case_id: "required",
                            additional_solution: "required"
//                            request_status: "required"
                        },
                        messages: {
                            case_id: "Please select case",
                            additional_solution: "Please provide additional solution"
//                            request_status: "Please enter case name"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });

                    $("#frm_dev").validate({
                        rules: {
                            device_type: "required",
                            device_brand: "required",
                            tag_number: "required",
                            hard_disk_size: "required",
                            ram_size: "required",
                            status: "required",
//                        remark: "required"

                        },
                        messages: {
                            device_type: "Please select device type",
                            device_brand: "Please select device brand",
                            tag_number: "Please enter tag number",
                            hard_disk_size: "Please enter hard disk size",
                            ram_size: "Please enter ram size",
                            status: "please select status",
//                        remark: "Please enter remark"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });



                    $("#frm_use").validate({
                        rules: {
                            full_name: "required",
                            user_name: "required",
                            building: "required",
                            floor: "required",
                            directorate: "required",
                            team: "required",
                            position: "required",
                            user_password: "required",
                            phone_number: "required",
                            email: {
//                            required: true,
                                email: true},
                            roles: "required",
                            status: "required"
                        },
                        messages: {
                            full_name: "Please enter user full name",
                            user_name: "Please enter user name",
                            building: "Please select building",
                            floor: "Please select floor",
                            directorate: "Please select directorate",
                            team: "Please select team",
                            team: "Please team position",
                                    user_password: "Please enter password",
                            phone_number: "Please enter phone number",
                            email: "Please enter a valid email address",
                            roles: "Please select role",
                            status: "Please select status"
                        },
                        submitHandler: function (form) {
                            form.submit();
                        }
                    });

                }
            }

    //when the dom has loaded setup form validation rules
    $(D).ready(function ($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);


function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
