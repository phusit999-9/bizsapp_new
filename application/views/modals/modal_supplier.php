<div class="modal fade " id="supplier-modal" tabindex='-1'>
  <?= form_open('#', array('class' => '', 'id' => 'supplier-form')); ?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-custom">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <label aria-hidden="true">&times;</label></button>
        <h4 class="modal-title text-center"><?= $this->lang->line('new_supplier'); ?></h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="supplier_name"><?= $this->lang->line('supplier_name'); ?>*</label>
                  <label id="supplier_name_msg" class="text-danger text-right pull-right"></label>
                  <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="" >
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="mobile"><?= $this->lang->line('mobile'); ?></label>
                  <label id="mobile_msg" class="text-danger text-right pull-right"></label>
                  <input type="tel"  class="form-control no_special_char_no_space " id="mobile" name="mobile" placeholder="0651234567"  >
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="phone"><?= $this->lang->line('phone'); ?></label>
                  <label id="phone_msg" class="text-danger text-right pull-right"></label>
                  <input type="tel"  class="form-control maxlength no_special_char_no_space " id="phone" name="phone" placeholder=""  >
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="email"><?= $this->lang->line('email'); ?></label>
                  <label id="email_msg" class="text-danger text-right pull-right"></label>
                  <input type="email" class="form-control " id="email" name="email" placeholder=""  >
                </div>
              </div>
            </div>
            <?php if(gst_number()){ ?>
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="gstin_msg"><?= $this->lang->line('gst_number'); ?></label>
                  <label id="gstin_msg" class="text-danger text-right pull-right"></label>
             <!--     <span class="pull-right"><a class="pointer text-bold" target="_blank" href="https://services.gst.gov.in/services/searchtp">Verify</a></span>-->
                  <input type="text" class="form-control maxlength  " id="gstin" name="gstin" placeholder=""  >
                </div>
              </div>
            </div>
          <?php } ?>

            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="tax_number"><?= $this->lang->line('branch'); ?></label>
                  <label id="tax_number_msg" class="text-danger text-right pull-right"></label>
                  <input type="text"  class="form-control maxlength  " id="tax_number" name="tax_number" placeholder=""  >
                </div>
              </div>
            </div>
            <div class="col-md-4">
                <div class="box-body">
                  <div class="form-group">
                    <label for="opening_balance"><?= $this->lang->line('opening_balance'); ?></label>
                    <label id="opening_balance_msg" class="text-danger text-right pull-right"></label>
                    <input type="text"  class="form-control only_currency" id="opening_balance" name="opening_balance" placeholder=""  >
                  </div>
                </div>
              </div>
          <!--  <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="country"><?= $this->lang->line('country'); ?></label>
                  <label id="country_msg" class="text-danger text-right pull-right"></label>
                 <select class="form-control select2" id="country" name="country"  style="width: 100%;" onkeyup="shift_cursor(event,'state')" value="">
                    <?= get_country_select_list(null,true); ?>  
                  </select>
                </div>
              </div>
            </div>-->
        <!--  <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="state"><?= $this->lang->line('state'); ?></label>
                  <label id="state_msg" class="text-danger text-right pull-right"></label>
                 <select class="form-control select2" id="state" name="state"  style="width: 100%;" onkeyup="shift_cursor(event,'state_code')">
                    <?php
                    $query2="select * from db_states where status=1 ";
                    $q2=$this->db->query($query2);
                    if($q2->num_rows()>0)
                     {
                      echo '<option value="">-Select-</option>'; 
                      foreach($q2->result() as $res1)
                       {
                         echo "<option value='".$res1->id."'>".$res1->state."</option>";
                       }
                     }
                     else
                     {
                        ?>
                        <option value="">No Records Found</option>
                        <?php
                     }
                    ?>
                          </select>
                </div>
              </div>
            </div> -->
         <!--  <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="city"><?= $this->lang->line('city'); ?></label>
                  <label id="city_msg" class="text-danger text-right pull-right"></label>
                  <input type="text" class="form-control" id="city" name="city" placeholder="" >
                </div>
              </div>
            </div>-->
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="postcode"><?= $this->lang->line('postcode'); ?></label>
                  <label id="postcode_msg" class="text-danger text-right pull-right"></label>
                  <input type="text" class="form-control" id="postcode" name="postcode" placeholder="" >
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="address"><?= $this->lang->line('address'); ?></label>
                  <label id="address_msg" class="text-danger text-right pull-right"></label>
                  <textarea type="text" class="form-control" id="address" name="address" placeholder="" ></textarea>
                </div>
              </div>
            </div>

          </div>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_supplier">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
 <?= form_close();?>
</div>
<!-- /.modal -->