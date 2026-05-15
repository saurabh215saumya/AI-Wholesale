$(function () {
 
    // Get squad list after select the platoon

    $('#selectplatoon').change(function () {
        var selPlatoon = $(this).val();    
        $.ajax({   
            url: BASE_URL+"/manageshift/ajax_squad_call", 
            async: false,
            type: "POST", 
            data: "platoon="+selPlatoon, 
            dataType: "html",                 
            success: function(data) {
                if(data) {                    
                    $('#selectsquad').html(data);
                } else {
                    $('#selectsquad').html("<option value=''>Select Squad</option>");
                }
            }
        })
    });

    // Category selection remove the squad list

    $('#category').on('change', function(){
        $('.squad-list').empty();
       $('.squad-list').html("<option value=''>Select Squad</option>");
   });

    // Squad onchange event and get all calendar data using category, platoon and squad
  
     window.onload = function(e){ 
      var userid=$("#shiftuserid").val();
      if(userid!=""){
            var dateObj = new Date($('#calendar').fullCalendar('getDate'));
            var monthId = dateObj.getMonth() + 1;
            var fullYear = dateObj.getFullYear();
            $.ajax({   
					url: BASE_URL+"/Appuser/ajax_calendarshift_call", 
					async: false,
					type: "POST", 
					data: { "monthId": monthId, "fullYear":fullYear ,"userid":userid},  
					dataType: "html",                 
					success: function(response) {
					$('#calendar').fullCalendar('removeEvents');
					
					 
					var responseData = JSON.parse(response);
					$('#calendar').fullCalendar('addEventSource', responseData);
                    }
                }) 
     

               $.ajax({   
					url: BASE_URL+"/Appuser/ajax_calendarshift_overtime", 
					async: false,
					type: "POST", 
					data: { "monthId": monthId, "fullYear":fullYear ,"userid":userid},  
					dataType: "html",                 
					success: function(response) {
					 if(response){
					$('.fc-right').html(response).style("bg-color","yellow");
                                        }else{
                                       $('.fc-right').html("");
                                        }
					
					 
                    }
                }) 






      }

     }
   var userid=$("#shiftuserid").val();    
    if(userid!=""){
            var dateObj = new Date($('#calendar').fullCalendar('getDate'));
            var monthId = dateObj.getMonth() + 1;
             //alert($('#calendar').fullCalendar('getDate'));
            var dateObj = new Date($('#calendar').fullCalendar('getDate'));
            var monthId = dateObj.getMonth() + 1;
            var fullYear = dateObj.getFullYear();
            //alert(dateObj);
		$.ajax({   
                url: BASE_URL+"/Appuser/ajax_calendarshift_call", 
                async: false,
                type: "POST", 
                data: { "fullYear":fullYear ,"userid":userid}, 
                dataType: "html",                 
                success: function(response) {
					//alert(response);
                    //console.log(response);
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('addEventSource', "naveeghfffh");
                    //$('#calendar').fullCalendar('addEventSource', [{"id":"6","shift_hour":"5","start":"2018-01-26","end":"2018-01-26","monthint":"1","year":"2018","title":"morning shift"}]);
                   // var responseData = JSON.parse(response);
                   // $('#calendar').fullCalendar('addEventSource', responseData);
                }
            });
		
		
		
		
		
	}

    $('.calendarlistdata').on('change', function(){
       
       
     
            var dateObj = new Date($('#calendar').fullCalendar('getDate'));
            var monthId = dateObj.getMonth() + 1;
            var fullYear = dateObj.getFullYear();

            $.ajax({   
                url: BASE_URL+"/manageshift/ajax_calendarshift_call", 
                async: false,
                type: "POST", 
                data: { "fullYear":fullYear }, 
                dataType: "html",                 
                success: function(response) {
                    console.log(response);
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('addEventSource', [{"id":"6","shift_hour":"5","start":"2018-01-26","end":"2018-01-26","monthint":"1","year":"2018","title":"morning shift"}]);
                   // var responseData = JSON.parse(response);
                   // $('#calendar').fullCalendar('addEventSource', responseData);
                }
            })
       
   });

    // Load or Render the Full calendar and configure the full calendar

    $('#calendar').fullCalendar({
		
        header: {
            left: 'prev,next today',
            // left: '',
            center: 'title',
            // right: 'month,agendaWeek,agendaDay'
            right: ''
        },
        // defaultDate: '2018-01-01',
        defaultDate: CURRENT_DATE,
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectHelper: true,
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            // droppable: true,

            select: function(start, end) {
                if(start.isBefore(moment())) {
                    $('#calendar').fullCalendar('unselect');
                    return false;
                } else {
                    // Display the modal.
                    // You could fill in the start and end fields based on the parameters
                    $('#shifthiddendate').val(start);
                    $('.modal').modal('show');
                    
                }
            },

            eventClick: function(event, element) {
                // Display the modal and set the values to the event values.
                // $('.modal').modal('show');
                // $('.modal').find('#title').val(event.title);
                // $('.modal').find('#starts-at').val(event.start);
                // $('.modal').find('#ends-at').val(event.end);

                if(event.start.isBefore(moment())) {
                    // Display the modal and set the values to the event values.
                } else {
                    // console.log(event.title);
                    // console.log(event.id);
                    // console.log(event.monthint);
                    // console.log(event.year);                       

                    $('#manageshiftid').val(event.id);
                    $('#shifthiddendate').val(event.start);
                    
                    // Display the modal and set the values to the event values.
                    $('.modal').modal('show');
            
                }

            },
              
        });

        // Bind the dates to datetimepicker.
        // You should pass the options you need
        // $("#starts-at, #ends-at").datetimepicker();

        // Whenever the user clicks on the "save" button om the dialog
        $('#save-event').on('click', function() {            
            var shifttype = $('#shifttime').val();
            // alert(shifttype);
            // alert($('#shifthiddendate').val());
            // alert($('select[name=shifttime]').val());
            // alert($('#category').val());
            // alert($('#selectplatoon').val());
            // alert($('#selectsquad').val());
            // alert($('select[name=shifttime] option:selected').text());
            // alert($('#shifthiddendate').val());
           
            var manageshiftid           = $('#manageshiftid').val();
            var shiftdate               = $('#shifthiddendate').val();
            var shift_hour              = $('select[name=shifttime] option:selected').attr('shift_hour');             
            var shiftformateddate       = moment(shiftdate).format('DD-MM-YYYY 00:00:00'); // ex: 23-02-2018 00:00:00
            var shiftcatid              = $('#category').val();
            var shiftplatoonid          = $('#selectplatoon').val();
            var shiftsquadid            = $('#selectsquad').val();
            var shifttitle              = $('select[name=shifttime] option:selected').text();
            var calendardate            = $('#shifthiddendate').val();

            if(!shiftcatid){
                alert("please first select category");
                return false;
            }
            if(!shiftplatoonid){
                alert("please first select platoon");
                return false;
            }
            if(!shiftsquadid){
                alert("please first select squad");
                return false;
            }

            if (shifttype) {                             
                var eventData = {
                    manageshiftid: manageshiftid,
                    shiftId: shifttype,
                    shifthiddendate: shiftformateddate,
                    shifthour: shift_hour,
                    shiftcategory: shiftcatid,
                    shiftplatoon: shiftplatoonid,
                    shiftsquad: shiftsquadid,
                    shifttitle: shifttitle,
                    calendardate: calendardate
                };                
                $.ajax({   
                    url: BASE_URL+"/manageshift/ajax_saveshift_call", 
                    async: false,
                    type: "POST", 
                    data: eventData, 
                    dataType: "html",                 
                    success: function(response) {
                        // $('#calendar').fullCalendar('removeEvents');
                        // var responseData = JSON.parse(response);
                        // $('#calendar').fullCalendar('renderEvent', responseData, false); // stick? = true

                        // Reload add event with pre

                       var selcategory  = $('#category').val();
                       var selplatoon   = $('#selectplatoon').val();
                       var selsquad     = $('#selectsquad').val();
                       if(!selcategory){
                        alert("Plese select Department");
                        return false;
                       }
                       if(!selplatoon){
                        alert("Plese select Platoon");
                        return false;
                       }
                       if(!selsquad){
                        alert("Plese select Squad");
                        return false;
                       }
                       if(selcategory && selplatoon && selsquad){
                            var dateObj = new Date($('#calendar').fullCalendar('getDate'));
                            var monthId = dateObj.getMonth() + 1;
                            var fullYear = dateObj.getFullYear();

                            $.ajax({   
                                url: BASE_URL+"/manageshift/ajax_calendarshift_call", 
                                async: false,
                                type: "POST", 
                                data: {"selcategory": selcategory, "selplatoon": selplatoon, "selsquad": selsquad, "monthId": monthId, "fullYear":fullYear }, 
                                dataType: "html",                 
                                success: function(response) {
                                    $('#calendar').fullCalendar('removeEvents');
                                     $('#calendar').fullCalendar('addEventSource', [{"id":"1","title":"New Event","start":"2018-01-01T23:59:59.9990-08:00","end":"2018-01-01T23:59:59.9990-08:00","allDay":false}, {"id":"2","title":"New adfad","start":"2018-01-02T23:59:59.9990-08:00","end":"2018-01-02T23:59:59.9990-08:00","allDay":false}]);
                                    var responseData = JSON.parse(response);
                                    $('#calendar').fullCalendar('addEventSource', responseData);
                                }
                            })
                       }
                    }
                   
                })
                $(".fc-day-number").removeAttr("data-goto");
                // $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
            } else {
                alert("Plese select Shift");
                return false;
            }
            $('#calendar').fullCalendar('unselect');

            // Clear modal inputs
            $('.modal').find('input').val('');

            // hide modal
            $('.modal').modal('hide');
        });
        
        $('.fc-prev-button, .fc-next-button').click(function(){  
			
			    var userid=$("#shiftuserid").val();  
           if(userid){
                var dateObj = new Date($('#calendar').fullCalendar('getDate'));
                var monthId = dateObj.getMonth() + 1;
                var fullYear = dateObj.getFullYear();


                $.ajax({   
					url: BASE_URL+"/Appuser/ajax_calendarshift_call", 
					async: false,
					type: "POST", 
					data: { "monthId": monthId, "fullYear":fullYear ,"userid":userid},  
					dataType: "html",                 
					success: function(response) {
					$('#calendar').fullCalendar('removeEvents');
					
					 
					var responseData = JSON.parse(response);
					$('#calendar').fullCalendar('addEventSource', responseData);
                    }
                })
              $.ajax({   
					url: BASE_URL+"/Appuser/ajax_calendarshift_overtime", 
					async: false,
					type: "POST", 
					data: { "monthId": monthId, "fullYear":fullYear ,"userid":userid},  
					dataType: "html",                 
					success: function(response) {
                                        if(response){
					$('.fc-right').html(response).style("bg-color","yellow");
                                        }else{
                                       $('.fc-right').html("");
                                        }
					
					 
                    }
                }) 

                
           }
           $(".fc-day-number").removeAttr("data-goto");
        }); 

        $(".fc-day-number").removeAttr("data-goto");      

    });
