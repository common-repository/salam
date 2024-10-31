$(document).ready(function(){

    $('.logmin').on('click', function(e){
    $(".salamotecl").removeClass("hide");

      });
     $("#btnSubmit").click(function(){
  var mob = $("#mobile").val();
  var link = "?type=1&mobile="+mob;
  
  if ( mob.length > 8 && mob.length < 12 ) {
      if (typeof(Storage) !== "undefined") {
  // Store
  localStorage.setItem("mobile", mob);
  // Retrieve
  var mobo = localStorage.getItem("mobile");
} 
      
      
      
  $.get(link, function(responseTxt){
  $(".btnSubmit").addClass("hide");
  $(".cod").removeClass("hide");
  $(".cbtn").removeClass("hide");
    });
  }
    });
     $("#btnveify").click(function(){
    var ccode = $("#ccode").val();
    var mob = $("#mobile").val();
    var otpp = $("#otpp").val();
    var link = "?otpp="+otpp+"&mobile="+mob;
 $.get(link, function(respons){
     location.reload();
  });
});
});