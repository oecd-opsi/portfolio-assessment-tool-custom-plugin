jQuery(document).ready( function() {
   jQuery(".nav-start-again-item a").click( function(e) {
      e.preventDefault();
      post_id = jQuery(this).attr("data-post_id");
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "start_again", post_id : post_id},
         success: function(response) {
            if(response.type == "success") {
              console.log(response);
              window.location.href = "/portfolio-exploration?edit=" + response.new_id;
            }
            else {
              console.log(response);
            }
         }
      });
   });
});
