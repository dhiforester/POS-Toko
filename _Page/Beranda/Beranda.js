$(document).ready(function(){
    var Loading='<div class="row text-center"><div class="form-group col col-md-12"><img src="images/loading.gif"></div></div>';
    $('#Halaman').html(Loading);
    $('#Halaman').load("_Page/Beranda/Beranda.php");
    $('#MenuKanan').load("_Partial/Sidebar.php");
});
