

jQuery(document).ready( function () { 


    jQuery('#save').click(function(e){
    e.preventDefault();
      var width = jQuery("#width").val();
      var height = jQuery("#height").val(); 
      var background = jQuery("#background").val();
      var yt_limit = jQuery("#yt_limit").val();

      jQuery.ajax({
         type : "post",
         dataType : "json",
         url: getBaseURL()+"wp-content/plugins/ytvideo/includes/insert_style.php",
         data : {action: "change_style", width : width, height: height, background:background,yt_limit:yt_limit},
         success: function(response) {
            if(response.status == "success") {

               jQuery("#success").html(response.message);
               jQuery('#success').delay(3000).fadeOut("togle");
            }
          if(response.status == "fail") {
              jQuery("#error").html(response.message)
              jQuery('#error').delay(3000).fadeOut("togle");
            }
         }
      });


    });

    function getBaseURL() {
    var url = location.href;
    var baseURL = url.substring(0, url.indexOf('/', 14));



    if (baseURL.indexOf('http://localhost') != -1) {

        var url = location.href;
        var pathname = location.pathname;
        var index1 = url.indexOf(pathname);
        var index2 = url.indexOf("/", index1 + 1);
        var baseLocalUrl = url.substr(0, index2);

        return baseLocalUrl + "/";
    }
    else {

        return baseURL + "/";
      }

    }



    });
