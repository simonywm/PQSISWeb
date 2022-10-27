<?php

/* @var $this FirstFormController */

$this->pageTitle = Yii::app()->name;
?>

<div id="consultantMeetingUploadForm" class="pt-2">
    <div class="p-2" style="background-color: #2b669a; color: white"><b>Consultant Meeting Informtion File</b></div>

    <form action="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/PostUploadConsultantMeetingInfo" method="post" enctype="multipart/form-data" >
        <div class="form-group row px-3 pt-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Consultant Meeting Information File: </span>
                </div>
                <input id="consultantMeetingInfo" name="file" type="file"
                       placeholder="Please upload the Consultant Meeting Information File"
                       class="form-control"
                       oninvalid="this.setCustomValidity('Please select the Consultant Meeting Informtion File!')"
                       oninput="this.setCustomValidity('')"
                       required autocomplete="false">
            </div>
        </div>

        <div class="form-group row px-3">
            <div>
                <input class="btn btn-primary" type="submit" name="submit" id="addBtn" value="Upload">
            </div>
        </div>

        <?php
        if (isset($this->viewbag['IsUploadSuccess']) && $this->viewbag['IsUploadSuccess']) {
            ?>
            <div class="pl-3 bg-success"><?php echo $this->viewbag['resultMsg']; ?></div>
            <?php
        } else if (isset($this->viewbag['IsUploadSuccess']) && !$this->viewbag['IsUploadSuccess']) {
            ?>
            <div class="pl-3 bg-warning"><?php echo $this->viewbag['resultMsg']; ?></div>
        <?php } ?>

    </form>
</div>