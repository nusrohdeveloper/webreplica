<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manual Payment</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img src="images/instruction.png" class="img-responsive">
                </div>
            </div>
          <div class="row margin-top-20">
              <div class="col-md-12">
                   <form id="admin_pengguna_form" name="admin_pengguna_form" role="form" method="post" onsubmit=""  enctype="multipart/form-data" >
                        <div class="form-group">
                             <div class="row text-center">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-8 offset-sm-2" id="demo"></div>
                             </div>
                        </div>
                        <div class="form-group">
                            <label for="dtp_input1" class="control-label">Date and Time Payment<span class="text-red">*</span></label>
                            <div class="input-group date form_datetime" data-date="" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                                <input class="form-control readonly" size="16" type="text" name="asd" value="" required="">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            					<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
            				<input type="hidden" name="dtp_input1" id="dtp_input1" value="" required="" /><br/>
                        </div>
                        <div class="form-group">
                           <label class="control-label">Receipt Payment<span class="text-red">*</span></label>
                           <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="row row-eq-height in-form-row">
                                <br>
                              <div class="col-sm-1 ">

                              </div>
                              <div class="col-sm-5 ">
                                  <div class="fileinput-new thumbnail" style="width: 200px; height: 280px;"><img src="images/resit_contoh.png" alt="" class="img-responsive"/> </div>
                                  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 280px;"> </div>
                              </div>
                              <div class="col-sm-6">
                                <div>
                                  <span id='upload_span'>Upload Receipt Payment</span>
                                  <p><small>Best Dimension: <br>200px X 280px</small></p>
                                  <p><small>Size:Not Exceed 500kb</small></p>
                                  <span class="btn default btn-file span6">
                                  <span class="fileinput-new"> Select image </span>
                                  <span class="fileinput-exists"> Change </span>
                                  <input type="file" name="avatar" id="avatar" required=""> </span>
                                  <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--<hr>-->
                        <!--<div class="margin-top-10">-->
                        <!--    <input class="btn green" type="submit" name="simpan_pengguna" value="Simpan">-->
                            <!-- <input class="btn btn-warning" data-dismiss="modal" name="" value="Batal"> -->
                        <!--    <input class="pull-right btn btn-outline dark" type="Reset" name="" value="Kosongkan">-->
                            <!-- <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button> -->
                        <!--</div>-->

              </div>

          </div>
          <div><span class="text-red">*Required Fill.</span></div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="username" value="<?php echo $username_prospek; ?>">
            <input class="btn green" type="submit" name="simpan_pengguna" value="Upload">
            <input class="btn btn-outline dark" type="Reset" name="" value="Reset">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </form>
    </div>
</div>
