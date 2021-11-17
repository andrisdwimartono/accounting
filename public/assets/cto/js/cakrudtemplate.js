$(document).ready(function () {
    // $.ajax({
    //     url: "/getusermenu",
    //     type: "get",
    //     success: function(data){
    //         var current_url = $("#cakcurrent_url").val();
    //         for(var i = 0; i < data.data.user_menus.length; i++){
    //             if(data.data.user_menus[i].parent_id == null){
    //                 if(data.data.user_menus[i].is_group_menu == null){
    //                     var active = current_url==data.data.user_menus[i].url?'class="active" ':'';
    //                     var menu = '<li '+active+'id="usermenu_'+data.data.user_menus[i].menu_id+'"><a href="/'+data.data.user_menus[i].url+'" class="caksidemenu"><i class="fas '+data.data.user_menus[i].menu_icon+'"></i> <span>'+data.data.user_menus[i].menu_name+'</span></a></li>';
    //                 }else{
    //                     var has_child_menu = false;
    //                     var sub_menu = '';
    //                     var child_menu_active = '';
    //                     for(var j = 0; j < data.data.user_menus.length; j++){
    //                         if(data.data.user_menus[j].parent_id == data.data.user_menus[i].menu_id){
    //                             var active = current_url==data.data.user_menus[j].url?'class="active"':'';
    //                             has_child_menu = true;
    //                             if(current_url==data.data.user_menus[j].url){
    //                                 child_menu_active = ' show';
    //                             }
    //                             sub_menu += '<li '+active+'><a href="/'+data.data.user_menus[j].url+'" class="caksidemenu caksidechildmenu"><i class="fas '+data.data.user_menus[j].menu_icon+'"></i> <span>'+data.data.user_menus[j].menu_name+'</span></a></li>';
    //                         }
    //                     }
    //                     sub_menu = '<ul class="collapse list-unstyled'+child_menu_active+'" id="menu_parent_'+data.data.user_menus[i].menu_id+'">'+sub_menu;
    //                     sub_menu += '</ul>';
    //                     if(has_child_menu){
    //                         var menu = '<li id="usermenu_'+data.data.user_menus[i].menu_id+'"><a href="#menu_parent_'+data.data.user_menus[i].menu_id+'" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle caksidemenu"><i class="fas '+data.data.user_menus[i].menu_icon+'"></i> <span>'+data.data.user_menus[i].menu_name+'</span></a>'+sub_menu+'</li>';
    //                     }
    //                 }
    //                 $("#cakleftmenuside").append(menu);
    //             }
    //         }
    //     },
    //     error: function (err) {
    //         console.log(err);
    //     }
    // });

    $('#sidebarCollapse').on("click", function () {
        $("#sidebar").toggleClass("active");
        $(".caksidemenu span").toggleClass("d-none");
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
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}