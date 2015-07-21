<div id="{id}" class="preview-container">
    <img src="{src}" class="img-preview img-responsive center-block">

    <div class="progress center-block preview-progress">
        <div class="progress-bar" id="{id}_progress"></div>
    </div>

    <div class="btn-container btn-group center-block">
        <button id="{id}_edit" class="btn btn-primary" data-target="#{id}_modal" data-toggle="modal">Edit</button>
        <button id="{id}_remove" class="btn btn-danger">Remove</button>
    </div>

    <div id="{id}_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><span>×</span></button>
                    <h4>Image Editor</h4>
                    <p>{explanation}</p>
                </div>

                <div class="modal-body">
                    <div class="img-container">
                        <img id="{id}_cropper" class="img-responsive" src="{src}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" data-dismiss="modal">Okay</button>
                    <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>