<?php
/* @var $this FirstFormController */
$this->pageTitle = Yii::app()->name;
?>

<style>
    body {
        overflow-x: hidden;
    }

    .invalid {
        background-color: #2774ad69;
    }
</style>

<div id="planningAheadDetailForm" class="pt-2">

    <div class="p-2" style="background-color: #2b669a; color: white; font-size: x-large"><b>Planning Ahead Error</b></div>

    <div class="py-2">Sorry, there is an error on processing planning ahead function.</div>

    <div class="text-danger font-weight-bold"><?php echo $this->viewbag['errorMsg']; ?></div>

</div>
