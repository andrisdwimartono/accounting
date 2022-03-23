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
    var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? '<span class="cak-rp">Rp </span><span class="cak-nom">' + rupiah : '</span>');
}

function formatRupiahWNegative(angka, prefix){
    var negatif = "";
    if(angka < 0){
        negatif = "-";
        angka = angka*(-1);
    }

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
    
    return prefix == undefined ? number : (number ? '<span class="cak-rp">Rp </span><span class="cak-nom">' + negatif+number : '</span>');
}


  
