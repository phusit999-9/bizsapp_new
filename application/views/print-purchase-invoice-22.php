<!DOCTYPE html>
<html>
<title><?= $page_title;?></title>
<head>
<?php //include"comman/code_css.php"; ?>
<link rel='shortcut icon' href='<?php echo $theme_link; ?>images/favicon.ico' />
<link rel="stylesheet" href="<?php echo $theme_link; ?>css/fonts-THSarabun/th-sarabun.css">

<style>
@page {
                margin:25px 25px 25px 25px;
            }
table, th, td {
   border: 0.03pt solid #0070C0;
    border-collapse: collapse;   
    padding: 0px;
}
th, td {
    padding: 2px;
    text-align: left;   
    vertical-align:top 
   
}
body{
  word-wrap: break-word;
  font-family:  "Sarabun PSK", 'sans-serif','Arial';
  font-size: 18px;
  line-height: 1.1;
}
.style_hidden{
  border-style: hidden;
}
.fixed_table{
  table-layout:fixed;
}
.text-center{
  text-align: center;
}
.text-left{
  text-align: left;
}
.text-right{
  text-align: right;
}
.text-bold{
  font-weight: bold;
}
.bg-sky{
  background-color: #E8F3FD;
}
@page { size: A4 margin: 3px; }
body { margin: 3px; }

 #clockwise {
       rotate: 90;
    }

    #counterclockwise {
       rotate: -90;
    }
</style>
</head>
<body onload="window.print();"><!-- window.print() -->
<?php
    $q1=$this->db->query("select * from db_store where status=1 and id=".get_current_store_id());
    $res1=$q1->row();
    $store_name=$res1->store_name;
    $company_mobile=$res1->mobile;
    $company_phone=$res1->phone;
    $company_email=$res1->email;
    $company_country=$res1->country;
    $company_state=$res1->state;
    $company_postcode=$res1->postcode;
    $company_pan_no=$res1->pan_no;
    $company_city=$res1->city;
    $company_address=$res1->address;
    $company_gst_no=$res1->gst_no;
    $company_vat_no=$res1->vat_no;
    $store_logo=(!empty($res1->store_logo)) ? $res1->store_logo : store_demo_logo();
    $store_website=$res1->store_website;
    $bank_details=$res1->bank_details;
    $terms_and_conditions="";//$res1->purchase_terms_and_conditions;

  
    
    $q3=$this->db->query("SELECT a.supplier_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,
                           a.opening_balance,a.country_id,a.state_id,a.created_by,
                           a.postcode,a.address,b.purchase_date,b.created_time,b.reference_no,
                           b.purchase_code,b.purchase_note,b.purchase_status,
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

                           FROM db_suppliers a,
                           db_purchase b 
                           WHERE 
                           a.`id`=b.`supplier_id` AND 
                           b.`id`='$purchase_id' 
                           ");
                         
    
    $res3=$q3->row();
    $supplier_name=$res3->supplier_name;
    $supplier_mobile=$res3->mobile;
    $supplier_phone=$res3->phone;
    $supplier_email=$res3->email;
    $supplier_country=get_country($res3->country_id);
    $supplier_state=get_state($res3->state_id);
    $supplier_address=$res3->address;
    $supplier_postcode=$res3->postcode;
    $supplier_gst_no=$res3->gstin;
    $supplier_tax_number=$res3->tax_number;
    $supplier_opening_balance=$res3->opening_balance;
    $purchase_date=$res3->purchase_date;
    $created_time=$res3->created_time;
    $reference_no=$res3->reference_no;
    $purchase_code=$res3->purchase_code;
    $purchase_note=$res3->purchase_note;
    $purchase_status=$res3->purchase_status;
    $created_by=$res3->created_by;
   
    
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




    
       // ราตารวม vat 0% จะเก็บใน $tot_price_zero_vat
       $tot_price_zero_vat  = 0.0;
       $this->db->select(" a.description,c.item_name, a.sales_qty,a.tax_type,
                           a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                           a.discount_input,a.discount_amt, a.unit_total_cost,
                           a.total_cost , d.unit_name,c.sku,c.hsn
                       ");
       $this->db->where("a.sales_id",$sales_id);
       $this->db->from("db_salesitems a");
       $this->db->join("db_tax b","b.id=a.tax_id","left");
       $this->db->join("db_items c","c.id=a.item_id","left");
       $this->db->join("db_units d","d.id = c.unit_id","left");
       $q4=$this->db->get();
 
       foreach ($q4->result() as $res2) {
         if ($res2->tax == 0){
           $tot_price_zero_vat += $res2->total_cost;
         }
       }
             
       $total_price = $subtotal-$tot_price_zero_vat  ;
       $vat_total =($total_price / $vat_type) *$company_vat_no ;
      // $befor_vat= $total_price - $vat_total ;
          // ราตารวม vat 0% จะเก็บใน $tot_price_zero_vat _end   

    ?>

<caption>
 <!--     <center>
        <span style="font-size: 18px;text-transform: uppercase; margin-top:25px;">
          <?=$this->lang->line('purchase_invoice')?>
        </span>
      </center> -->
</caption>

<table autosize="1" style="overflow: wrap" id='mytable' align="center" width="100%" height='100%'  cellpadding="0" cellspacing="0"  >
<!-- <table align="center" width="100%" height='100%'   > -->
  
    <thead>

      <tr>
        <th colspan="16">
          <table width="100%" height='100%' class="style_hidden fixed_table">
              <tr>
                <!-- First Half -->          
                <td colspan="10">
                <center>
              <!--  <span style="font-size: 18px;text-transform: uppercase; margin-top:25px;">
                <?=$this->lang->line('purchase_invoice')?>             
              </span>-->
             <span style="font-size: 20px;text-transform: uppercase; margin-top:25px;"><?= $this->lang->line('purchase_invoice'); ?> ( <?=$purchase_status;?> )</span>
            
            </center>
                         
                <p style="font-size: 18px; line-height: 1.0; margin-left: 10px">  
                    <span style="font-size: 22px;"><?php echo $store_name; ?></span> <br> 
                    <?php echo $company_address; ?>
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


                    <?php echo (!empty(trim($company_gst_no))) ? $this->lang->line('tax_id')." ".$company_gst_no."  " : '';?>                  
                    <?php echo (!empty(trim($company_pan_no)) && pan_number()) ? $this->lang->line('branch_no')." : ".$company_pan_no."  " : '';?> <br>      
                    <?= $this->lang->line('phone'); ?>: <?php echo  $company_mobile; ?>
                   <?php echo (!empty(trim($company_phone))) ? $this->lang->line('mobile').": ".$company_phone."  " : '';?> <br>     
                    <?php echo (!empty(trim($company_email))) ? $this->lang->line('email').": ".$company_email."<br>" : '';?>        
                  </p>
                </td>

                <!-- Second Half -->
                <td colspan="6">
                  <br>
                <center>
               <img src="<?= base_url($store_logo);?>"  height="80px" width=""> 
               </center>
             </td>
              </tr>

              <tr>
                <!-- Bottom Half -->
                <td colspan="10" >
                  <Div style="font-size: 18px; line-height: 1.0; margin-left: 10px">
                  <b style="font-size:16px;"><?= $this->lang->line('to'); ?></b><br/>
                  <b style="font-size:22px;"><?php echo $this->lang->line('')." ".$supplier_name; ?></b><br/> 
                  <span>                             
                        <?php 
                                if(!empty($supplier_address)){
                                  echo $supplier_address;   
                                }
                                /*if(!empty($supplier_country)){
                                  echo $supplier_country;
                                }
                                if(!empty($supplier_state)){
                                  echo ",".$supplier_state;
                                }
                                if(!empty($supplier_city)){
                                  echo ",".$supplier_city;
                                }
                                if(!empty($supplier_postcode)){
                                  echo "-".$supplier_postcode;
                                }*/
                              ?>
                              <br>
                         <?php echo (!empty(trim($supplier_gst_no))) ? $this->lang->line('tax_id')." ".$supplier_gst_no."<br>" : '';?>
                        <?php echo (!empty(trim($supplier_phone))) ? $this->lang->line('phone').": ".$supplier_phone." " : '';?>
                        <?php echo (!empty(trim($supplier_mobile))) ? $this->lang->line('mobile').": ".$supplier_mobile." " : '';?>    <br>                   
                                           
                  </span>
              
                   </Div>
                </td>

                <td colspan="6" rowspan="1">
                  <span>
                    <table style="width: 100%;" class="style_hidden fixed_table">
                    
                        <tr>
                          <td colspan="6">
                            เลขที่ :
                            <span style="font-size: 22px;">
                              <b><?php echo "$purchase_code"; ?></b>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="6">
                           วันที่ :
                            <span style="font-size:larger;">
                              <b><?php echo show_date($purchase_date); ?></b>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="6">
                          <?= $this->lang->line('reference_no'); ?> :
                            <span style="font-size: 22px;">
                              <b><?php echo "$reference_no"; ?></b>
                            </span>
                          </td>
                          
                        </tr>
                        
                        <tr>
                          <td colspan="6">
                         
                          <span class='amt-in-word'>
                           <?= $this->lang->line('invoiceTerms') ." : <b>". nl2br($purchase_note)."</b>";?>
                          </span>
                          </td>
                        </tr>
                        
                        
                                           
                    </table>
                  </span>
                </td>
              </tr>

           
          </table>
       </th>
      </tr>

      
      <tr class="bg-sky"><!-- Colspan 10 -->
        <th colspan='2' class="text-center"><?= $this->lang->line('sl_no'); ?></th>
        <th colspan='8' class="text-center" ><?= $this->lang->line('description_of_goods'); ?></th>
  
        <th colspan='1' class="text-center"><?= $this->lang->line('qty'); ?></th>     
        <th colspan='2' class="text-center"><?= $this->lang->line('price'); ?></th>     
        <th colspan='1' class="text-center"><?= $this->lang->line('disc.'); ?></th>
    <!--   <th colspan='1' class="text-center"><?= $this->lang->line('vat_amount'); ?></th> -->     
        <th colspan='2' class="text-center"><?= $this->lang->line('amount'); ?></th>
      </tr>
  </thead>

<tbody>
  <tr>
    <td colspan='16'>
     <?php
              $i=1;
              $tot_qty=0;
              $tot_purchase_price=0;
              $tot_tax_amt=0;
              $tot_discount_amt=0;
              $tot_unit_total_cost=0;
              $tot_total_cost=0;
              $tot_before_tax=0;


              $this->db->select(" a.description,c.item_name, a.purchase_qty,a.tax_type,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.discount_input,a.discount_amt, a.unit_total_cost,
                                  a.total_cost , d.unit_name,c.sku,c.hsn
                              ");
              $this->db->where("a.purchase_id",$purchase_id);
              $this->db->from("db_purchaseitems a");
              $this->db->join("db_tax b","b.id=a.tax_id","left");
              $this->db->join("db_items c","c.id=a.item_id","left");
              $this->db->join("db_units d","d.id = c.unit_id","left");
              $q2=$this->db->get();


              foreach ($q2->result() as $res2) {
                  $discount = (empty($res2->discount_input)||$res2->discount_input==0)? '0':$res2->discount_input."%";
                  $discount_amt = (empty($res2->discount_amt)||$res2->discount_input==0)? '0':$res2->discount_amt."";
                  $before_tax=$res2->unit_total_cost;// * $res2->purchase_qty;
                  $tot_cost_before_tax=$before_tax * $res2->purchase_qty;

                  
                  echo "<tr>";  
                  echo "<td colspan='2' class='text-center'>".$i++."</td>";
                  echo "<td colspan='8'>";
                  echo $res2->item_name;
                  echo (!empty($res2->description)) ? "<br><i>[".nl2br($res2->description)."]</i>" : '';
                  echo "</td>";          
                  echo "<td colspan='1' class='text-center'>".format_qty($res2->purchase_qty)."</td>";
                 echo "<td colspan='2' class='text-right'>".store_number_format($res2->price_per_unit)."</td>";                                 
               //  echo "<td style='text-align: right;'>".$discount."</td>";
                 echo "<td style='text-align: right;'>".store_number_format($discount_amt)."</td>";
                          
                  echo "<td colspan='2' class='text-right'>".store_number_format($res2->total_cost)."</td>";
                  echo "</tr>";  
                  $tot_qty +=$res2->purchase_qty;
                  $tot_purchase_price +=$res2->price_per_unit;
                  $tot_tax_amt +=$res2->tax_amt;
                  $tot_discount_amt +=$res2->discount_amt;
                  $tot_unit_total_cost +=$res2->unit_total_cost;
                  $tot_before_tax +=$before_tax;
                  $tot_total_cost +=$res2->total_cost;

               
                                 
                  $dis = $subtotal / 100 ;
                  $dis_total = $tot_discount_to_all_amt / $dis ;
                  $dis_tax = $subtotal - $tot_price_zero_vat;
                  $dis_non_tax = $tot_price_zero_vat;
                  $dis_non = $dis_non_tax - (($dis_non_tax/100) * $dis_total) ;
                  $dis_tax_new = $dis_tax - (($dis_tax/100) * $dis_total) ;

                  $vat_amt2 = $company_vat_no +100 ;
                  $vat_amt =( $dis_tax_new / $vat_amt2) * $company_vat_no ;

                 // $grand_total =  $dis_non +  $dis_tax_new ;



              }
              ?>
      </td>
  </tr>
  </tbody>


<tfoot>
 

<!--  <tr class="bg-sky">
    <td colspan="8" class='text-center text-bold'><?= $this->lang->line('total'); ?></td>
    <td colspan="2" class='text-right' ><b></td>
    <td colspan="1" class='text-bold text-center'><?=format_qty($tot_qty); ?></td>
   
    <td colspan="2" class='text-right' ><b></td>
    <td colspan=" " class='text-right'><b><?php echo store_number_format($tot_discount_amt); ?></b></td>
    <td colspan="1 " class='text-right' ></td>

    <td colspan="3" class='text-right' ><b><?php echo store_number_format($tot_total_cost); ?></b></td>
  </tr>-->
  
          <tr>
       <td colspan='16' style="height:2px;"></td>
          </tr>
   

            <tr>
              <td colspan="14" class='text-right'><b><?= $this->lang->line('subtotal'); ?></b></td>
              <td colspan="2" class='text-right' ><b><?php echo store_number_format($tot_total_cost); ?></b></td>
            </tr>
            
            <?php if(!empty($tot_price_zero_vat !=0)){ ?>
            <tr>
                <td colspan="14" class='text-right'><b><?= $this->lang->line('total_zero_vat'); ?></b></td>
                <td colspan="2" class='text-right' ><b><?php echo store_number_format($dis_non_tax); ?></b></td>
            </tr>
            <?php } ?>

            
            <tr>
              <td colspan="14" class='text-right'><b><?= $this->lang->line('total_item_vat'); ?></b></td>
              <td colspan="2" class='text-right' ><b><?php echo store_number_format($dis_tax); ?></b></td>
            </tr>
           

            <?php if(!empty($tot_discount_to_all_amt !=0)){ ?>
            <tr>
              <td colspan="14" class='text-right'><b><?= $this->lang->line('discount_on_sale'); ?></b>
              <?=store_number_format($discount_to_all_input); ?> (<?= $discount_to_all_type ?>) </td></td>
              <td colspan="2" class='text-right' ><b><?php echo store_number_format( $tot_discount_to_all_amt); ?></b></td>
            </tr>
            <?php } ?>

            <tr>
            <td colspan="16" style="height:3px;"></td>       
            </tr>
        
            <?php if(!empty($tot_price_zero_vat !=0)){ ?>
            <tr>
                <td colspan="13" class='text-right'><b><?= $this->lang->line('total_zero_vat'); ?></b></td>
                <td colspan="3" class='text-right' ><b><?php echo store_number_format( $dis_non  ); ?></b></td>
            </tr>
            <?php } ?> 
           
            <tr>
                <td colspan="14" class='text-right'><b><?= $this->lang->line('before_amt'); ?></b></td>
                <td colspan="2" class='text-right' ><b><?php echo store_number_format( $dis_tax_new - $vat_amt); ?></b></td>
            </tr>  
            <tr>
                <td colspan="14" class='text-right'><b><?= $this->lang->line('tax_amount') . store_number_format($company_vat_no)." % "; ?></b></td>
                <td colspan="2" class='text-right' ><b><?php echo store_number_format($vat_amt ) ; ?></b></td>
            </tr> 
         
            
            <tr>
                <td colspan="14" class='text-right'><b><?= $this->lang->line('grand_total'); ?></b></td>
                <td colspan="2" class='text-right' ><b><?php echo store_number_format($grand_total); ?></b></td>
            </tr>
            
            
            
            
           <!-- 
            
            <?php if(!empty($tot_discount_to_all_amt !=0)){ ?>
                      <tr>
                        <td colspan="14" class='text-right'><b><?= $this->lang->line('discount_on_sale'); ?></b>
                        <?=store_number_format($discount_to_all_input); ?> (<?= $discount_to_all_type ?>) </td></td>
                        <td colspan="2" class='text-right' ><b><?php echo store_number_format( $tot_discount_to_all_amt); ?></b></td>
                      </tr>
                 <?php } ?>
          
            <tr>
            <td colspan='16' style="height:2px;"></td>
            </tr>

            <tr>
                <td colspan="14" class='text-right'><b><?= $this->lang->line('before_amt'); ?></b></td>
                <td colspan="2" class='text-right' ><b><?php echo store_number_format( $grand_total - $vat_amt); ?></b></td>
            </tr>  
            <tr>
                <td colspan="14" class='text-right'><b><?= $this->lang->line('tax_amount') . store_number_format( $res2->tax)." % "; ?></b></td>
                <td colspan="2" class='text-right' ><b><?php echo store_number_format($vat_amt ) ; ?></b></td>
            </tr> 
         

            <tr>
              <td colspan="14" class='text-right'><b><?= $this->lang->line('grand_total'); ?></b></td>
              <td colspan="2" class='text-right' ><b><?php echo store_number_format($grand_total );?></b></td>
            </tr>
            -->
            
       <tr>  
            <td colspan="16">
    
          <!-- function Bath-->
          <!-- start -->
          <?php
          const BAHT_TEXT_NUMBERS = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
          const BAHT_TEXT_UNITS = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
          const BAHT_TEXT_ONE_IN_TENTH = 'เอ็ด';
          const BAHT_TEXT_TWENTY = 'ยี่';
          const BAHT_TEXT_INTEGER = 'ถ้วน';
          const BAHT_TEXT_BAHT = 'บาท';
          const BAHT_TEXT_SATANG = 'สตางค์';
          const BAHT_TEXT_POINT = 'จุด';

          /**
           * Convert baht number to Thai text
           * @param double|int $number
           * @param bool $include_unit
           * @param bool $display_zero
           * @return string|null
           */
          function baht_text ($number, $include_unit = true, $display_zero = true)
          {
              if (!is_numeric($number)) {
                  return null;
              }

              $log = floor(log($number, 10));
              if ($log > 5) {
                  $millions = floor($log / 6);
                  $million_value = pow(1000000, $millions);
                  $normalised_million = floor($number / $million_value);
                  $rest = $number - ($normalised_million * $million_value);
                  $millions_text = '';
                  for ($i = 0; $i < $millions; $i++) {
                      $millions_text .= BAHT_TEXT_UNITS[6];
                  }
                  return baht_text($normalised_million, false) . $millions_text . baht_text($rest, true, false);
              }

              $number_str = (string)floor($number);
              $text = '';
              $unit = 0;

              if ($display_zero && $number_str == '0') {
                  $text = BAHT_TEXT_NUMBERS[0];
              } else for ($i = strlen($number_str) - 1; $i > -1; $i--) {
                  $current_number = (int)$number_str[$i];

                  $unit_text = '';
                  if ($unit == 0 && $i > 0) {
                      $previous_number = isset($number_str[$i - 1]) ? (int)$number_str[$i - 1] : 0;
                      if ($current_number == 1 && $previous_number > 0) {
                          $unit_text .= BAHT_TEXT_ONE_IN_TENTH;
                      } else if ($current_number > 0) {
                          $unit_text .= BAHT_TEXT_NUMBERS[$current_number];
                      }
                  } else if ($unit == 1 && $current_number == 2) {
                      $unit_text .= BAHT_TEXT_TWENTY;
                  } else if ($current_number > 0 && ($unit != 1 || $current_number != 1)) {
                      $unit_text .= BAHT_TEXT_NUMBERS[$current_number];
                  }

                  if ($current_number > 0) {
                      $unit_text .= BAHT_TEXT_UNITS[$unit];
                  }

                  $text = $unit_text . $text;
                  $unit++;
              }

              if ($include_unit) {
                  $text .= BAHT_TEXT_BAHT;

                  $satang = explode('.', number_format($number, 2, '.', ''))[1];
                  $text .= $satang == 0
                      ? BAHT_TEXT_INTEGER
                      : baht_text($satang, false) . BAHT_TEXT_SATANG;
              } else {
                  $exploded = explode('.', $number);
                  if (isset($exploded[1])) {
                      $text .= BAHT_TEXT_POINT;
                      $decimal = (string)$exploded[1];
                      for ($i = 0; $i < strlen($decimal); $i++) {
                          $text .= BAHT_TEXT_NUMBERS[$decimal[$i]];
                      }
                  }
              }

              return $text;
          }
          ?>
        <!-- end -->

      <?php
    
        echo "<span class='amt-in-word'>".$this->lang->line('amount_in_words').": <i style='font-weight:bold;'>".baht_text($grand_total)."</i></span>";

       ?>

      </td>
   </tr>


      <!-- T&C & Bank Details & signatories-->
      <tr>
        <td colspan="16">
          <table width="100%" class="style_hidden fixed_table">
           
              <tr>
                <td colspan="16">
                              <span>
                                <table style="width: 100%;" class="style_hidden fixed_table">
                                
                                    <!-- T&C & Bank Details -->
                                <!--    <tr>
                                      <td colspan="16">
                                        <span><b> <?= $this->lang->line('terms_and_conditions'); ?></b></span><br>
                                        <span style='font-size: 8px;'><?= nl2br($terms_and_conditions);  ?></span>
                                      </td>
                                    </tr> -->
                     
                         <tr>
                          <td colspan='8' style="height:50px;">
                            <p><b> <?= $this->lang->line('manage_purchase_item'); ?></b></p>
                            <br/><br/>
                <center>            <p style="font-size: 18px; ">วันที่.................../.............................../..................</p> </center>
                          </td>
                          <td colspan='8' >
                            <p><b><?= $this->lang->line('authorised_signature'); ?></b></p>
                      

                          </td>
                        </tr>
                     
                    </table>
                  </span>
                </td>
              </tr>
           
          </table>
      </td>
      </tr>
      <!-- T&C & Bank Details & signatories End -->

  
</tfoot>

</table>
<!-- <caption>
      <center>
        <span style="font-size: 11px;text-transform: uppercase;">
          This is Computer Generated Invoice
        </span>
      </center>
</caption> -->
</body>
</html>
