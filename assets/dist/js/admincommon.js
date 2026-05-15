jQuery(document).ready(function(e){
jQuery('.sendemailbutton').click(function(e){
      emailname=$("#emailname").val();
      emailid=$("#emailid").val();
      emailsubject=$("#emailsubject").val();
      message=$("#emailmessage").val();
   		 if(emailname!="" && message!="" ){
				var data = {
                    action : 'sendemail',
					emailname : $("#emailname").val(),
				        emailid:$("#emailid").val(),  
					emailsubject : $("#emailsubject").val(),
					emailmessage : $("#emailmessage").val(),
					formname : $("#formname").val(),
                 };
              
                $.post(BASE_URL+'/appuser/sendemail',data,function(result){
					//alert(result);
					if(result=='1'){
						alert('Send Email Successful');
						 $( "#myModal" ).fadeOut(350);
						 window.location.reload();
						}else{
							alert('Email failed');
							} //alert(result);
               //   window.location.reload();
                    
                });
		
		}
		
	  }); 


});
$(function () {
	var requestdata;
	$(".changestatus").on("click", function(){ 	    
            // Abort any pending request
            if (requestdata) {
                requestdata.abort();
            }
	   
            // setup some local variables
            var controllername = $(this).children("span").attr('controllername');
            var statusid = $(this).children("span").attr('statusid');
            var statusvalue = $(this).children("span").attr('statusvalue');
//            var displayid = $(this).attr('id');            
	    var url = BASE_URL + "/" + controllername + "/" + 'changestatus';
	    $("#loderid_"+statusid).css('display', 'block');
	    requestdata = $.ajax({
            url: url,
            type: "post",
            data: {
    		    statusid:	    statusid,
    		    statusvalue:    statusvalue,
    		    controllername:    controllername,
    		    // displayid:    displayid,
    		}
        });
	    
        // Callback handler that will be called on success
        requestdata.done(function (response, textStatus, jqXHR) {
            // Log a message to the console
            // console.log(response);		
            // console.log("#display__"+ statusid);		
            if(response) {
                $("#loderid_"+statusid).css('display', 'none');
    		    $("#display__"+ statusid).html('');
    		    $("#display__"+ statusid).html(response);
    		}
        });

        // Callback handler that will be called on failure
        requestdata.fail(function (jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
    		    "The following error occurred: " + textStatus, errorThrown
    		);
        });
    });



    $(".changegallerystatus").on("click", function(){      
            // Abort any pending request
            if (requestdata) {
                requestdata.abort();
            }
       
            // setup some local variables
            var controllername = $(this).children("span").attr('controllername');
            var statusid = $(this).children("span").attr('statusid');
            var statusvalue = $(this).children("span").attr('statusvalue');
//            var displayid = $(this).attr('id');            
        var url = BASE_URL + "/" + controllername + "/" + 'changegallerystatus';
        $("#loderid_"+statusid).css('display', 'block');
        requestdata = $.ajax({
            url: url,
            type: "post",
            data: {
                statusid:       statusid,
                statusvalue:    statusvalue,
                controllername:    controllername,
                // displayid:    displayid,
            }
        });
        
        // Callback handler that will be called on success
        requestdata.done(function (response, textStatus, jqXHR) {
            // Log a message to the console
            // console.log(response);       
            // console.log("#display__"+ statusid);     
            if(response) {
                $("#loderid_"+statusid).css('display', 'none');
                $("#display__"+ statusid).html('');
                $("#display__"+ statusid).html(response);
            }
        });

        // Callback handler that will be called on failure
        requestdata.fail(function (jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
                "The following error occurred: " + textStatus, errorThrown
            );
        });
    });



    $('#selectcountry').change(function () {
        var selCountry = $(this).val();
        // console.log(selCountry);        
        $.ajax({   
            url: "ajax_state_call", 
            async: false,
            type: "POST", 
            data: "country="+selCountry, 
            dataType: "html",                 
            success: function(data) {
                if(data) {
                    $('#selectcity').html(data);
                } else {
                    $('#selectcity').html("<option value=''>Select State</option>");
                }
            }
        })
    });

    $('#selectcity').change(function () {
        var selState = $(this).val();
        // console.log(selCountry);        
        $.ajax({   
            url: "ajax_city_call", 
            async: false,
            type: "POST", 
            data: "state="+selState, 
            dataType: "html",                 
            success: function(data) {
                if(data) {
                    $('#selectcityval').html(data);
                } else {
                    $('#selectcityval').html("<option value=''>Select City</option>");
                }
            }
        })
    });
});

function deleteconfirm()
{
    var status = confirm("Are you sure to delete permanently?");
    if( status != true){
        return false;
    }
}


function addasdeal()
{
    var status = confirm("Are you sure to add this product as today's deal?");
    if( status != true){
        return false;
    }
}

function removeasdeal()
{
    var status = confirm("Are you sure to remove this product as today's deal?");
    if( status != true){
        return false;
    }
}


function defaultconfirm()
{
    var status = confirm("Are you sure to set this as default venue?");
    if( status != true){
        return false;
    }
}


function declineOrder()
{
    var status = confirm("Are you sure to decline this cancel order?");
    if( status != true){
        return false;
    }
}



function approveOrder()
{
    var status = confirm("Are you sure to approve this cancel order?");
    if( status != true){
        return false;
    }
}
