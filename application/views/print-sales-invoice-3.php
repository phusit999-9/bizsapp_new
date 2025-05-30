<!DOCTYPE html>
<html>
<title><?= $page_title;?>- Format 2</title>
<head>
<link rel='shortcut icon' href='<?php echo $theme_link; ?>images/favicon.ico' />

<style>
table, th, td {
    /*border: 1px solid black;*/
    border-collapse: collapse;
    font-family: 'Open Sans', 'Martel Sans', sans-serif;
    font-size: 14px;
}
th, td {
    padding: 5px;
    text-align: left;   
    vertical-align:top 
}
.dashed_top{
  border-top-style: dashed;
  border-width: 0.1px;
}
.dashed_bottom{
  border-bottom-style: dashed;
  border-width: 0.1px;
}
.dashed_left{
  border-left-style: dashed;
  border-width: 0.1px;
}
.dashed_right{
  border-right-style: dashed;
  border-width: 0.1px;
}
</style>
</head>
<body onload="window.print();"><!--  -->
<?php

    $q1=$this->db->query("select * from db_store where status=1 and id=".get_current_store_id());
    $res1=$q1->row();
    $store_name=$res1->store_name;
    $company_mobile=$res1->mobile;
    $company_phone=$res1->phone;
    $company_email=$res1->email;
    $company_country=$res1->country;
    $company_state=$res1->state;
    $company_city=$res1->city;
    $company_address=$res1->address;
    $company_postcode=$res1->postcode;
    $company_gst_no=$res1->gst_no;
    $company_vat_no=$res1->vat_no;
    $store_logo=$res1->store_logo;
    $store_website=$res1->store_website;

    $q4=$this->db->query("select sales_invoice_footer_text from db_store where id=1");
    $res4=$q4->row();
    $sales_invoice_footer_text=$res4->sales_invoice_footer_text;
    

    $q3=$this->db->query("SELECT b.customer_previous_due,b.customer_total_due,a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,
                           a.opening_balance,a.country_id,a.state_id,a.created_by,
                           a.postcode,a.address,b.sales_date,b.created_time,b.reference_no,
                           b.sales_code,b.sales_note,b.sales_status,
                           coalesce(b.grand_total,0) as grand_total,
                           coalesce(b.subtotal,0) as subtotal,
                           coalesce(b.paid_amount,0) as paid_amount,
                           coalesce(b.other_charges_input,0) as other_charges_input,
                           other_charges_tax_id,
                           coalesce(b.other_charges_amt,0) as other_charges_amt,
                           discount_to_all_input,
                           b.discount_to_all_type,
                           coalesce(b.tot_discount_to_all_amt,0) as tot_discount_to_all_amt,
                           coalesce(b.round_off,0) as round_off,
                           b.payment_status

                           FROM db_customers a,
                           db_sales b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$sales_id' 
                           ");
                           
    
    $res3=$q3->row();
    $customer_name=$res3->customer_name;
    $customer_mobile=$res3->mobile;
    $customer_phone=$res3->phone;
    $customer_email=$res3->email;
    $customer_country=get_country($res3->country_id);
    $customer_state=get_state($res3->state_id);
    $customer_address=$res3->address;
    $customer_postcode=$res3->postcode;
    $customer_gst_no=$res3->gstin;
    $customer_tax_number=$res3->tax_number;
    $customer_opening_balance=$res3->opening_balance;
    $sales_date=$res3->sales_date;
    $created_time=$res3->created_time;
    $reference_no=$res3->reference_no;
    $sales_code=$res3->sales_code;
    $sales_note=$res3->sales_note;
    $sales_status=$res3->sales_status;
    $created_by=$res3->created_by;
    $previous_due=$res3->customer_previous_due;
    $total_due=$res3->customer_total_due;

    
    $subtotal=$res3->subtotal;
    $grand_total=$res3->grand_total;
    $other_charges_input=$res3->other_charges_input;
    $other_charges_tax_id=$res3->other_charges_tax_id;
    $other_charges_amt=$res3->other_charges_amt;
    $paid_amount=$res3->paid_amount;
    $discount_to_all_input=$res3->discount_to_all_input;
    $discount_to_all_type=$res3->discount_to_all_type;
    $discount_to_all_type = ($discount_to_all_type=='in_percentage') ? '%' : 'Fixed';
    $tot_discount_to_all_amt=$res3->tot_discount_to_all_amt;
    $round_off=$res3->round_off;
    $payment_status=$res3->payment_status;
  

    ?>

<table align="center" width="100%" height='100%' style="border:1px solid;">
    <thead>
      <tr>
        <th colspan="11">
          <table width="100%">
            <tr>
              <th colspan="12" style="text-transform: uppercase;text-align: center; font-size: 20px;">
              <?=  $this->lang->line('receipt')?>
              </th>
            </tr>
            <tr>
              <th colspan="6" style="">
                  <b><?php echo $store_name; ?></b><br/>
                  <?php echo $this->lang->line('address')." : ".$company_address; ?>

                  <?php 
                  
                  if(!empty($company_city)){
                    echo "  " .$company_city;
                  }
                  if(!empty($company_state)){
                    echo "  " .$company_state;
                  }
                  if(!empty($company_country)){
                    echo "  " .$company_country;
                  }
                            
                  if(!empty($company_postcode)){
                    echo "-" .$company_postcode;
                  }
                ?>
               <br/>

                  <?php echo $this->lang->line('mobile').":".$company_mobile; ?><br/>
                  <?php echo (!empty(trim($company_email))) ? $this->lang->line('email').": ".$company_email."<br>" : '';?>
                  <?php echo (!empty(trim($company_gst_no))) ? $this->lang->line('gst_number').": ".$company_gst_no."<br>" : '';?>
               <!--   <?php echo (!empty(trim($company_vat_no))) ? $this->lang->line('vat_number').": ".$company_vat_no."<br>" : '';?> -->
                  <?php echo (!empty($company_email)) ? $company_email."," : '';
                        echo (!empty($store_website)) ? $store_website."<br>" : '';
                     ?>
                </th>
              <th colspan="6" style="text-align: right;">
                <img src="<?= base_url($store_logo);?>" width='40%' height=' '>
              </th>
              
            </tr>
            
          </table>
        </th>
    </tr>
    <tr>
        <th colspan="11">
          <table width="100%">
            
            <tr class=" ">
              <td colspan="6" style="border: 1px solid;" >
              <center><?= $this->lang->line('customer_details'); ?></center>
              <?php echo $this->lang->line('name').": ".$customer_name; ?><br/>
             
                <?php 
                        if(!empty($customer_address)){
                          echo $customer_address;
                        }
                        if(!empty($customer_country)){
                          echo $customer_country;
                        }
                        if(!empty($customer_state)){
                          echo ",".$customer_state;
                        }
                        if(!empty($customer_postcode)){
                          echo "-".$customer_postcode;
                        }
                      ?>
                      <br/>
                 <?php echo $this->lang->line('mobile').": ".$customer_mobile; ?> <br/>
                <?php echo (!empty(trim($customer_email))) ? $this->lang->line('email').": ".$customer_email."<br/>" : '';?>
                <?php echo (!empty(trim($customer_gst_no))) ? $this->lang->line('gst_number').": ".$customer_gst_no."<br/>" : '';?>
         
            </td>
              
              <td colspan="6" style="border: 1px solid;" >
                      <?= $this->lang->line('invoice_no'); ?> : <?php echo "$sales_code"; ?><br>
                      <?= $this->lang->line('reference_no'); ?> : <?php echo "$reference_no"; ?><br>
                      <?= $this->lang->line('date'); ?> : <?php echo show_date($sales_date)." ".$created_time; ?><br>
                      <?= $this->lang->line('sales_man'); ?> : <?php echo ucfirst($created_by); ?><br>
              </td>
            </tr>
          </table>
        </th>
    </tr>
     
   
    
  <tr style=''>
    <th style='border-right: 1px solid;border-top: 1px solid;' rowspan='2' colspan='1' class="text-center">#</th>
    <th style='border-right: 1px solid;border-top: 1px solid;' rowspan='2' colspan='4'><?= $this->lang->line('description'); ?></th>
   <!-- <th style='border-right: 1px solid;border-top: 1px solid;' rowspan='2'><?= $this->lang->line('hsn'); ?></th> -->
    <th style='border-right: 1px solid;border-top: 1px solid;' rowspan='2' colspan='1' class="text-center"><?= $this->lang->line('quantity'); ?></th>
    <!-- <th rowspan='2'><?= $this->lang->line('tax'); ?></th>
    <th rowspan='2'><?= $this->lang->line('tax_amount'); ?></th> -->
    <th style='border-right: 1px solid;border-top: 1px solid;' rowspan='2' colspan='1' class="text-center"><?= $this->lang->line('unit_price'); ?></th>
    <!-- <th rowspan='2'><?= $this->lang->line('discount'); ?></th> -->
    <th style='border-right: 1px solid;border-top: 1px solid;' rowspan='2' colspan='1' class="text-center"><?= $this->lang->line('discount_amount'); ?></th>
    <th style='border-right: 1px solid;border-top: 1px solid;' rowspan='2' colspan='1' class="text-center"><?= $this->lang->line('unit_cost'); ?></th>
    <th style='border-right: 1px solid;border-top: 1px solid;' rowspan='2' colspan='2' class="text-center"><?= $this->lang->line('total_amount'); ?></th>
  </tr>
  </thead>
<tbody style="border: 1px solid;">
  <tr style="border-bottom: 1px solid;">
 <?php
              $i=0;
              $tot_qty=0;
              $tot_sales_price=0;
              $tot_tax_amt=0;
              $tot_discount_amt=0;
              $tot_unit_total_cost=0;
              $tot_total_cost=0;
              $q2=$this->db->query("SELECT c.item_name, a.sales_qty, a.description,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.discount_input,a.discount_amt, a.unit_total_cost,
                                  a.total_cost ,c.hsn
                                  FROM 
                                  db_salesitems AS a,db_tax AS b,db_items AS c 
                                  WHERE 
                                  c.id=a.item_id AND b.id=a.tax_id AND a.sales_id='$sales_id'");
              foreach ($q2->result() as $res2) {
                  $discount = (empty($res2->discount_input)||$res2->discount_input==0)? '0':$res2->discount_input."%";
                  $discount_amt = (empty($res2->discount_amt)||$res2->discount_input==0)? '0':$res2->discount_amt."";

                  $unit_price_with_tax= number_format($res2->price_per_unit+$res2->tax_amt,2,'.','');
                  echo "<tr>";  
                  echo "<td style='border-right: 1px solid;border-top: 1px solid;'>".++$i."</td>";
                 
                  echo "<td style='border-right: 1px solid;border-top: 1px solid;' colspan='4'>";
                    echo $res2->item_name;
                    echo (!empty($res2->description)) ? "<br><i>[".nl2br($res2->description)."]</i>" : '';
                  echo "</td>";
                  
                //  echo "<td style='border-right: 1px solid;border-top: 1px solid;'>".$res2->hsn."</td>";
                  echo "<td style='border-right: 1px solid;border-top: 1px solid;'>".$res2->sales_qty."</td>";
                  
                  echo "<td style='text-align: right;border-right: 1px solid;border-top: 1px solid;'>".store_number_format($unit_price_with_tax)."</td>";
                  
                  echo "<td style='text-align: right;border-right: 1px solid;border-top: 1px solid;'>".store_number_format($discount_amt)."</td>";
                  echo "<td style='text-align: right;border-right: 1px solid;border-top: 1px solid;'>".store_number_format($res2->unit_total_cost)."</td>";
                  echo "<td style='text-align: right;border-right: 1px solid;border-top: 1px solid;' colspan='2'>".store_number_format($res2->total_cost)."</td>";
                  echo "</tr>";  
                  $tot_qty +=$res2->sales_qty;
                  $tot_sales_price +=$res2->price_per_unit;
                  $tot_tax_amt +=$res2->tax_amt;
                  $tot_discount_amt +=$res2->discount_amt;
                  $tot_unit_total_cost +=$res2->unit_total_cost;
                  $tot_total_cost +=$res2->total_cost;
              }
              ?>
  </tr>
  </tbody>
<tfoot>
            <tr>
              <td colspan="10" style="text-align: right;"><b><?= $this->lang->line('subtotal'); ?></b></td>
              <td colspan="1" style="text-align: right;" ><b><?php echo store_number_format($tot_total_cost); ?></b></td>
            </tr>
            <!--
            <tr>
              <td colspan="10" style="text-align: right;"><b><?= $this->lang->line('other_charges'); ?></b></td>
              <td colspan="1" style="text-align: right;" ><b><?php echo store_number_format($other_charges_amt); ?></b></td>
            </tr>-->
            <tr>
              <td colspan="10" style="text-align: right;"><b><?= $this->lang->line('discount_on_all'); ?>(<?= store_number_format($discount_to_all_input)." ".$discount_to_all_type; ?>)</b></td>
              <td colspan="1" style="text-align: right;" ><b><?php echo store_number_format($tot_discount_to_all_amt); ?></b></td>
            </tr>
            
            
            <tr>
              <td colspan="6" rowspan="2">
                <?php echo "<span class='amt-in-word'>".$this->lang->line('in_words').": <i style='font-weight:bold;'>".no_to_words(round($grand_total))." ".$this->lang->line('only')."</i></span>"; ?>
              </td>
              <td colspan="4" style="text-align: right;"><b><?= $this->lang->line('grand_total'); ?></b></td>
              <td colspan="1" style="text-align: right;" ><b><?php echo store_number_format($grand_total); ?></b></td>
            </tr>
            <tr>
              <td colspan="4" style="text-align: right;"><b><?= $this->lang->line('paid_amount'); ?></b></td>
              <td colspan="1" style="text-align: right;" ><b><?php echo store_number_format($paid_amount); ?></b></td>
            </tr>
            <tr>
              <td colspan="10" style="text-align: right;"><b><?= $this->lang->line('previous_due'); ?></b></td>
              <td colspan="1" style="text-align: right;" ><b><?php echo store_number_format($previous_due); ?></b></td>
            </tr>
            <tr>
              <td colspan="10" style="text-align: right;"><b><?= $this->lang->line('due_amount'); ?></b></td>
              <td colspan="1" style="text-align: right;" ><b><?php echo store_number_format($total_due); ?></b></td>
            </tr>
            
            <tr>
              <td colspan="6" style="padding-top: 100px">
                <b><?= $this->lang->line('customer_signature'); ?></b>
              </td>
              <td colspan="5" style="text-align: right;padding-top: 100px">
                <b><?= $this->lang->line('authorised_signature'); ?>
              </td>
            </tr>

            <?php if(!empty($sales_invoice_footer_text)) {?>
            <tr style="border-top: 1px solid;">
              <td colspan="11" style="text-align: center;">
                <?= $sales_invoice_footer_text; ?>
              </td>
            </tr>
            <?php } ?>
</tfoot>
</table>



</body>
</html>
