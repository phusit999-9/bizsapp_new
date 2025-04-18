<!DOCTYPE html>
<html>
<title><?= $page_title;?></title>
<head>
<?php // $this->load->view('comman/code_css.php');?>
<link rel='shortcut icon' href='<?php echo $theme_link; ?>images/favicon.ico' />

<style>
@page {
                margin: 10px 20px 10px 20px;
            }
table, th, td {
    border: 0.5pt solid #0070C0;
    border-collapse: collapse;   

}
th, td {
    padding: 2px;
    text-align: left;   
    vertical-align:top 
}
body{
  word-wrap: break-word;
  font-family:  'sans-serif','Arial';
  font-size: 14px;
  /*height: 210mm;*/
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
@page { size: A5 margin: 5px; }
body { margin: 5px; }

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
    $company_city=$res1->city;
    $company_address=$res1->address;
    $company_gst_no=$res1->gst_no;
    $company_vat_no=$res1->vat_no;
    $store_logo=(!empty($res1->store_logo)) ? $res1->store_logo : store_demo_logo();
    $store_website=$res1->store_website;
    $bank_details=$res1->bank_details;
    $terms_and_conditions="";//$res1->sales_terms_and_conditions;
    $image_file=($res1->show_signature && !empty($res1->signature)) ? $res1->signature : '';
    
    $q3=$this->db->query("SELECT b.expire_date,b.customer_previous_due,b.customer_total_due,a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,a.shippingaddress_id,
                           a.opening_balance,a.country_id,a.state_id,a.created_by,
                           a.postcode,a.address,b.quotation_date,b.created_time,b.reference_no,
                           b.quotation_code,b.quotation_note,b.quotation_status,
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
                           db_quotation b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$quotation_id' 
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
    $quotation_date=$res3->quotation_date;
    $expire_date=(!empty($res3->expire_date)) ? show_date($res3->expire_date) : '';
    $created_time=$res3->created_time;
    $reference_no=$res3->reference_no;
    $quotation_code=$res3->quotation_code;
    $quotation_note=$res3->quotation_note;
    $quotation_status=$res3->quotation_status;
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
    
    $shipping_country='';
    $shipping_state='';
    $shipping_city='';
    $shipping_address='';
    $shipping_postcode='';
    if(!empty($res3->shippingaddress_id)){
        $Q2 = $this->db->select("c.country,s.state,a.city,a.postcode,a.address")
                        ->where("a.id",$res3->shippingaddress_id)
                        ->from("db_shippingaddress a")
                        ->join("db_country c","c.id = a.country_id",'left')
                        ->join("db_states s","s.id = a.state_id",'left')
                        ->get();                    
        if($Q2->num_rows()>0){
          $shipping_country=$Q2->row()->country;
          $shipping_state=$Q2->row()->state;
          $shipping_city=$Q2->row()->city;
          $shipping_address=$Q2->row()->address;
          $shipping_postcode=$Q2->row()->postcode;
        }
      }


    ?>

<caption>
     
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
                <span style="font-size: 18px;text-transform: uppercase;">
                 <?= $this->lang->line('quotation_doc') ?>
                 </span>
                 </center>

                  <b style="font-size: 15px;"><?php echo $store_name; ?></b>
                  <?php echo (!empty(trim($company_vat_no))) ? $this->lang->line('')."  ".$company_vat_no." " : '';?> <br>
                 
                  <span style="font-size: 13px;">
                    <?php echo $company_address; ?><br/>    
                    <?php echo (!empty(trim($company_gst_no))) ? $this->lang->line('gst_number_tax')." ".$company_gst_no."<br>" : '';?>              
                    <?php echo $this->lang->line('phone').":".$company_mobile; ?><br/>                   
                    <?php echo (!empty(trim($company_email))) ? $this->lang->line('email').": ".$company_email."<br>" : '';?>         
                  
                    <br>
                  </span>
                </td>

                <!-- Second Half -->
                <td colspan="6" rowspan="1">
                  <br>
          <center>  <img src="<?= base_url($store_logo);?>" style="height:80%" width=" "></center> 
                </td>
               
            
              </tr>

              <tr>
                <!-- Bottom Half -->
                 <td colspan="10">
                 <span style="font-size: 12px;"> <?= $this->lang->line('customer'); ?><br/></span>
                    <span style="font-size: 14px;">
                      <?php echo $this->lang->line(' ')."  ".$customer_name; ?><br/>
                      
                        <?php 
                                if(!empty($customer_address)){
                                  echo $customer_address;
                                }
                           /*     if(!empty($customer_country)){
                                  echo $customer_country;
                                }
                                if(!empty($customer_state)){
                                  echo ",".$customer_state;
                                }
                                if(!empty($customer_city)){
                                  echo ",".$customer_city;
                                }
                                if(!empty($customer_postcode)){
                                  echo "-".$customer_postcode;
                                } */
                              ?>
                              <br>

                              <?php echo (!empty(trim($customer_gst_no))) ? $this->lang->line('gst_number_tax')."  ".$customer_gst_no."<br>" : '';?>
                             
                              <?php echo (!empty(trim($customer_phone))) ? $this->lang->line('phone').": ".$customer_phone." " : '';?>
                              <?php echo (!empty(trim($customer_mobile))) ? $this->lang->line('mobile').": ".$customer_mobile."<br>" : '';?>
                      </span>
                 </td>
                 <td colspan="6" rowspan="1">
                  <span>
                    <table style="width: 100%;" class="style_hidden fixed_table">
                    
                        <tr>
                          <td colspan="8">
                            เลขที่  No. 
                            <span style="font-size: 16px;">
                              <b><?php echo "$quotation_code"; ?></b>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            Dated:<br>
                            <span style="font-size: 13px;">
                              <b><?php echo show_date($quotation_date); ?></b>
                            </span>
                          </td>
                          <td colspan="4">
                            Expire Date:<br>
                            <span style="font-size: 13px;">
                              <b><?php echo $expire_date; ?></b>
                            </span>
                          </td>
                        </tr>

                        <tr>
                          <td colspan="8">
                            Reference No.<br>
                            <span style="font-size: 13px;">
                              <b><?php echo "$reference_no"; ?></b>
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

      <tr>
        <td colspan="16">&nbsp; </td>
      </tr>
      <tr class="bg-sky"><!-- Colspan 10 -->
        <th colspan='2' class="text-center"><?= $this->lang->line('sl_no'); ?></th>
        <th colspan='6' class="text-center" ><?= $this->lang->line('description_of_goods'); ?></th>
    <!--    <th colspan='2' class="text-center"><?= $this->lang->line('hsn'); ?></th> -->
        <th colspan='1' class="text-center"><?= $this->lang->line('qty'); ?></th>
        <th colspan='2' class="text-center"><?= $this->lang->line('unit_cost'); ?></th>   
        <th colspan='1' class="text-center"><?= $this->lang->line('disc.'); ?></th>  
        <th colspan='1' class="text-center"><?= $this->lang->line('tax'); ?></th>
        <th colspan='1' class="text-center"><?= $this->lang->line('tax_amt'); ?></th>
       
        <!-- <th colspan='2' class="text-center"><?= $this->lang->line('rate'); ?></th> -->
        <th colspan='2' class="text-center"><?= $this->lang->line('amount'); ?></th>
      </tr>
  </thead>



<tbody>
  <tr>
    <td colspan='16'>
 <?php
              $i=1;
              $tot_qty=0;
              $tot_quotation_price=0;
              $tot_tax_amt=0;
              $tot_discount_amt=0;
              $tot_unit_total_cost=0;
              $tot_total_cost=0;
              $tot_before_tax=0;
              /*$q2=$this->db->query("SELECT a.description,c.item_name, a.quotation_qty,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.discount_input,a.discount_amt, a.unit_total_cost,
                                  a.total_cost , d.unit_name,c.hsn
                                  FROM 
                                  db_quotationitems AS a,db_tax AS b,db_items AS c , db_units as d
                                  WHERE 
                                  d.id = c.unit_id and
                                  c.id=a.item_id AND b.id=a.tax_id AND a.quotation_id='$quotation_id'");*/

              $this->db->select(" a.description,c.item_name, a.quotation_qty,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.discount_input,a.discount_amt, a.unit_total_cost,
                                  a.total_cost , d.unit_name,c.hsn
                              ");
              $this->db->where("a.quotation_id",$quotation_id);
              $this->db->from("db_quotationitems a");
              $this->db->join("db_tax b","b.id=a.tax_id","left");
              $this->db->join("db_items c","c.id=a.item_id","left");
              $this->db->join("db_units d","d.id = c.unit_id","left");
              $q2=$this->db->get();
              
              foreach ($q2->result() as $res2) {
                  $discount = (empty($res2->discount_input)||$res2->discount_input==0)? '0':$res2->discount_input."%";
                  $discount_amt = (empty($res2->discount_amt)||$res2->discount_input==0)? '0':$res2->discount_amt."";
                  $before_tax=$res2->unit_total_cost;// * $res2->quotation_qty;
                  $tot_cost_before_tax=$before_tax * $res2->quotation_qty;

                  
                  echo "<tr>";  
                  echo "<td colspan='2' class='text-center'>".$i++."</td>";
                  echo "<td colspan='6'>";
                  echo $res2->item_name;
                  echo (!empty($res2->description)) ? "<br><i>[".nl2br($res2->description)."]</i>" : '';
                  echo "</td>";
              //    echo "<td colspan='2' class='text-left'>".$res2->hsn."</td>";
                 echo "<td class='text-center'>".format_qty($res2->quotation_qty)."</td>";
                  echo "<td colspan='2' class='text-right'>".store_number_format($res2->price_per_unit)."</td>";
                  echo "<td style='text-align: right;'>".store_number_format($discount_amt)."</td>";           
                  echo "<td colspan='1' class='text-right'>".store_number_format($res2->tax)."%</td>";
                  echo "<td style='text-align: right;'>".store_number_format($res2->tax_amt)."</td>";
                  //echo "<td style='text-align: right;'>".$discount."</td>";
                  
 
                  //echo "<td colspan='2' class='text-right'>".number_format($before_tax,2)."</td>";
                  //echo "<td class='text-right'>".$res2->price_per_unit."</td>";
                  
                  echo "<td colspan='2' class='text-right'>".store_number_format($res2->total_cost)."</td>";
                  echo "</tr>";  
                  $tot_qty +=$res2->quotation_qty;
                  $tot_quotation_price +=$res2->price_per_unit;
                  $tot_tax_amt +=$res2->tax_amt;
                  $tot_discount_amt +=$res2->discount_amt;
                  $tot_unit_total_cost +=$res2->unit_total_cost;
                  $tot_before_tax +=$before_tax;
                  $tot_total_cost +=$res2->total_cost;

              }
              ?>
      </td>
  </tr>
 
 

  <tr class="bg-sky">
    <td colspan="8" class='text-center text-bold'><?= $this->lang->line('total'); ?></td>
    <td colspan="1" class='text-bold text-center'><?=format_qty($tot_qty); ?></td>
    <td colspan="2" class='text-right' ></td>
    <td colspan="1" class='text-right' ><b><?php echo store_number_format($tot_discount_amt); ?></b></td>
    <td colspan="1" class='text-bold text-center'></td>
        
    <td colspan="1" class='text-right' ><b><?php echo store_number_format($tot_tax_amt); ?></b></td>
   
    <td colspan="2" class='text-right' ><b><?php echo store_number_format($tot_total_cost); ?></b></td>
  </tr>
 
 
  <tr>
    <td colspan='16' style="height:12px;"></td>
  
  </tr>
  <tr>
    <td colspan="14" class='text-right'><b><?= $this->lang->line('pre_tax_amount'); ?></b></td>
    <td colspan="2" class='text-right' ><b><?php echo store_number_format($tot_total_cost - $tot_tax_amt); ?></b></td>
  </tr>


  <tr>
    <td colspan="14" class='text-right'><b><?= $this->lang->line('tax_amount'); ?></b></td>
    <td colspan="2" class='text-right' ><b><?php echo store_number_format( $tot_tax_amt); ?></b></td>
  </tr>
  
  <tr>
    <td colspan="14" class='text-right'><b><?= $this->lang->line('grand_total'); ?></b></td>
    <td colspan="2" class='text-right' ><b><?php echo store_number_format($grand_total); ?></b></td>
  </tr>
  
  
  
  <tr>   
<td colspan="16">
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

<?php
     
      echo "<span class='amt-in-word'>".$this->lang->line('amount_in_words').": <i style='font-weight:bold;'>".baht_text($grand_total)."</i></span>";

      ?>
  
</td>
  </tr>
  
  <tr>
    <td colspan="16">
      <span class='amt-in-word'>
        <?= $this->lang->line('note') .":<b>". nl2br($quotation_note)."</b>";?>
    </span>  
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
                        <!-- <tr>
                          <td colspan="16">
                            <span><b> <?= $this->lang->line('terms_and_conditions'); ?></b></span><br>
                            <span style='font-size: 8px;'><?= nl2br($terms_and_conditions);  ?></span>
                          </td>
                        </tr>
 -->
                         <tr>
                          <td colspan='8' style="height:60px;">
                            <span><b> <?= $this->lang->line('quotation_signature'); ?></b></span>
                          </td>
                          <td colspan='8'>
                            <span><b> <?= $this->lang->line('authorised_signatory'); ?></b></span><br>
                            
                     <center>  <img src="<?= base_url($image_file);?>" width='50%' height='auto'> </center>
                            
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

      
    
      
</tbody>

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
