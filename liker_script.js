jQuery(document).ready( function($) {
$('form.ajax').on('submit', function(e){
   e.preventDefault();
   var that = $(this),
   url = that.attr('action'),
   type = that.attr('method');
   var name = $('.name').val();
   var email = $('.email').val();
   var message = $('.message').val();
   var jobname = $('.jobname').val();
   $.ajax({
      url: myAjax.ajaxurl,
      type:"POST",
      dataType:'json',
      data: {
         action:'set_form',
         name:name,
         email:email,
         message:message,
         jobname:jobname,
    },   success: function(response) {
         $(".success_msg").css("display","block").append('<div> Name :'+name+'<br> Email :'+email+'<br> Skill Given :'+message+'</div>')
         
   },
   error: function(data){
         $(".error_msg").css("display","block");  
   }
   });
$('.ajax')[0].reset();

  });

});
function get(){
   document.getElementById("data_form").style.display = "block";
}
