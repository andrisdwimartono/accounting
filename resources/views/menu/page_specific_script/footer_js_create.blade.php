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
                //set value child table
                var ctt1_menu = [];
                var table = $('#ctt1_menu').DataTable().rows().data();
                for(var i = 0; i < table.length; i++){
                    ctt1_menu.push({"ct1_m_sequence": table[i][0], "ct1_menu_name": table[i][1], "ct1_url": table[i][2], "ct1_menu_icon": table[i][3], "ct1_is_shown_at_side_menu": table[i][4], "id": table[i][table.columns().header().length-1]});
                }
                $('#ct1_menu').val(JSON.stringify(ctt1_menu));
                var id_{{$page_data["page_data_urlname"]}} = 0;
                var values = $('#quickForm').serialize();

                var ajaxRequest;
                ajaxRequest= $.ajax({
                    @if($page_data["page_method_name"] == "Update")
                    url: "/update{{$page_data["page_data_urlname"]}}/{{$page_data["id"]}}",
                    @else
                    url: "/store{{$page_data["page_data_urlname"]}}",
                    @endif
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
                                if(i == "ct1_m_sequence" || i == "ct1_menu_name" || i == "ct1_url" || i == "ct1_menu_icon" || i == "ct1_is_shown_at_side_menu"){
                                    errors["ct1_menu"] = error[0];
                                }else{
                                    errors[i] = error[0];
                                }
                                validator.showErrors(errors);
                            });
                        }
                        cto_loading_hide();
                    }
                });
            }
        });

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4' @if($page_data["page_method_name"] == "View"),
            disabled: true @endif
        })
        
        $('#quickForm').validate({
            rules: {
                mp_sequence: {
                    required: true,
                    digits: true
                },
                menu_name: {
                    required: true,
                    minlength: 4
                },
                url: {
                    required: true,
                    minlength: 1
                }
            },
            messages: {
                mp_sequence: {
                    required: "Please enter a Menu Pack Sequence",
                    digits: "Not a round number"
                },
                menu_name: {
                    required: "Please enter a menu name",
                    minlength: "Your Menu Name must be at least 4 characters long"
                },
                url: {
                    required: "Please enter a menu name",
                    minlength: "Your Url must be at least 1 characters long"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-sm-6').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        //childTabke ctm1_menu
        $('#ctf1_menu').validate({
            rules: {
                ct1_menu_name: {
                    required: true,
                    minlength: 4
                },
                ct1_url: {
                    required: true,
                    minlength: 4
                }
            },
            messages: {
                ct1_menu_name: {
                    required: "Please enter a menu name",
                    minlength: "Your Menu Name must be at least 4 characters long"
                },
                ct1_url: {
                    required: "Please enter a menu name",
                    minlength: "Your Url must be at least 4 characters long"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-sm-6').append(error);
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
        var table = $('#ctt1_menu').DataTable({
            @if($page_data["page_method_name"] != "View")
            rowReorder: true,
            @endif
            scrollX: true,
            bLengthChange: true,
            lengthChange: true,
            //add button
            dom: 'Blfrtip' @if($page_data["page_method_name"] != "View") ,
            buttons: [
                {
                    text: 'New',
                    action: function ( e, dt, node, config ) {
                        $("#ctm1_menu").modal({'show': true});
                        addChildTable("ctm1_menu");
                    }
                }
            ]
            @endif
        });

        $(".dt-buttons").css("margin-right", "30px");

        //hide last column, id
        table.column(table.columns().header().length-1).visible(false);

        $('#ctt1_menu tbody').on( 'click', '.row-show', function () {
            $("#ctm1_menu").modal({'show': true});
            showChildTable("ctm1_menu", table.row( $(this).parents('tr') ));
        } );

        //close modal
        $("#ctm1_menuClose").click(function(){
            $('#ctm1_menu').modal('hide');
        });

        //datatables with rowreorder
        table.on( 'row-reorder', function ( e, diff, edit ) {
                var result = 'Reorder started on row: '+edit.triggerRow.data()[1]+'<br>';
                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                    var rowData = table.row( diff[i].node ).data();
                    result += rowData[1]+' updated to be in position '+
                        diff[i].newData+' (was '+diff[i].oldData+')<br>';
                }
            $('#result').html( 'Event result:<br>'+result );
        } );

        $('#ctt1_menu tbody').on('click', '.row-delete', function () {
            table.row($(this).parents('tr')).remove().draw();
        });

        @if($page_data["page_method_name"] == "Update" || $page_data["page_method_name"] == "View")
        cto_loading_show();
        $.ajax({
            url: "/getdata{{$page_data["page_data_urlname"]}}",
            type: "post",
            data: {
                id: {{$page_data["id"]}},
                _token: $('#quickForm input[name=_token]').val()
            },
            success: function(data){
                for(var i = 0; i < Object.keys(data.data.{{$page_data["page_data_urlname"]}}).length; i++){
                    if(Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i] == 'pondok'){
                        //untuk link
                        var newState = new Option(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"_label"], data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]], true, false);
                        $("#pondok").append(newState).trigger('change'); 
                    }else{
                        $("input[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").prop('checked', ['on', 1].includes(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]) ? true: false);
                        $("input[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").val(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]);
                        $("select[name="+Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]+"]").val(data.data.{{$page_data["page_data_urlname"]}}[Object.keys(data.data.{{$page_data["page_data_urlname"]}})[i]]).change();
                    }
                }
                
                for(var i = 0; i < data.data.ct1_menu.length; i++){
                    var dttb = $('#ctt1_menu').DataTable();
                    var child_table_data = [data.data.ct1_menu[i].m_sequence, data.data.ct1_menu[i].menu_name, data.data.ct1_menu[i].url, data.data.ct1_menu[i].menu_icon, data.data.ct1_menu[i].is_shown_at_side_menu, @if($page_data["page_method_name"] != "View") '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>' @else '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>' @endif, data.data.ct1_menu[i].id];
                    if(dttb.row.add(child_table_data).draw( false )){
                        //$('#ctm1_menu').modal('hide');
                    }
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
        @endif
    } );

    function addChildTable(childtablename){
        $("input[name='ct1_menu_name']").val("");
        $("input[name='ct1_url']").val("");
        $("input[name='ct1_menu_icon']").val("");
        $("input[name='ct1_is_shown_at_side_menu']").prop('checked', false);

        @if($page_data["page_method_name"] != "View")
        $("#"+childtablename+" .modal-footer").html('<button type="button" id="ctm1_menuAdd" class="btn btn-primary">Add Row</button>');
        @endif

        $("#ctm1_menuAdd").click(function(){
            var dttb = $('#ctt1_menu').DataTable();
            var no = dttb.rows().count();
            var ct1_menu_name = $("input[name='ct1_menu_name']").val();
            var ct1_url = $("input[name='ct1_url']").val();
            var ct1_menu_icon = $("input[name='ct1_menu_icon']").val();
            var ct1_is_shown_at_side_menu = $("input[name='ct1_is_shown_at_side_menu']").prop('checked')?'on':null;
            // if($("input[name='ct1_is_shown_at_side_menu']").prop('checked')){
            //     ct1_is_shown_at_side_menu = 1;
            // }
            var child_table_data = [no+1, ct1_menu_name, ct1_url, ct1_menu_icon, ct1_is_shown_at_side_menu, '<div class="row-show"><i class="fa fa-eye" style="color:blue;cursor: pointer;"></i></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="row-delete"><i class="fa fa-trash" style="color:red;cursor: pointer;"></i></div>', null];
            if(dttb.row.add(child_table_data).draw( false )){
                $('#ctm1_menu').modal('hide');
            }
        });
    }

    function showChildTable(childtablename, data){
        $("input[name='ct1_menu_name']").val(data.data()[1]);
        $("input[name='ct1_url']").val(data.data()[2]);
        $("input[name='ct1_menu_icon']").val(data.data()[3]);
        $("input[name='ct1_is_shown_at_side_menu']").prop('checked', data.data()[4]);
        // if(data.data()[4] == 1){
        //     $("input[name='ct1_is_shown_at_side_menu']").prop('checked', true);
        // }

        @if($page_data["page_method_name"] != "View")
        $("#"+childtablename+" .modal-footer").html('<button type="button" id="ctm1_menuUpdate" class="btn btn-primary" onClick="updateChildTable("'+childtablename+'");">Update</button>');
        @endif

        $("#ctm1_menuUpdate").click(function(){
            //var no = data.data()[0];
            var temp = data.data();
            temp[1] = $("input[name='ct1_menu_name']").val();
            temp[2] = $("input[name='ct1_url']").val();
            temp[3] = $("input[name='ct1_menu_icon']").val();
            temp[4] = $("input[name='ct1_is_shown_at_side_menu']").prop('checked')?'on':null;
            // if($("input[name='ct1_is_shown_at_side_menu']").prop('checked')){
            //     temp[4] = 1;
            // }

            data.data(temp).invalidate();
            $('#ctm1_menu').modal('hide');
        });
    }
</script>
   