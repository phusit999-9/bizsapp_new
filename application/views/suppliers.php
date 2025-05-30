<!DOCTYPE html>
<html>
   <head>
      <!-- TABLES CSS CODE -->
      <?php include"comman/code_css.php"; ?>
      <!-- </copy> -->  
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <?php
            if(!isset($supplier_name)){
               $supplier_name=$mobile=$phone=$email=$country_id=$state_id=$city=
               $postcode=$address=$supplier_code=$gstin=$pan=$state_code=
               $store_name=$company_mobile=$tax_number=$country_id=$state_id=$store_id='';
               $opening_balance=0;
            }
            ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?=$page_title;?>
                  <small>Add/Update Suppliers</small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a data-toggle='tooltip' title='Do you want Import Suppliers ?' href="<?php echo $base_url; ?>import/suppliers"><i class="fa fa-arrow-circle-o-down "></i> <?= $this->lang->line('import_suppliers'); ?></a></li>
                  <li><a href="<?php echo $base_url; ?>suppliers"><?= $this->lang->line('suppliers_list'); ?></a></li>
                  <li class="active"><?=$page_title;?></li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- ********** ALERT MESSAGE START******* -->
                  <?php include"comman/code_flashdata.php"; ?>
                  <!-- ********** ALERT MESSAGE END******* -->
                  <!-- right column -->
                  <div class="col-md-12">
                     <!-- Horizontal Form -->
                     <div class="box box-info ">
                        <!-- form start -->
                        <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'suppliers-form', 'enctype'=>'multipart/form-data', 'method'=>'POST', 'accept-charset'=>'UTF-8', 'novalidate'=>'novalidate' ));?>
                        <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                        <div class="box-body">
                            <div class="row">
                              <div class="col-md-5">
                                <!-- Store Code -->
                                <?php /*if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box'=>true,'store_id'=>$store_id,'label_length'=>'col-sm-4','div_length'=>'col-sm-8')); }else{*/
                                echo "<input type='hidden' name='store_id' id='store_id' value='".get_current_store_id()."'>";
                              /*}*/ ?>
                                <!-- Store Code end -->
                              </div>
                            </div>
                           <div class="row">
                              <div class="col-md-5">
                                 <div class="form-group">
                                    <label for="supplier_name" class="col-sm-4 control-label"><?= $this->lang->line('supplier_name'); ?><label class="text-danger">*</label></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder=""  value="<?php print $supplier_name; ?>" autofocus>
                                       <span id="supplier_name_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                              
                                 <?php if(gst_number()) {?>
                                 <div class="form-group">
                                    <label for="gstin" class="col-sm-4 control-label"><?= $this->lang->line('gst_number'); ?></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="gstin" name="gstin" placeholder="" value="<?php print $gstin; ?>" >
                                     
                                       <span id="gstin_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                               <?php } ?>

                                 <div class="form-group">
                                    <label for="email" class="col-sm-4 control-label"><?= $this->lang->line('email'); ?></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?php print $email; ?>" >
                                       <span id="email_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="phone" class="col-sm-4 control-label"><?= $this->lang->line('phone'); ?></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control no_special_char_no_space" id="phone" name="phone" placeholder="" value="<?php print $phone; ?>" >
                                       <span id="phone_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                                               
                                 <div class="form-group">
                                    <label for="mobile" class="col-sm-4 control-label"><?= $this->lang->line('mobile'); ?></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control no_special_char_no_space" id="mobile" name="mobile" placeholder="0991234567" value="<?php print $mobile; ?>" >
                                       <span id="mobile_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                
                                
                                
                                 <!-- ########### -->
                              </div>
                              <div class="col-md-5">                                
                              <div class="form-group hide">
                                    <label for="opening_balance" class="col-sm-4 control-label"><?= $this->lang->line('opening_balance'); ?></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="opening_balance" name="opening_balance" placeholder="" value="<?php print store_number_format($opening_balance,0); ?>" >
                                       <span id="opening_balance_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group ">
                                    <label for="tax_number" class="col-sm-4 control-label"><?= $this->lang->line('branch'); ?></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="tax_number" name="tax_number" placeholder="เลขสาขา 5 หลัก ( 00000 )" value="<?php print $tax_number; ?>" >
                                       <span id="tax_number_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                               
                                 <div class="form-group">
                                    <label for="address" class="col-sm-4 control-label"><?= $this->lang->line('address'); ?></label>
                                    <div class="col-sm-8">
                                       <textarea type="text" class="form-control" id="address" name="address" placeholder="" ><?php print $address; ?></textarea>
                                       <span id="address_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                               
                                 <div class="form-group hide">
                                    <label for="country" class="col-sm-4 control-label"><?= $this->lang->line('country'); ?></label>
                                    <div class="col-sm-8">
                                       <select class="form-control select2" id="country" name="country"  style="width: 100%;" >
                                        <?= get_country_select_list($country_id,true); ?>
                                       </select>
                                       <span id="country_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group hide">
                                 <label for="state" class="col-sm-4 control-label"><?= $this->lang->line('state'); ?> </label>
                                    <div class="col-sm-8">
                                       <select class="form-control select2" id="state" name="state"  style="width: 100%;" >
                                        <?= get_state_select_list($state_id); ?>
                                       </select>
                                       <span id="state_msg" style="display:none" class="text-danger"></span>
                                    </div> 
                                 </div>
                               <div class="form-group">
                                    <label for="city" class="col-sm-4 control-label"><?= $this->lang->line('city'); ?></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control " id="city" name="city" placeholder="" value="<?php print $city; ?>" >
                                       <span id="city_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="postcode" class="col-sm-4 control-label"><?= $this->lang->line('postcode'); ?></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control no_special_char_no_space" id="postcode" name="postcode" placeholder="" value="<?php print $postcode; ?>" >
                                       <span id="postcode_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div> 
                                
                              </div>
                              <!-- ########### -->
                           </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                           <div class="col-sm-8 col-sm-offset-2 text-center">
                              <!-- <div class="col-sm-4"></div> -->
                              <?php
                                 if($supplier_name!=""){
                                      $btn_name="อัพเดท";
                                      $btn_id="update";
                                      ?>
                              <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>
                              <?php
                                 }
                                           else{
                                               $btn_name="บันทึก";
                                               $btn_id="save";
                                           }
                                 
                                           ?>
                              <div class="col-md-3 col-md-offset-3">
                                 <button type="button" id="<?php echo $btn_id;?>" class=" btn btn-block btn-primary" title="Save Data"><?php echo $btn_name;?></button>
                              </div>
                              <div class="col-sm-3">
                                    <a href="<?=base_url('dashboard');?>">
                                    <button type="button" class="col-sm-3 btn btn-block btn-info close_btn" title="Go Dashboard">ปิด</button>
                                    </a>
                                 </div>
                           </div>
                        </div>
                        <!-- /.box-footer -->
                        <?= form_close(); ?>
                     </div>
                     <!-- /.box -->
                  </div>
                  <!--/.col (right) -->
                  <div class="col-md-12">
                     <div class="box">
                        <div class="box-header">
                           <h3 class="box-title text-blue"><?= $this->lang->line('opening_balance_payments'); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                           <table class="table table-bordered table-hover " id="report-data" >
                              <thead>
                                 <tr class="bg-gray">
                                    <th style="">#</th>
                                    <th style=""><?= $this->lang->line('payment_date'); ?></th>
                                    <th style=""><?= $this->lang->line('payment'); ?></th>
                                    <th style=""><?= $this->lang->line('payment_type'); ?></th>
                                    <th style=""><?= $this->lang->line('payment_note'); ?></th>
                                    <th style=""><?= $this->lang->line('action'); ?></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php 
                                    if(isset($q_id)){
                                      //sop - Supplier Opening Balance
                                      $q3 = $this->db->query("select * from db_purchasepayments where supplier_id=$q_id and short_code='OPENING BALANCE PAID'");
                                      if($q3->num_rows()>0){
                                        $i=1;
                                        $total_paid = 0;
                                        foreach ($q3->result() as $res3) {
                                          $total_paid +=$res3->payment;
                                          echo "<td>".$i."</td>";
                                          echo "<td>".show_date($res3->payment_date)."</td>";
                                          echo "<td class='text-right'>".$CI->currency($res3->payment)."</td>";
                                          echo "<td>".$res3->payment_type."</td>";
                                          echo "<td>".$res3->payment_note."</td>";
                                          echo '<td><i class="fa fa-trash text-red pointer" onclick="delete_opening_balance_entry('.$res3->id.')"> Delete</i></td>';
                                          echo "</tr>";
                                          $i++;
                                        }
                                        echo "<tr class='text-bold'>
                                                <td colspan=2 class='text-right '>Total</td>
                                                <td class='text-right'>".$CI->currency($total_paid)."</td>
                                                <td colspan=3></td>
                                              </tr>";
                                      }
                                      else{
                                        echo "<tr><td colspan='6' class='text-center text-bold'>No Previous Stock Entry Found!!</td></tr>";
                                      }
                                    }
                                    else{
                                      echo "<tr><td colspan='6' class='text-center text-bold'>No Previous Stock Entry Found!!</td></tr>";
                                    }
                                    ?>
                              </tbody>
                           </table>
                        </div>
                        <!-- /.box-body -->
                     </div>
                     <!-- /.box -->
                  </div>
               </div>
               <!-- /.row -->
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js.php"; ?>
      <script src="<?php echo $theme_link; ?>js/suppliers.js"></script>
      <script type="text/javascript">
        <?php if(isset($q_id)){ ?>
          $("#store_id").attr('readonly',true);
        <?php }?>
      </script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
 </body>
</html>
