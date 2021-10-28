        <script src="{{ asset ("/assets/jquery/js/jquery-3.6.0.min.js") }}"></script>
        <script src="{{ asset ("/assets/node_modules/@popperjs/core/dist/umd/popper.min.js") }}"></script>
        <script src="{{ asset ("/assets/node_modules/gijgo/js/gijgo.min.js") }}"></script>
        <script src="{{ asset ("/assets/node_modules/jquery-toast-plugin/dist/jquery.toast.min.js") }}"></script>
        <script src="{{ asset ("/assets/bootstrap/dist/js/bootstrap.bundle.min.js") }}"></script>
        <script src="{{ asset ("/assets/bower_components/jquery-validation/dist/jquery.validate.min.js") }}"></script>
        <script src="{{ asset ("/assets/bower_components/select2/dist/js/select2.full.min.js") }}"></script>
        <script src="{{ asset ("/assets/node_modules/plotly.js-dist/plotly.js") }}"></script>
        <script src="{{ asset ("/assets/cto/js/cakrudtemplate.js") }}"></script>
        <script src="{{ asset ("/assets/cto/js/cto_loadinganimation.min.js") }}"></script>
        <script src="{{ asset ("/assets/cto/js/dateformatvalidation.min.js") }}"></script>

        <script type="text/javascript">
        $(function () {
            $("#start_date").datepicker({
                format: 'dd/mm/yyyy',
                uiLibrary: 'bootstrap'
            });

            $("#finish_date").datepicker({
                format: 'dd/mm/yyyy',
                uiLibrary: 'bootstrap'
            });
        
            $.validator.setDefaults({
                submitHandler: function (form, event) {
                    event.preventDefault();
                    cto_loading_show();
                    var quickForm = $("#quickForm");

                    var values = $('#quickForm').serialize();
                    var ajaxRequest;
                    ajaxRequest = $.ajax({
                        url: "/getchart{{$page_data["page_data_urlname"]}}total",
                        type: "post",
                        data: values,
                        success: function(data){
                            if(data.status >= 200 && data.status <= 299){
                                create_chart(data);
                            }
                            cto_loading_hide();
                            
                        },
                        error: function (err) {
                            if (err.status == 422) {
                                var error_text = "" ;
                                $.each(err.responseJSON.errors, function (i, error) {
                                    var validator = $("#quickForm").validate();
                                    var errors = {};
                                    errors[i] = error[0];
                                    error_text += (error[0]+", ");
                                    validator.showErrors(errors);
                                });
                                $.toast({
                                    text: error_text,
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
                }
            });
        });

        $( document ).ready( function () {
            $('select').select2({
                theme: 'bootstrap4'
            });

            $( "#quickForm" ).validate( {
                rules: {
                    start_date: {
                        required: true,
                        dateFormat_1: true
                    },
                    finish_date: {
                        required: true,
                        dateFormat_1: true
                    }
                },
                messages: {
                    start_date: {
                        required: "Pilih Start Date",
                        dateFormat_1: "Format tanggal harus dd/mm/yyyy"
                    },
                    finish_date: {
                        required: "Pilih Finish Date",
                        dateFormat_1: "Format tanggal harus dd/mm/yyyy"
                    }
                },
                errorElement: "em",
                errorPlacement: function ( error, element ) {
                    error.addClass('invalid-feedback');
                    element.closest('.col-sm-2').append(error);
                },
                highlight: function ( element, errorClass, validClass ) {
                    $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
                },
                unhighlight: function (element, errorClass, validClass) {
                    $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
                }
            } );
        });

        function create_chart(data){
            var exp = "x + 17";

            // Generate values
            var xValues = [];
            var yValues = [];
            // for (var x = 0; x <= 10; x += 1) {
            // xValues.push(x);
            // yValues.push(eval(exp));
            // }
            var xHighest = 0;
            for(var i = 0; i < data.data.user.length; i++){
                xValues.push(data.data.user[i].created_at);
                yValues.push(data.data.user[i].total);
            }

            // Define Data
            var data = [{
                x: xValues,
                y: yValues,
                mode:"bar"
            }];

            // Define Layout
            var layout = {title: "y = " + exp,
                yaxis: {title: "Jumlah"}
            };

            // Display using Plotly
            Plotly.newPlot("myPlot", data, layout);
        }
        </script>