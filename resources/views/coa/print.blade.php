<html>
    <head>
        <title>Print COA</title>
        <link rel="stylesheet" href="{{ asset ("/assets/bootstrap/dist/css/bootstrap.min.css") }}">
        <link href="{{ asset ("/assets/cto/css/cto_loadinganimation.min.css") }}" rel="stylesheet" />
        <style>
            @page {
                size: A4;
                margin: 0;
            }
            @media print {
                html, body {
                    width: 210mm;
                    height: 297mm;
                }
            }
        </style>
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
                    <h2>Universitas Muhammadiyah Sidoarjo</h2>
                    <h4>Laporan Kode Rekening Akuntansi</h4>
                    <?php foreach($page_data["fieldsoptions"]["category"] as $cat){ 
                        if($cat["name"] == $data->category_filter){
                        ?>
                    <h5>Untuk Kategori <?=$cat["label"]?></h5>
                    <?php } } ?>
                </div>
                <div class="col-sm-2 align-middle">
                    <img class="logo-abbr" src="" width="100px">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead class="bg-secondary text-white text-center font-weight-bold">
                            <tr>
                                <td scope="col" width="100px">Kode</td>
                                <td scope="col" width="250px">Nama</td>
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
            $.ajax({
                url: "/getglobalsetting",
                type: "get",
                success: function(data){
                    $(".logo-abbr").attr("src", "/logo_instansi/"+data.data.globalsetting.logo_instansi);
                },
                error: function (err) {
                    console.log(err);
                }
            });
            cto_loading_show();
            $.ajax({
                url: "/getlistcoa",
                type: "post",
                data: $("#formprint").serialize(),
                success: function(data){
                    var list_data = JSON.parse(data);
                    for(var i = 0; i < list_data.data.length; i++){
                        var row = "<tr>";
                        var padd = 10+((parseInt(list_data.data[i][3])-1)*10)+"px";
                        var val = list_data.data[i][8] == "on"?"<span><b>"+convertCode(list_data.data[i][1])+"</b></span>":"<span>"+convertCode(list_data.data[i][1])+"</span>";
                        row += "<td style=\"padding-left: "+padd+"\">"+val+"</td>";
                        val = list_data.data[i][8] == "on"?"<span><b>"+list_data.data[i][2]+"</b></span>":"<span>"+list_data.data[i][2]+"</span>";
                        row += "<td>"+val+"</td>";
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