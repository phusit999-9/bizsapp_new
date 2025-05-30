<!DOCTYPE html>
<html>
   <head>
  <!-- TABLES CSS CODE -->
  <?php include"comman/code_css.php"; ?>
  
  <!-- </copy> -->  
  </head>
   <body class="hold-transition skin-blue  sidebar-mini">
      <!-- **********************MODALS***************** -->
       <?php include"modals/modal_brand.php"; ?>
       <?php include"modals/modal_category.php"; ?>
       <?php include"modals/modal_unit.php"; ?>
       <?php include"modals/modal_tax.php"; ?>
       <!-- **********************MODALS END***************** -->
       
      <div class="wrapper">
      <?php include"sidebar.php"; ?>
      <?php
         if(!isset($item_name)){
         $item_name=$sku=$hsn=$opening_stock=$brand_id=$category_id=$gst_percentage=$tax_type=
         $sales_price=$purchase_price=$profit_margin=$unit_id=$price=$alert_qty=$store_id="";
         $stock = 0;
         $seller_points =0;
         $custom_barcode ='';
         $description ='';
         $mrp ='';
         $child_bit ='';
         $tax_id ='';
         
         //$variants_selected='';
         $item_group='Single';

         $discount='';
          $discount_type='Percentage';

          
          $opening_stock_readonly='';


         $item_code = get_init_code('item');

         }
         else{
            $opening_stock_readonly = 'readonly';
         }
         //For new or update
         $opening_stock ='0';

         
         
         
         ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- **********************MODALS***************** -->
      <?php include"modals/modal_variant.php"; ?>
      <!-- **********************MODALS END***************** -->

         <!-- Content Header (Page header) -->
         <section class="content-header">
            <h1>
               <?= $page_title;?>
               <small>Add/Update Items</small>
            </h1>
            <ol class="breadcrumb">
               <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
               <li><a href="<?php echo $base_url; ?>items"><?= $this->lang->line('items_list'); ?></a></li>
               <li class="active"><?= $page_title;?></li>
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
                  <div class="box box-primary ">
                     
                      <?= form_open('#', array('class' => 'form', 'id' => 'items-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
                        <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                        <div class="box-body">

                          <div class="row">
                             <!-- Store Code -->
                              <?php /*if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box_1'=>true,'store_id'=>$store_id)); }else{*/
                                echo "<input type='hidden' name='store_id' id='store_id' value='".get_current_store_id()."'>";
                              /*}*/ ?>
                              <!-- Store Code end -->
                          </div>

                           <div class="row">
                              <div class="form-group col-md-4">
                                 <label for="item_code"><?= $this->lang->line('item_code'); ?><span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" id="item_code" name="item_code" placeholder="" value="<?php print $item_code; ?>" >
                                 <span id="item_code_msg" style="display:none" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-md-4">
                                 <label for="item_name"><?= $this->lang->line('item_name'); ?><span class="text-danger">*</span></label>
                                 <input type="text" autofocus="" class="form-control" id="item_name" name="item_name" placeholder="" value="<?php print $item_name; ?>" >
                                 <span id="item_name_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="brand_id"><?= $this->lang->line('brand'); ?></label>
                                 <div class="input-group">
                                 <select class="form-control select2" id="brand_id" name="brand_id"  style="width: 100%;"  >
                                    <option value="">-Select-</option>
                                    <?= get_brands_select_list($brand_id);  ?>
                                 </select>
                                 <span class="input-group-addon pointer" data-toggle="modal" data-target="#brand_modal" title="Add Customer"><i class="fa fa-plus-square-o text-primary fa-lg"></i></span>
                                    </div>
                                 <span id="brand_id_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="category_id"><?= $this->lang->line('category'); ?><span class="text-danger">*</span></label>
                                 <div class="input-group">
                                 <select class="form-control select2" id="category_id" name="category_id"  style="width: 100%;"  >
                                    <option value="">-Select-</option>
                                    <?= get_categories_select_list($category_id);  ?>
                                 </select>
                                 <span class="input-group-addon pointer" data-toggle="modal" data-target="#category_modal" title="Add Customer"><i class="fa fa-plus-square-o text-primary fa-lg"></i></span>
                                    </div>
                                 <span id="category_id_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="item_group"><?= $this->lang->line('item_group'); ?><span class="text-danger">*</span></label>
                                 <select class="form-control select2" id="item_group" name="item_group"  style="width: 100%;" >
                                  
                                    <option  value="Single">สินค้ามาตรฐาน</option>
                                    <option  value="Variants">หลายตัวเลือก</option>
                                 </select>
                                 <span id="item_group_msg" style="display:none" class="text-danger"></span>
                                 
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="unit_id"><?= $this->lang->line('unit'); ?><span class="text-danger">*</span></label>
                                 <div class="input-group">
                                 <select class="form-control select2" id="unit_id" name="unit_id"  style="width: 100%;"  >
                                    <?= get_units_select_list($unit_id);  ?>
                                 </select>
                                 <span class="input-group-addon pointer" data-toggle="modal" data-target="#unit_modal" title="Add Customer"><i class="fa fa-plus-square-o text-primary fa-lg"></i></span>
                                    </div>
                                 <span id="unit_id_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="sku"><?= $this->lang->line('sku'); ?></label>
                                 <input type="text" class="form-control" id="sku" name="sku" placeholder="" value="<?php print $sku; ?>" >
                                 <span id="sku_msg" style="display:none" class="text-danger"></span>
                              </div>
                           <!--   <div class="form-group col-md-4">
                                 <label for="hsn"><?= $this->lang->line('hsn'); ?></label>
                                 <input type="text" class="form-control" id="hsn" name="hsn" placeholder="" value="<?php print $hsn; ?>" >
                                 <span id="hsn_msg" style="display:none" class="text-danger"></span>
                              </div>-->
                              <div class="form-group col-md-4">
                                 <label for="alert_qty" ><?= $this->lang->line('alert_qty'); ?></label>
                                 <input type="number" class="form-control no_special_char" id="alert_qty" name="alert_qty" placeholder="" min="0"  value="<?php print $alert_qty; ?>" >
                                 <span id="alert_qty_msg" style="display:none" class="text-danger"></span>
                              </div>
                              
                              <div class="form-group col-md-4">
                                 <label for="seller_points" ><?= $this->lang->line('seller_points'); ?></label>
                                 <input type="text" class="form-control only_currency" id="seller_points" name="seller_points" placeholder=""  value="<?php print $seller_points; ?>" >
                                 <span id="seller_points_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="custom_barcode" ><?= $this->lang->line('barcode'); ?></label>
                                 <input type="text" class="form-control " id="custom_barcode" name="custom_barcode" placeholder=""  value="<?php print $custom_barcode; ?>" >
                                 <span id="custom_barcode_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="custom_barcode" ><?= $this->lang->line('description'); ?></label>
                                 <textarea type="text" class="form-control" id="description" name="description" placeholder=""><?php print $description; ?></textarea>
                                 <span id="description_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="item_image"><?= $this->lang->line('select_image'); ?></label>
                                 <input type="file" name="item_image" id="item_image">
                                 <span id="item_image_msg" style="display:block;" class="text-danger">Max Width/Height: 1000px * 1000px & Size: 1MB </span>
                              </div>
                              
                              
                           </div>
                           <hr>
                           <div class="row">
                              <div class="form-group col-md-4">
                                 <label for="discount_type"><?= $this->lang->line('discount_type'); ?></label>
                                 <select class="form-control" id="discount_type" name="discount_type"  style="width: 100%;" >
                                 <option value='Percentage'>เปอร์เซ็นต์(%)</option>
                                 <option value='Fixed'>จำนวนเงิน(<?= $CI->currency() ?>)</option>
                                 </select>
                                 <span id="discount_type_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="discount"><?= $this->lang->line('discount'); ?></label>
                                 <input type="text" class="form-control only_currency" id="discount" name="discount" value="<?php print $discount; ?>" >
                                 <span id="discount_msg" style="display:none" class="text-danger"></span>
                              </div>
                              
                           </div>
                           <hr>
                           <div class="row">
                              <div class="form-group col-md-4 ">
                                 <label for="price"><?= $this->lang->line('item_price'); ?><span class="text-danger">*</span></label>
                                 <input type="text" class="form-control only_currency" id="price" name="price" placeholder="ราคาสินค้าไม่รวมภาษี"  value="<?php print $price; ?>" >
                                 <span id="price_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="tax_id"><?= $this->lang->line('tax'); ?><span class="text-danger">*</span></label>
                                 <div class="input-group">
                                 <select class="form-control select2" id="tax_id" name="tax_id"  style="width: 100%;"  >
                                    <?= get_tax_select_list($tax_id);  ?>
                                 </select>
                                 <span class="input-group-addon pointer" data-toggle="modal" data-target="#tax_modal" title="Add Customer"><i class="fa fa-plus-square-o text-primary fa-lg"></i></span>
                                    </div>
                                 <span id="tax_id_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="purchase_price"><?= $this->lang->line('purchase_price'); ?><span class="text-danger">*</span></label>
                                 <input type="text" class="form-control only_currency" id="purchase_price" name="purchase_price" placeholder="ราคาสินค้า+ภาษีซื้อ"  value="<?php print $purchase_price; ?>" readonly='' >
                                 <span id="purchase_price_msg" style="display:none" class="text-danger"></span>
                              </div>
                           
                              <div class="form-group col-md-4">
                                 <label for="tax_type"><?= $this->lang->line('tax_type'); ?><span class="text-danger">*</span></label>
                                 <select class="form-control select2" id="tax_type" name="tax_type"  style="width: 100%;" >
                                  <?php 
                                    $inclusive_selected=$exclusive_selected='';
                                    if($tax_type =='Inclusive') { $inclusive_selected='selected'; }
                                    if($tax_type =='Exclusive') { $exclusive_selected='selected'; }

                                  ?>
                                    <option <?= $inclusive_selected ?> value="Inclusive">ราคารวมภาษี</option>
                                    <option <?= $exclusive_selected ?> value="Exclusive">ราคาไม่รวมภาษี</option>
                                 </select>
                                 <span id="tax_type_msg" style="display:none" class="text-danger"></span>
                                 
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="profit_margin"><?= $this->lang->line('profit_margin'); ?>(%) <i class="hover-q " data-container="body" data-toggle="popover" data-placement="top" data-content="<?= $this->lang->line('based_on_purchase_price'); ?>" data-html="true" data-trigger="hover" data-original-title="">
                                  <i class="fa fa-info-circle text-maroon text-black hover-q"></i>
                                </i></label>
                                 <input type="text" class="form-control only_currency" id="profit_margin" name="profit_margin" placeholder="กำไร %"  value="<?php print $profit_margin; ?>" >
                                 <span id="profit_margin_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="sales_price" class="control-label"><?= $this->lang->line('sales_price'); ?><span class="text-danger">*</span></label>
                                 <input type="text" class="form-control only_currency " id="sales_price" name="sales_price" placeholder="ราคาขาย"  value="<?php print $sales_price; ?>" >
                                 <span id="sales_price_msg" style="display:none" class="text-danger"></span>
                              </div>
                           <!--   <div class="form-group col-md-4">
                                 <label for="mrp"><?= $this->lang->line('mrp'); ?><i class="hover-q " data-container="body" data-toggle="popover" data-placement="top" data-content="<?= $this->lang->line('mrp_definition'); ?>" data-html="true" data-trigger="hover" data-original-title="">
                                  <i class="fa fa-info-circle text-maroon text-black hover-q"></i>
                                </i></label>
                                 <input type="text" class="form-control only_currency" id="mrp" name="mrp" placeholder="ราคาขายสินค้า+ภาษีขาย(Exc)"  value="<?php print $mrp; ?>" >
                                 <span id="mrp_msg" style="display:none" class="text-danger"></span>
                              </div>-->
                           </div>
                           <hr>
                           <div class="row">
                              <div class="form-group col-md-4">
                                 <label for="warehouse_id"><?= $this->lang->line('warehouse'); ?></label>
                                 <select class="form-control" id="warehouse_id" name="warehouse_id"  style="width: 100%;" >
                                 <?= get_warehouse_select_list();?>
                                 </select>
                                 <span id="warehouse_id_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="adjustment_qty"><?= $this->lang->line('opening_stock'); ?></label>
                                 <input type="text" class="form-control only_currency" id="adjustment_qty" name="adjustment_qty" value="<?php print $opening_stock; ?>" >
                                 <span id="adjustment_qty_msg" style="display:none" class="text-danger"></span>
                              </div>
                              
                           </div>

                           <div class="row variant_div">
                             <div class="col-md-12">
                                  <div class="box box-info ">
                                    <div class="">
                                      <div class="box-header">
                                        <div class="col-md-6 col-md-offset-3 d-flex justify-content" >
                                          <div class="input-group">
                                                <span class="input-group-addon" title="Select Items"><i class="fa fa-search"></i></span>
                                                 <input type="text" class="form-control " placeholder="Search Variant" id="variant_search">
                                                 <span class="input-group-addon pointer text-green" data-toggle="modal" data-target="#variant-modal" title="Click to Add New Variant"><i class="fa fa-plus"></i></span>
                                              </div>
                                        </div>
                                      </div>
                                      <div class="box-body">
                                        <div class="table-responsive" style="width: 100%">
                                        <input type="hidden" value='1' id="hidden_rowcount" name="hidden_rowcount">
                                        <table class="table table-hover table-bordered" style="width:100%" id="variant_table">
                                             <thead class="custom_thead">
                                                <tr class="bg-success" >
                                                   <th rowspan='3' style="width:15%"><?= $this->lang->line('variant_name'); ?></th>
                                                   <th rowspan='2' style="width:10%"><?= $this->lang->line('sku'); ?></th> 
                                             <!--      <th rowspan='2' style="width:10%"><?= $this->lang->line(''); ?></th> -->
                                                   <th rowspan='2' style="width:10%"><?= $this->lang->line('barcode'); ?></th> 
                                                   <th rowspan='2' style="width:10%"><?= $this->lang->line('price'); ?>(<?= $CI->currency() ?>)</th>
                                                   <th rowspan='2' style="width:10%"><?= $this->lang->line('purchase_price'); ?>(<?= $CI->currency() ?>)</th>
                                                   <th rowspan='2' style="width:10%"><?= $this->lang->line('profit_margin'); ?></th>
                                                   <th rowspan='3' style="width:10%"><?= $this->lang->line('sales_price'); ?>(<?= $CI->currency() ?>)</th>
                                         <!--     <th rowspan='2' style="width:10%"><?= $this->lang->line('mrp'); ?>(<?= $CI->currency() ?>)</th> -->
                                                   <th rowspan='2' style="width:10%"><?= $this->lang->line('opening_stock'); ?></th>
                                                   <th rowspan='2' style="width:5%"><?= $this->lang->line('action'); ?></th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                               <?php if($item_group!='Single'){ 
                                                  echo $this->items_model->get_variants_list_in_row($q_id);
                                                } ?>
                                             </tbody>
                                          </table>
                                      </div>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              
                           </div>
                           <!-- /row -->
                           <!-- /.box-body -->
                           <div class="box-footer">
                              <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <!-- <div class="col-sm-4"></div> -->
                                 <?php
                                    if($item_name!=""){
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
      <script src="<?php echo $theme_link; ?>js/items.js"></script>
      <script src="<?php echo $theme_link; ?>js/modals.js"></script>
      <script type="text/javascript">
         $("#discount_type").val('<?=$discount_type; ?>');
        <?php if(isset($q_id)){ ?>
          $("#store_id").attr('readonly',true);
        <?php }?>
        $("#item_group").val("<?=$item_group;?>").select2().trigger("change");

        <?php if(!empty($item_name)){ ?>
          $("#hidden_rowcount").val($("#variant_table  tr").length)+1;
            calculate_purchase_price_of_all_row();
            calculate_sales_price_of_all_row();
        <?php } ?>

        <?php if($child_bit==1 || !empty($item_name)){ ?>
          $("#item_group").parent().addClass('hide');
        <?php } ?>

      </script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
     
   </body>
</html>
