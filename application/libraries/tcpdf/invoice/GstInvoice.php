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



include('MyPDF.php');

class GstInvoice extends MyPDF{
	//public $CI=null;

	protected $sales_id =null;

	//public $store =array();

	protected $customer =array();

	protected $sales =array();

	public $customer_state_name = null;


	public function __construct(array $param=array())
	{
		parent::__construct();

		$this->sales_id = $param['sales_id'];

		//$this->CI =& get_instance();

		//$this->store = get_store_details();//Declared in MyPDF Pa

		$this->sales = get_sales_details($this->sales_id);

		$this->customer = get_customer_details($this->sales->customer_id);

	}
	public function _get_customer_details()
    {   

    	$customer = $this->customer;//array()

    	$store = $this->store;//array()

 
        $w = 100;
        $h = 35;

		$custmer_details .= '<div style="line-height: 0.7;">';
		$custmer_details = '<span style="color:rgb(65, 59, 212);">'.$this->CI->lang->line('bill_to').'</span>';
        $custmer_details .= "<br><b>".$this->CI->lang->line('name')." :</b> ".$customer->customer_name;
        $custmer_details .= "<br><b>".$this->CI->lang->line('address')." :</b> ".$customer->address;
		$custmer_details .= "<b>".$this->CI->lang->line(' ')." </b> ".$customer->postcode;
		$custmer_details .= (!empty($customer->gstin)) ? "<br><b>".$this->CI->lang->line('gst_number')." </b> ".$customer->gstin : '';
        $custmer_details .= "<br><b>".$this->CI->lang->line('phone')." :</b> ".$customer->phone;
        $custmer_details .= " , ".$this->CI->lang->line('mobile')." : ".$customer->mobile;
		$custmer_details .= '</div>'  ; 
        //$this->setCellMargins(1,1,1,1);
        $this->setCellPaddings(2,1,1,1);
        $this->setFont($this->get_font_name(), '', 15);
        $this->setFillColor(255, 255, 255);
        $this->writeHTMLCell($w, $h, $x ='6', $y='47', $custmer_details, 1, 0, 1, true, 'J', true);
        return $this;
    } 

    public function _get_invoice_details()
    {
    	$sales = $this->sales;//array()

        $w = 100;
        $h = 35;
        $invoice_details = '<div style="line-height: 1;">';
        $invoice_details = '<span style="color:rgb(65, 59, 212);font-style:italic;">'.$this->CI->lang->line('original').'</span>'; 
        $invoice_details .= '<br>'.$this->CI->lang->line('invoice_no').' : '.($sales->sales_code).'</span>';		
        $invoice_details .= '<br><b>'.$this->CI->lang->line('date').' :</b> <span style="">'.show_date($sales->sales_date).'</span>';
	  //  $invoice_details .= '<br><b>'.$this->CI->lang->line('due_date').' :</b> <span style="">'.((!empty($sales->due_date)) ? show_date($sales->due_date):'').'</span>';           	  
	    $invoice_details .= '<br><b>'.$this->CI->lang->line('tax_included').'  </b> <span style=""></span>';
        $invoice_details .= '</div>'  ; 

        $this->writeHTMLCell($w, $h, $x ='104', $y='', $invoice_details, 1, 1, 1, true, 'J', true);
        return $this;
    }
  
 
   
	public function show_pdf()
	{
		$this->_main_body();
	}


	public function _main_body()
	{	
		$sales 		= $this->sales;//array()
		$store 		= $this->store;//array()
		$customer 	= $this->customer;//array()
			
	

		$this->_invoice_name = "ใบเสร็จรับเงิน/ใบกำกับภาษีอย่างย่อ";

		$this->page_title = "ใบเสร็จรับเงิน";

		//Don't change this
		$this->_invoice_format = 'Delivery Note';

		$this->_QRCODE = $sales->sales_code;

		// set font
		$this->setFont($this->get_font_name(), 'B', 20);

		// add a page
		$this->AddPage();

		// Cusomer Details
		$this->_get_customer_details(); 

		// Cusomer Details
		$this->_get_invoice_details();


		//Set document name (footer -R)
		$this->_set_document_name($this->CI->lang->line("invoice_number"));
		
		//Sey document number (footer -R)
		$this->_set_document_number($sales->sales_code);

		//Search Coupon Details
		$coupon_code = $coupon_type = '';
	    $coupon_value=0;
	    if(!empty($sales->coupon_id)){
	      $coupon_details =get_customer_coupon_details($sales->coupon_id);
	      $coupon_code =$coupon_details->code;
	      $coupon_value =$coupon_details->value;
	      $coupon_type =$coupon_details->type;
	    } 
		$this->setFont($this->get_font_name(), '', 12);

		// set cell padding
		$this->setCellPaddings(1, 1, 1, 1);

		// set cell margins
		//$this->setCellMargins(1, 1, 1, 1);

		// set color for background
		$this->setFillColor(255, 255, 255);

		$this->Ln(0);

		

		$this->setFont($this->get_font_name(), '', 14);
		
		
		$tbl = '
		<style type="text/css">
			table, td, th {
			    border-collapse: collapse;
			    border: 0.01px solid  #15217A   ;
			    
			}
			
			table + table, table + table tr:first-child th, table + table tr:first-child td {
			    border-top: 0;
			}
			.text-right{
				text-align: right;
			}
			.text-center{
				text-align: center;
			}
			.text-bold{
				font-weight: bold;
			}
			.bg-light-blue{
				background-color: #e4eaff;
			}
			
		</style>
		
		<table >';

			$widthArray = array(
				'sl_no' 		=> '9',
				'description' 	=> '30',
				'qty' 			=> '10',
				'unit_cost' 	=> '10',				
				'disc.' 		=> '10',
				'vat'       	=> '11',
				
				'amount' 		=> '20',

			);

			//Sum the value
			$sumOfWidth = 0;

			$colW =array();
			foreach($widthArray as $key => $val){
				

				//Update value
				$colWidthSize[$key] = $val;

				//New Array => Reasssign % symbol
				$colW[$key] = $val.'%';

				//Sum of value
				$sumOfWidth+=$val;
			}

			
			
		    $tbl .='<thead>
		        <tr class="bg-light-blue text-bold">
			        <th colspan="1" class="text-center" style="width: '.$colW['sl_no'].'">'.$this->CI->lang->line("no").'</th>
			        <th colspan="1" class="text-center" style="width: '.$colW['description'].'" >'.$this->CI->lang->line("description").'</th>
			        <th colspan="1" class="text-center" style="width: '.$colW['qty'].'">'.$this->CI->lang->line("qty").'</th>
			        <th colspan="1" class="text-center" style="width: '.$colW['unit_cost'].'">'.$this->CI->lang->line("unit_cost").'</th>
					<th colspan="1" class="text-center" style="width: '.$colW['disc.'].'">'.$this->CI->lang->line("disc.").'</th>
			        <th colspan="1" class="text-center" style="width: '.$colW['vat'].'">'.$this->CI->lang->line("vat").'</th>			   	      
			        <th colspan="1" class="text-center" style="width: '.$colW['amount'].'">'.$this->CI->lang->line("subtotal").'</th>
		        </tr>
		    </thead>
		    <tbody>';
		        
		      $i=1;
              $tot_qty=0;
              $tot_sales_price=0;
              $tot_tax_amt=0;
              $tot_discount_amt=0;
              $tot_unit_total_cost=0;
              $tot_total_cost=0;
              $tot_before_tax=0;
              $total_cost=0;
              
              $tot_price_per_unit=0;
              $sum_of_tot_price=0;

			  $vat_type =($company_vat_no + 100);
			  $vat_amt =($grand_total / $vat_type) *$company_vat_no ;
			  $befor_vat = $grand_total - $vat_amt ;





          

              $this->CI->db->select(" a.description,c.item_name, a.sales_qty,a.tax_type,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.discount_input,a.discount_amt, a.unit_total_cost,
                                  a.total_cost , d.unit_name,c.sku,c.hsn
                              ");
              $this->CI->db->where("a.sales_id",$this->sales_id);
              $this->CI->db->from("db_salesitems a");
              $this->CI->db->join("db_tax b","b.id=a.tax_id","left");
              $this->CI->db->join("db_items c","c.id=a.item_id","left");
              $this->CI->db->join("db_units d","d.id = c.unit_id","left");

              $q2=$this->CI->db->get();

		        foreach ($q2->result() as $res2) {
                  $discount = (empty($res2->discount_input)||$res2->discount_input==0)? store_number_format(0):store_number_format($res2->discount_input)."%";
                  $discount_amt = (empty($res2->discount_amt)||$res2->discount_input==0)? '0':$res2->discount_amt."";
                  $before_tax =$res2->price_per_unit;// * $res2->sales_qty;
                  $unit_cost = $before_tax + $discount;
				 
				  $total_cost=$res2->total_cost;//$total * $res2->sales_qty;

                  $unit_total_cost = $res2->unit_total_cost;// - ($res2->tax_amt/$res2->sales_qty);

                  $tax_type = ($res2->tax_type=='Exclusive') ? 'Exc.' : 'Inc.';
				  $res2->tax_amt;
				  $total_before_tax= $total_cost -  $res2->tax_amt;

                 $tbl .='<tr style="" nobr="true">';
				      $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['sl_no'].'">'.$i++.'</td>';
				      $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['description'].'" >';
				      $tbl .= $res2->item_name;
				      $tbl .= (!empty($res2->description)) ? "<br><i>[".nl2br($res2->description)."]</i>" : '';
				      $tbl .= '</td>';
				      $tbl .='<td colspan="1" class="text-right" style="width: '.$colW['qty'].'">'.format_qty($res2->sales_qty).'</td>';
					  $tbl .='<td colspan="1" class="text-right" style="width: '.$colW['unit_cost'].'">'.store_number_format($before_tax).'</td>';
					  $tbl .='<td colspan="1" class="text-right" style="width: '.$colW['disc.'].'">'.store_number_format($discount_amt).'</td>';					 
					  $tbl .='<td colspan="1" class="text-center" style="width: '.$colW['vat'].'">'.store_number_format($res2->tax)." ".$tax_type.'</td>';				          					  				    
				      $tbl .='<td colspan="1" class="text-right" style="width: '.$colW['amount'].'">'.store_number_format( $total_cost).'</td>';
		          $tbl .='</tr>';

                  $tot_qty +=$res2->sales_qty;
                  $tot_sales_price +=$res2->price_per_unit;
                  $tot_tax_amt +=$res2->tax_amt;
                  $tot_discount_amt +=$res2->discount_amt;
                  $tot_unit_total_cost +=$unit_total_cost;
                  $tot_before_tax +=$total_before_tax;
                  $tot_total_cost +=$total_cost;
				 
				  $vat_amt = ($sales->grand_total) / ($res2->tax +100) * $res2->tax ;
				  $befor_vat = ($sales->grand_total) - $vat_amt ;
				   
				}

		    $tbl .='</tbody>		    
	  	</table>
		';

		$tbl .='<table>
		            <tbody>';
               
				 $tbl .='<tr nobr="true" class="text-bold">';
				 $tbl .='<td colspan="12" class="text-right">';
				 $tbl .='';
				  $tbl .='</td>';
				 $tbl .='</tr>'; 


                       ////Discount on All
		                $tbl .='<tr nobr="true">
						<td colspan="7" class="text-right" style="width:'.($sumOfWidth-$colWidthSize['amount']).'%">';
						$tbl .=$this->CI->lang->line("discount_on_sale");
					//	$tbl .="[";
					//	$tbl .=store_number_format($sales->discount_to_all_input)." ".(($sales->discount_to_all_type=='percentage') ? '฿' : '%');
					//	$tbl .="]";
						$tbl .='</td>';
						$tbl .='<td colspan="1" class="text-right" style="width:'.($colWidthSize['amount']).'%">';
						$tbl .=store_number_format($sales->tot_discount_to_all_amt) ;
						$tbl .='</td>';
					    $tbl .='</tr>';
                        

		                //Total Before Tax
		             /*   $tbl .='<tr nobr="true">
		                	<td colspan="7" class="text-right" style="width:'.($sumOfWidth-$colWidthSize['amount']).'%">';
		                	$tbl .=$this->CI->lang->line("before_tax_total");
		                	$tbl .='</td>';
		                	$tbl .='<td colspan="1" class="text-right" style="width:'.($colWidthSize['amount']).'%">';
		                	$tbl .=store_number_format($befor_vat);
		                	$tbl .='</td>';
		                $tbl .='</tr>';  */

		                //Tax Total
		             /*   $tbl .='<tr nobr="true">
		                	<td colspan="7" class="text-right" style="width:'.($sumOfWidth-$colWidthSize['amount']).'%">';
		                	$tbl .=$this->CI->lang->line("tax_amt");
		                	$tbl .='</td>';
		                	$tbl .='<td colspan="1" class="text-right" style="width:'.($colWidthSize['amount']).'%">';
		                	$tbl .=store_number_format( $vat_amt);
		                	$tbl .='</td>';
		                $tbl .='</tr>';  
	            
						$tbl .='<tr nobr="true" class="text-bold">';
						$tbl .='<td colspan="7" class="text-right">';
						$tbl .='';
						 $tbl .='</td>';
						$tbl .='</tr>';   */
	   
					  
						$tbl .='<tr nobr="true">
						<td colspan="7" class="text-right" style="width:'.($sumOfWidth-$colWidthSize['amount']).'%">';
						$tbl .=$this->CI->lang->line("grand_total");
						$tbl .='</td>';
						$tbl .='<td colspan="1" class="text-right" style="width:'.($colWidthSize['amount']).'%">';
						$tbl .=store_number_format($sales->grand_total) ;
						$tbl .='</td>';
					    $tbl .='</tr>';	
		                  
		               



               
		                //Grand Total
		                $tbl .='<tr nobr="true">
		                	<td colspan="7" style="width:'.($colWidthSize['sl_no']+$colWidthSize['description']+$colWidthSize['qty']+$colWidthSize['unit_cost']+$colWidthSize['disc.']+$colWidthSize['vat']+$colWidthSize['unit_price']).'%">';
		                	$tbl .="<b>".$this->CI->lang->line("amount_in_words")."</b> : ".baht_text($sales->grand_total);
		                	$tbl .='</td>';
							
      
						$tbl .='</tr>';

		                //Note
		                $tbl .='<tr nobr="true">
		                	<td colspan="8" style="width:'.($sumOfWidth).'%; height:30px;">';
		                	$tbl .="<b>".$this->CI->lang->line("invoice_Terms")."</b> : ".nl2br($sales->sales_note);
		                	$tbl .='</td>';
		                $tbl .='</tr>';

		            $tbl .='</tbody>
		        </table>
		       
		        ';
	

		$tbl .='<table nobr="true">
		            <tbody>
		             <tr nobr="true">                      
		                   
							<td colspan="8">
							       <div style="font-size:18px;">
							         <span style="color:rgb(65, 59, 212); top-margin:8px;">'.$this->CI->lang->line("note").':</span><br>';
		                        	//$tbl .=nl2br(html_entity_decode($sales->invoice_terms));
					
		                    		$tbl .='
									</div>
                                  							
		                    </td> 
		                   
                           <td colspan="8">
							       <div style="font-size:18px;">
							         <span style="color:rgb(65, 59, 212); top-margin:8px;">'.$this->CI->lang->line("receiver_pay").':</span><br>';
		                        	//$tbl .=nl2br(html_entity_decode($sales->invoice_terms));
					
		                    		$tbl .='
									</div>
                                     <p style="text-align:center; font-size:18px; ">ชื่อ.......................................................</p>

                                    <p style="text-align:center; font-size:16px; "> วันที่ -------------/---------------------/------------</p>									
		                    </td>



							<td colspan="6" style="vertical-align:bottom; min-height:8px;height:40px;">
		                    	<div style="font-size:18px; color:rgb(65, 59, 212);"><span>           
			                    	'.$this->CI->lang->line("authorised_signature").'
			                    	:</span>
		                    	</div>';
								
		                    	if(!empty($this->get_signature_image_path())){
			                    	$tbl .='<div style="text-align:center;">
			                    		<img style="height:80px;" src="'.$this->get_signature_image_path().'"/>
			                    	</div>';
		                    	}

		                       $tbl .='
							 </td>
		                </tr>
		               
						<tr nobr="true">
		                     <td colspan="22" class="text-center">';
		                        //	$tbl .=nl2br($store->sales_invoice_footer_text);
								 	$tbl .= ขอขอบคุณที่อุดหนุน ;
		                    		$tbl .='
		                    </td> 
		                </tr>
		            </tbody>
		        </table>
		       
		        ';

		      //  echo $tbl;exit;
		$this->writeHTMLCell('', '', $x ='', $y='', $tbl, 0, 1, 1, true, 'J', true);

		//$this->Output('invoice_100.pdf', 'I');
		$this->Output("invoice_ ".$sales->sales_code. ".pdf", 'I');
	}

}