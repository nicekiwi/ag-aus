
<div class="modal fade" id="report-broken-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Report Broken Map</h4>
            </div>
            <div class="modal-body">
                <p><b>Map:</b> <span class="broken-map-name"></span></p>

                <!-- The async form to send and replace the modals content with its response -->
                <form id="report-broken-form">
                    <fieldset>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Where/How is this map broken?</label>
                            <textarea class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="image">Screenshot <small>(Optional)</small></label>
                            <div class="">
                                <div class="input-group">
                                    <input name="image" type="text" class="form-control">
									<span class="input-group-btn">
										<span class="btn btn-primary btn-file">
											<i class="fa fa-plus"></i><input id="imageupload" type="file" name="file" accept="image/jpg, image/jpeg, image/png, image/gif">
										</span>
									</span>
                                </div><!-- /input-group -->
                            </div>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input checked type="checkbox"> Contact me via Steam about this report.
                            </label>
                            <p class="help-block">(We can't follow up every report personally, but we will still review them.)</p>
                        </div>

                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button style="float:left;" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->