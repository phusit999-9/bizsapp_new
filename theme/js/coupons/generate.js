
$('#save,#update').on("click",function (e) {
	var base_url=$("#base_url").val();
    //Initially flag set true
    var flag=true;

    function check_field(id)
    {
      if(!$("#"+id).val() ) //Also check Others????
        {
            $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
           // $('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }

    //Validate Input box or selection box should not be blank or empty	
	check_field("customer_id");	
	check_field("coupon_id");	
	check_field("code");	
	/*check_field("expire_date");	
	check_field("coupon_value");	
	check_field("coupon_type");	*/
	
    if(flag==false)
    {

		toastr["warning"]("ข้อมูลบางอย่างขาดหายไป!")
		return;
    }

    var this_id=this.id;

  
		//if(confirm("Do You Wants to Save Record ?")){
			e.preventDefault();
			data = new FormData($('#coupon-form')[0]);//form name
			/*Check XSS Code*/
			if(!xss_validation(data)){ return false; }
			
			$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
			$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
			$.ajax({
			type: 'POST',
			url: base_url+'customer_coupon/save?command='+this_id,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result){
 // alert(result);return;
				if(result=="success")
				{
					//alert("Record Saved Successfully!");
					window.location=base_url+"customer_coupon/";
					return;
				}
				else if(result=="failed")
				{
					toastr["error"]("บันทึกข้อมูลไม่สำเร็จ พยายามอีกครั้ง!");
				   //	return;
				}
				else
				{
					toastr["error"](result);
				}
				$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
				$(".overlay").remove();
		   }
		   });
	//}

	//e.preventDefault


  
	

});


//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent,target){

    if(kevent.keyCode==13){
		$("#"+target).focus();
    }
	
}

//update status start
function update_status(id,status)
{
	var base_url=$("#base_url").val();
	$.post(base_url+"customer_coupon/update_status",{id:id,status:status},function(result){
		if(result=="success")
				{
					 toastr["success"]("อัพเดท เรียบร้อย!");
				  //alert("Status Updated Successfully!");
				  success.currentTime = 0; 
				  success.play();
				  if(status==0)
				  {
					  status="Inactive";
					  var span_class="label label-danger";
					  $("#span_"+id).attr('onclick','update_status('+id+',1)');
				  }
				  else{
					  status="Active";
					   var span_class="label label-success";
					   $("#span_"+id).attr('onclick','update_status('+id+',0)');
					  }

				  $("#span_"+id).attr('class',span_class);
				  $("#span_"+id).html(status);
				  return false;
				}
				else if(result=="failed"){
					toastr["error"]("อัพเดท ไม่สำเร็จ พยายามอีครั้ง !");
				  failed.currentTime = 0; 
				  failed.play();

				  return false;
				}
				else{
					toastr["error"](result);
				  failed.currentTime = 0; 
				  failed.play();
				  return false;
				}
	});
}
//update status end

//Delete Record start
function delete_coupon(q_id)
{
	
   if(confirm("Do You Wants to Delete Record ?")){
   	$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
   $.post($("#base_url").val()+"customer_coupon/delete_coupon",{q_id:q_id},function(result){
   //alert(result);return;
	   if(result=="success")
				{
					toastr["success"]("ลบบันทึก เรียบร้อย!");
					$('#example2').DataTable().ajax.reload();
				}
				else if(result=="failed"){
				  	toastr["error"]("ลบไม่สำเร็จ พยายามอีกครั้ง !");
				}
				else{
					toastr["error"](result);
				}
				$(".overlay").remove();
				return false;
   });
   }//end confirmation
}
//Delete Record end

function multi_delete(){
	//var base_url=$("#base_url").val();
    var this_id=this.id;
    
		if(confirm("Are you sure ?")){
			$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
			$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
			
			data = new FormData($('#table_form')[0]);//form name
			$.ajax({
			type: 'POST',
			url: $("#base_url").val()+'customer_coupon/multi_delete',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result){
				result=result;
  //alert(result);return;
				if(result=="success")
				{
					toastr["success"]("ลบบันทึก เรียบร้อย!");
					success.currentTime = 0; 
				  	success.play();
					$('#example2').DataTable().ajax.reload();
					$(".delete_btn").hide();
					$(".group_check").prop("checked",false).iCheck('update');
				}
				else if(result=="failed")
				{
				   toastr["error"]("บันทึกข้อมูลไม่สำเร็จ พยายามอีกครั้ง !");
				   failed.currentTime = 0; 
				   failed.play();
				}
				else
				{
					toastr["error"](result);
					failed.currentTime = 0; 
				  	failed.play();
				}
				$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
				$(".overlay").remove();
		   }
		   });
	}
	//e.preventDefault
}
function generate(){
	 var number = Math.random().toString().slice(2,16);
	 console.log(number);
	 $('#code').val(number);
}
$(".generate").on('click', function(){
	 generate();
});

function set_coupon_value(){
	var input = $("#coupon_id option:selected");
	var value = input.attr("data-value");
	var type = input.attr("data-type");
	var expire_date = input.attr("data-expire_date");

	if(value=='undefined'){
		expire_date=type=value='';
	}

	$("#expire_date").val(expire_date);
	$("#coupon_value").val(value);	
	$("#coupon_type").val(type);	
}

$("#coupon_id").on("change", function(){
	set_coupon_value();
});
$(document).ready(function(){
	set_coupon_value();
})