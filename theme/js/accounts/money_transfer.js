
/*Email validation code end*/
$('#save,#update').on("click",function (e) {
	var base_url=$("#base_url").val();
    /*Initially flag set true*/
    var flag=true;

    function check_field(id)
    {

      if(!$("#"+id).val() ) //Also check Others????
        {

            $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
            //$('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }


    //Validate Input box or selection box should not be blank or empty
	check_field("transfer_date");
	check_field("transfer_code");
	check_field("debit_account_id");
	check_field("credit_account_id");
	check_field("amount");
    


	if(flag==false)
    {
		toastr["warning"]("ข้อมูลบางอย่างหายไป!")
		return;
    }
    if(get_float_type_data(amount)<=0){
    	toastr["warning"]("จำนวนเงินต้องมากกว่าศูนย์ !");
    	return;
    }

    if($("#debit_account_id").val()==$("#credit_account_id").val()){
    	toastr["warning"]("สองบัญชีต้องไม่เหมือนกัน!");
    	return;
    }

    var this_id=this.id;

    if(this_id=="save")  //Save start
    {

					//if(confirm("Do You Wants to Save Record ?")){
						e.preventDefault();
						data = new FormData($('#money_transfer-form')[0]);//form name
						/*Check XSS Code*/
						if(!xss_validation(data)){ return false; }
						
						$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
						$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
						$.ajax({
						type: 'POST',
						url: base_url+'money_transfer/new_money_transfer',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result){
             // alert(result);//return;
             			result=result.trim();
							if(result=="success")
							{
								window.location=base_url+"money_transfer";
								return;
							}
							else if(result=="failed")
							{
							   toastr["error"]("บันทึกข้อมูลไม่สำเร็จ.พยายามอีกครั้ง!");
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


    }//Save end
	
	else if(this_id=="update")  //Update start
    {
							
					//if(confirm("Do You Wants to Save Record ?")){
						e.preventDefault();
						data = new FormData($('#money_transfer-form')[0]);//form name
						/*Check XSS Code*/
						if(!xss_validation(data)){ return false; }
						
						$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
						$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
						$.ajax({
						type: 'POST',
						url: base_url+'money_transfer/update_money_transfer',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result){
              //alert(result);return;
              			result=result.trim();
							if(result=="success")
							{
								//toastr["success"]("Record Updated Successfully!");
								window.location=base_url+"money_transfer";
							}
							else if(result=="failed")
							{
							   toastr["error"]("บันทึกข้อมูลไม่สำเร็จ.พยายามอีกครั้ง!");
							}
							else
							{
								 toastr["error"](result);
							}
							$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
							$(".overlay").remove();
							return;
					   }
					   });
				//}

				//e.preventDefault


    }//Save end
	

});



//Delete Record start
function delete_money_transfer(q_id)
{
	var base_url=$("#base_url").val();
   if(confirm("Do You Wants to Delete Record ?")){
   	$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
   $.post(base_url+"money_transfer/delete_money_transfer",{q_id:q_id},function(result){
   //alert(result);return;
   result=result.trim();
	   if(result=="success")
				{
				  toastr["success"]("ลบบันทึกเรียบร้อย!");
				  success.currentTime = 0; 
				  success.play();
				  $('#example2').DataTable().ajax.reload();
				}
				else if(result=="failed"){
				  toastr["error"]("ลบไม่สำเร็จ พยายามอีกครั้ง!");
				  failed.currentTime = 0; 
				  failed.play();
				}
				else{
				  toastr["error"](result);
				  failed.currentTime = 0; 
				  failed.play();
				}
				$(".overlay").remove();
				return false;
   });
   }//end confirmation
}
//Delete Record end
function multi_delete(){
	var base_url=$("#base_url").val();
    var this_id=this.id;
    
		if(confirm("Are you sure ?")){
			$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
			$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
			
			data = new FormData($('#table_form')[0]);//form name
			$.ajax({
			type: 'POST',
			url: base_url+'money_transfer/multi_delete_money_transfer',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result){
				result=result.trim();
  //alert(result);return;
				if(result=="success")
				{
					toastr["success"]("ลบบันทึกเรียบร้อย!");
					success.currentTime = 0; 
				  	success.play();
					$('#example2').DataTable().ajax.reload();
					$(".delete_btn").hide();
					$(".group_check").prop("checked",false).iCheck('update');
				}
				else if(result=="failed")
				{
				   toastr["error"]("บันทึกข้อมูลไม่สำเร็จ พยายามอีกครั้ง!");
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
