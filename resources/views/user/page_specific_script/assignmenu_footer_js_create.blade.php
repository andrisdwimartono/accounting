    <script src="{{ asset ("/assets/jquery/js/jquery-3.6.0.min.js") }}"></script>
    <script src="{{ asset ("/assets/node_modules/@popperjs/core/dist/umd/popper.min.js") }}"></script>
    <script src="{{ asset ("/assets/node_modules/gijgo/js/gijgo.min.js") }}"></script>
    <script src="{{ asset ("/assets/node_modules/jquery-toast-plugin/dist/jquery.toast.min.js") }}"></script>
    <script src="{{ asset ("/assets/bootstrap/dist/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset ("/assets/bower_components/jquery-validation/dist/jquery.validate.min.js") }}"></script>
    <script src="{{ asset ("/assets/bower_components/select2/dist/js/select2.full.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.bootstrap4.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.rowReorder.min.js") }}"></script>
    <script src="{{ asset ("/assets/datatables/js/dataTables.buttons.min.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/cakrudtemplate.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/cto_loadinganimation.min.js") }}"></script>
    <script src="{{ asset ("/assets/cto/js/dateformatvalidation.min.js") }}"></script>
<script>
    
    //variabel editor untuk datatables
    var editor; 
    $(function () {
        //Date picker
        @if($page_data["page_method_name"] != "View")
        $('#reservationdate').datetimepicker({
            format:'DD/MM/YYYY'
        });
        @endif

        $.validator.setDefaults({
            submitHandler: function (form, event) {
                event.preventDefault();
                cto_loading_show();
                var quickForm = $('#quickForm');
                var id_{{$page_data["page_data_urlname"]}} = 0;
                var values = $('#quickForm').serialize();
                var ajaxRequest;
                ajaxRequest= $.ajax({
                    url: "/updateassignmenu{{$page_data["page_data_urlname"]}}/{{$page_data["id"]}}",
                    type: "post",
                    data: values,
                    success: function(data){
                        if(data.status >= 200 && data.status <= 299){
                            id_{{$page_data["page_data_urlname"]}} = data.data.id;
                            $.toast({
                                text: data.message,
                                heading: 'Status',
                                icon: 'success',
                                showHideTransition: 'fade',
                                allowToastClose: true,
                                hideAfter: 3000,
                                position: 'mid-center',
                                textAlign: 'left'
                            });
                        }
                        cto_loading_hide();
                    },
                    error: function (err) {
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            $.each(err.responseJSON.errors, function (i, error) {
                                var validator = $("#quickForm").validate();
                                var errors = {}
                                errors[i] = error[0];
                                validator.showErrors(errors);
                            });
                        }
                        cto_loading_hide();
                    }
                });
            }
        });

        $('select').select2({
            theme: 'bootstrap4' @if($page_data["page_method_name"] == "View"),
            disabled: true @endif
        });

        $.ajax({
            url: "/getoptions{{$page_data["page_data_urlname"]}}",
            type: "post",
            data: {
                fieldname: "role",
                _token: $("#quickForm input[name=_token]").val()
            },
            success: function(data){
                var newState = new Option("", "", true, false);
                $("#role").append(newState).trigger("change");
                for(var i = 0; i < data.length; i++){
                    newState = new Option(data[i].label, data[i].name, true, false);
                    $("#role").append(newState).trigger("change");
                }
            },
            error: function (err) {
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function (i, error) {
                        var validator = $("#quickForm").validate();
                        var errors = {}
                        errors[i] = error[0];
                        validator.showErrors(errors);
                    });
                }
            }
        });
        
        $('#quickForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 4
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                name: {
                    required: "Please enter a name",
                    minlength: "Your Name must be at least 4 characters long"
                },
                email: {
                    required: "Please enter a email address"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 6 characters long"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    $(document).ready(function() {
        @if($page_data["page_method_name"] == "Update" || $page_data["page_method_name"] == "View")
        cto_loading_show();
        $.ajax({
            url: "/getdataassignmenu{{$page_data["page_data_urlname"]}}",
            type: "post",
            data: {
                id: {{$page_data["id"]}},
                _token: $('#quickForm input[name=_token]').val()
            },
            success: function(data){
                for(var i = 0; i < data.data.user_menus.length; i++){
                    if(data.data.user_menus[i].is_granted == 'on')
                        $('#menu_'+data.data.user_menus[i].menu_id).prop('checked', true);
                }
                $("select[name=role]").val(data.data.user.role).change();
                cto_loading_hide();
                $("#role").on("change", function() {
                    $("#role_label").val($('#role option:selected').text());
                    $.ajax({
                        url: "/getdataassignmenu{{$page_data["page_data_urlname"]}}role",
                        type: "post",
                        data: {
                            role: $('#quickForm select[name=role]').val(),
                            _token: $('#quickForm input[name=_token]').val()
                        },
                        success: function(data){
                            if(data.data.user_menus.length == 0){
                                $.toast({
                                    text: "Tidak ada data",
                                    heading: 'Status',
                                    icon: 'warning',
                                    showHideTransition: 'fade',
                                    allowToastClose: true,
                                    hideAfter: 3000,
                                    position: 'mid-center',
                                    textAlign: 'left'
                                });
                            }
                            for(var i = 0; i < data.data.user_menus.length; i++){
                                if(data.data.user_menus[i].is_granted == 'on')
                                    $('#menu_'+data.data.user_menus[i].menu_id).prop('checked', true);
                                else
                                    $('#menu_'+data.data.user_menus[i].menu_id).prop('checked', false);
                            }
                            cto_loading_hide();
                        },
                        error: function (err) {
                            if (err.status >= 400 && err.status <= 500) {
                                $.toast({
                                    text: err.status+"\n"+err.responseJSON.message,
                                    heading: 'Status',
                                    icon: 'warning',
                                    showHideTransition: 'fade',
                                    allowToastClose: true,
                                    hideAfter: 3000,
                                    position: 'mid-center',
                                    textAlign: 'left'
                                });
                            }
                            cto_loading_hide();
                        }
                    });
                });
            },
            error: function (err) {
                if (err.status >= 400 && err.status <= 500) {
                    $.toast({
                        text: err.status+"\n"+err.responseJSON.message,
                        heading: 'Status',
                        icon: 'warning',
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        position: 'mid-center',
                        textAlign: 'left'
                    });
                }
                cto_loading_hide();
            }
        });
        @endif
    } );
</script>