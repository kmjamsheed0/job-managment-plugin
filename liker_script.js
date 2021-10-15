jQuery(document).ready( function($) {
   /*jQuery(".user_like").click( function(e) {
      e.preventDefault(); 
      post_id = jQuery(this).attr("data-post_id");
      nonce = jQuery(this).attr("data-nonce");
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "my_user_like", post_id : post_id, nonce: nonce},
         success: function(response) {
            if(response.type == "success") {
               jQuery("#like_counter").html(response.like_count);
            }
            else {
               alert("Your like could not be added");
            }
         }
      });
   });*/
$('form.ajax').on('submit', function(e){
   e.preventDefault();
   var that = $(this),
   url = that.attr('action'),
   type = that.attr('method');
   var name = $('.name').val();
   var email = $('.email').val();
   var message = $('.message').val();
   $.ajax({
      url: myAjax.ajaxurl,
      type:"POST",
      dataType:'json',
      data: {
         action:'set_form',
         name:name,
         email:email,
         message:message,
    },   success: function(response) {
         $(".success_msg").css("display","block").append('<div> Name :'+name+'<br> Email :'+email+'<br> Skill Given :'+message+'</div>');
         //$(".preview").css("display","block").append('<div> Name : tess<br> Email : "'.email.'"<br> Skill Given :"'.message.'"</div> ');
         
        

         }
   });
$('.ajax')[0].reset();

  });

});
function get(){
   document.getElementById("data_form").style.display = "block";
}
