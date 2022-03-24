$(document).ready(function () {
    $.ajax({
        url: "/getrolemenu",
        type: "get",
        success: function(data){
          $("#cakmenu-dashboard").removeClass(" show active")
          $("#cakmenu-master").removeClass(" show active")
          $("#cakmenu-transaksi").removeClass(" show active")
          $("#cakmenu-laporan").removeClass(" show active")
          $("#cakmenu-ebudgeting").removeClass(" show active")

          $("#caknav-dashboard").removeClass(" active")
          $("#caknav-master").removeClass(" active")
          $("#caknav-transaksi").removeClass(" active")
          $("#caknav-laporan").removeClass(" active")
          $("#caknav-ebudgeting").removeClass(" active")

          for(var i = 0; i < data.data.user_menus.length; i++){
            $("#cakmenu-"+data.data.user_menus[i].mainmenu).removeClass("d-none");
          }
          var current_url = $("#cakcurrent_url").val();
          if(['user', 'unitkerja', 'coa', 'role'].includes(current_url)){
            $("#caknav-master").addClass("active");
            $("#cakmenu-master").addClass(" show active");
          }else if(['jurnal','jurnalbkk','jurnalbkm','jurnalbbm','jurnalbbk'].includes(current_url)){
            $("#caknav-transaksi").addClass("active");
            $("#cakmenu-transaksi").addClass(" show active");
          }else if(['bukubesar', 'aruskas', 'neraca', 'neracasaldo', 'labarugi'].includes(current_url)){
            $("#caknav-laporan").addClass("active");
            $("#cakmenu-laporan").addClass(" show active");
          }else if(['saldoawal','opencloseperiode','globalsetting'].includes(current_url)){
            $("#caknav-settings").addClass("active");
            $("#cakmenu-settings").addClass(" show active");
          }else if(['ikuunitkerja','iktunitkerja','kegiatan'].includes(current_url)){
            $("#caknav-ebudgeting").addClass("active");
            $("#cakmenu-ebudgeting").addClass(" show active");
          }else{
            $("#caknav-dashboard").addClass("active");
            $("#cakmenu-dashboard").addClass(" show active");
          }

          $("#cakmenu-"+current_url).addClass("active");
        },
        error: function (err) {
            console.log(err);
        }
    });

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
});



function formatDate(date) {
    var converted = date.split("/").reverse().join('-');
    return converted;
}

function formatRupiah(angka, prefix){
  var angka_string = angka.toString();
  var angka_string_el = angka_string.split(".");
  var number = "";
  var x = 0;
  for(var i = angka_string_el[0].length-1; i >= 0; i--){
    x++;
    number = angka_string_el[0][i]+number;
    if(x%3 == 0 && x < angka_string_el[0].length){
      number = "."+number;
    }
  }

  if(angka_string_el[1] !== undefined){
    var n = parseFloat("0."+angka_string_el[1]).toFixed(2);
    var n2 = n.toString();
    var n3 = n2.split(".");
    number = number+","+n3[1];
  }else{
    number = number+",00";
  }
  
  return prefix == undefined ? number : (number ? '<span class="cak-rp">Rp </span><span class="cak-nom">' + number : '</span>');
}

function formatRupiahWNegative(angka, prefix){
    var negatif = "";
    if(angka < 0){
        negatif = "-";
        angka = angka*(-1);
    }

    var angka_string = angka.toString();
    var angka_string_el = [];
    if(angka_string.indexOf('.') <= -1){
      angka_string_el[0] = angka_string;
      angka_string_el[1] = "00";
    }else{
      angka_string_el = angka_string.split(".");
    }
    var number = "";
    var x = 0;
    for(var i = angka_string_el[0].length-1; i >= 0; i--){
      x++;
      number = angka_string_el[0][i]+number;
      if(x%3 == 0 && x < angka_string_el[0].length){
        number = "."+number;
      }
    }

    if(angka_string_el[1] !== undefined){
      var n = parseFloat("0."+angka_string_el[1]).toFixed(2);
      var n2 = n.toString();
      var n3 = n2.split(".");
      number = number+","+n3[1];
    }else{
      number = number+",00";
    }
    
    return prefix == undefined ? number : (number ? '<span class="cak-rp">Rp </span><span class="cak-nom">' + negatif+number : '</span>');
}


  
