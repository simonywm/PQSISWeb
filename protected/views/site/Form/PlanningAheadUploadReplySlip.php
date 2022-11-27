<?php

/* @var $this FirstFormController */

$this->pageTitle = Yii::app()->name;
?>

<div id="consultantMeetingUploadForm" class="pt-2">
    <div class="p-2" style="background-color: #2b669a; color: white"><b>Reply Slip File</b></div>

    <form action="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/PostUploadReplySlip" method="post" enctype="multipart/form-data" >
        <div class="form-group row px-3 pt-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Reply Slip File: </span>
                </div>
                <input id="replySlip" name="file" type="file"
                       placeholder="Please upload the Reply Slip File"
                       class="form-control"
                       oninvalid="this.setCustomValidity('Please select the Reply Slip File!')"
                       oninput="this.setCustomValidity('')"
                       required autocomplete="false">
            </div>
        </div>

        <div class="form-group row px-3">
            <div>
                <input class="btn btn-primary" type="submit" name="submit" id="addBtn" value="Upload">
            </div>
        </div>

    </form>
</div>

<script>
    $(document).ready(function(){
        <?php
        if (isset($this->viewbag['IsUploadSuccess']) && $this->viewbag['IsUploadSuccess']) {
        ?>
        showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info", "<?php echo $this->viewbag['resultMsg']; ?>");
        <?php
        } else if (isset($this->viewbag['IsUploadSuccess']) && !$this->viewbag['IsUploadSuccess']) {
        ?>
        showError("<i class=\"fas fa-times-circle\"></i> ", "Error", "<?php echo $this->viewbag['resultMsg']; ?>");
        <?php } ?>
    });
</script>