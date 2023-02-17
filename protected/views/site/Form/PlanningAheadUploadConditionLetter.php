<?php

    /* @var $this PlanningAheadController */

    $this->pageTitle = Yii::app()->name;
?>

<div id="conditionLetterUploadForm" class="pt-2">
    <div class="p-2" style="background-color: #2b669a; color: white"><b>Customer Condition Letter</b></div>

    <form action="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/PostUploadConditionLetter" method="post" enctype="multipart/form-data" >
        <div class="form-group row px-3 pt-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Customer Condition Letter: </span>
                </div>
                <input id="conditionLetter" name="file[]" type="file"
                       placeholder="Please upload the condition letter"
                       class="form-control"
                       oninvalid="this.setCustomValidity('Please select the condition letter!')"
                       oninput="this.setCustomValidity('')"
                       required multiple autocomplete="false">
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
