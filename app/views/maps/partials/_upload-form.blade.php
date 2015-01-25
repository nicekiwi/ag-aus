<div class="modal fade" id="map-upload-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-cloud-upload"></i> Upload Maps to Amazon S3</h4>
            </div>
            <div class="modal-body">

                <div class="map-upload-container">
                    <div class="form-group">
                        <div class="jumbotron fileinput-button">
                            <i class="fa fa-plus"></i>
                            <span>Click or Drag 'n Drop files here..<br><small>Only .bz2 and .nav files are accepted. No max
                                    filesize.
                                </small></span>
                            <input type="file" class="map-upload-input" name="file"
                                   accept="application/x-bzip2, application/nav, text/nav, image/jpg, image/jpeg" multiple>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Upload Progress</label>
                        <div class="progress progress-striped map-progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Results</label>
                        <div class="map-upload-results"></div>
                    </div>

                    <div class="map-syncing-info hide">
                        <i class="fa fa-refresh fa-spin"></i>
                        <span>Syncing with Amazon</span>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->