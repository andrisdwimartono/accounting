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

        <script type="text/javascript">
            $(document).ready(function () {
                $.toast({
                    text: "Don't forget to star the repository if you like it.",
                    heading: 'Status',
                    icon: 'warning',
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 3000,
                    position: 'mid-center',
                    textAlign: 'left'
                });
            });
        </script>

        <script type="text/javascript">
        $(function () {
        
            $("#datetimecoba").datetimepicker({
                format: 'mm/dd/yyyy HH:MM',
                modal: true,
                footer: true,
                uiLibrary: 'bootstrap'
            });

            $("#datecoba").datepicker({
                format: 'mm/dd/yyyy',
                modal: true,
                footer: true,
                uiLibrary: 'bootstrap'
            });
        
            $.validator.setDefaults( {
                submitHandler: function () {

                    alert( "submitted!" );

                }
            } );
        });

            $( document ).ready( function () {
                //select2
                $('select').select2({
                    theme: 'bootstrap4'
                });

                $('#example').DataTable({
                    rowReorder: true,
                    dom: "Bfrtip",
                    buttons: [
                        {
                            text: "New",
                            action: function ( e, dt, node, config ) {
                                $("#staticBackdrop_ct1_multilanguagedetail").modal({"show": true});
                                addChildTable_ct1_multilanguagedetail("staticBackdrop_ct1_multilanguagedetail");
                            }
                        }
                    ]
                });

                $( "#quickForm" ).validate( {
                    rules: {
                        firstname: "required",
                        lastname: "required",
                        username: {
                            required: true,
                            minlength: 2
                        },
                        password: {
                            required: true,
                            minlength: 5
                        },
                        confirm_password: {
                            required: true,
                            minlength: 5,
                            equalTo: "#password"
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        agree: "required"
                    },
                    messages: {
                        firstname: "Please enter your firstname",
                        lastname: "Please enter your lastname",
                        username: {
                            required: "Please enter a username",
                            minlength: "Your username must consist of at least 2 characters"
                        },
                        password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long"
                        },
                        confirm_password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long",
                            equalTo: "Please enter the same password as above"
                        },
                        email: "Please enter a valid email address",
                        agree: "Please accept our policy"
                    },
                    errorElement: "em",
                    errorPlacement: function ( error, element ) {
                        // Add the `invalid-feedback` class to the error element
                        error.addClass( "invalid-feedback" );

                        if ( element.prop( "type" ) === "checkbox" ) {
                            error.insertAfter( element.next( "label" ) );
                        } else {
                            error.insertAfter( element );
                        }
                    },
                    highlight: function ( element, errorClass, validClass ) {
                        $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
                    }
                } );

            } );
        </script>