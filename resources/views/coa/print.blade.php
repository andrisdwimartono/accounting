<html>
    <head>
        <title>Print COA</title>
        <link rel="stylesheet" href="{{ asset ("/assets/bootstrap/dist/css/bootstrap.min.css") }}">
        <link href="{{ asset ("/assets/cto/css/cto_loadinganimation.min.css") }}" rel="stylesheet" />
    </head>
    <body>
    <div id="cto_overlay" class="overlay">
      <div id="cto_mengecek"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
    </div>
        <form id="formprint">
            @csrf
            <input type="hidden" name="category_filter" value="<?=$data->category_filter?>" />
            <input type="hidden" name="search[value]" value="<?=$data->search["value"]?>" />
            <input type="hidden" name="start" value="<?=$data->start?>" />
            <input type="hidden" name="length" value="<?=$data->length?>" />
        </form>
        <div class="container">
        <div class="row">
                <div class="col-sm-10 text-center">
                    <h1>Universitas Muhammadiyah Sidoarjo</h1>
                    <h3>Laporan </h3>
                </div>
                <div class="col-sm-2">
                    Logo
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table class="table">
                        <thead class="bg-dark text-white text-center font-weight-bold">
                            <tr>
                                <td scope="col">Kode</td>
                                <td scope="col">Nama</td>
                            </tr>
                        </thead>
                        <tbody id="table_body"></tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <script src="{{ asset ("/assets/jquery/js/jquery-3.6.0.min.js") }}"></script>
        <script src="{{ asset ("/assets/bootstrap/dist/js/bootstrap.bundle.min.js") }}"></script>
        <script src="{{ asset ("/assets/cto/js/cto_loadinganimation.min.js") }}"></script>

        <script>
            cto_loading_show();
            $.ajax({
                url: "/getlistcoa",
                type: "post",
                data: $("#formprint").serialize(),
                success: function(data){
                    var list_data = JSON.parse(data);
                    console.log(list_data);
                    for(var i = 0; i < list_data.data.length; i++){
                        var row = "<tr>";
                        var padd = ((parseInt(list_data.data[i][3])-1)*10)+"px";
                        row += "<td style=\"padding-left: "+padd+"\">"+convertCode(list_data.data[i][1])+"</td>";
                        row += "<td>"+list_data.data[i][2]+"</td>";
                        row += "</tr>";
                        $("#table_body").append(row);
                    }
                    
                    cto_loading_hide();
                },
                error: function (err) {
                    if (err.status == 422) {
                        $.each(err.responseJSON.errors, function (i, error) {
                            var validator = $("#quickForm").validate();
                            var errors = {};
                            errors[i] = error[0];
                            validator.showErrors(errors);
                        });
                    }
                    //cto_loading_hide();
                }
            });

            function convertCode(data){
                var val = "";
                for(var i = 0; i < data.length; i++){
                    if(i == 0){
                    val = val+data.charAt(i)+"-";
                    }else if(i == 2 || i == 4){
                    val = val+data.charAt(i)+"-";
                    }else if(i > 4 && (i-4)%3 == 0 && i != data.length-1){
                    val = val+data.charAt(i)+"-";
                    }else{
                    val = val+data.charAt(i);
                    }
                }
                return val;
            }
        </script>
    </body>
</html>