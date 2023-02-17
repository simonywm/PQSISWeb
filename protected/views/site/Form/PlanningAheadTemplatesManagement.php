<?php

/* @var $this PlanningAheadController */

$this->pageTitle = Yii::app()->name;
?>

<style>
    ul li .templateSelect{
        border: 3px solid #bdbdbe;
        background-color: #fffefe;
        padding: 8px 20px;
        border-radius: 10px;
    }
</style>

<div id="templatesManagement" class="pt-2">
    <div class="p-2" style="background-color: #2b669a; color: white"><b>Templates Management</b></div>

    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs pt-2">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#email">List of Email Templates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#word">List of Word Document Templates</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div id="email" class="tab-pane active"><br>
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th colspan="2">Last Modified Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($this->viewbag['emailTemplateFiles'] as $emailTemplateFileName) {
                    ?>
                            <tr>
                                <td><?php echo $emailTemplateFileName['fileName'] ?></td>
                                <td><?php echo $emailTemplateFileName['lastModifiedTime'] ?></td>
                                <td>
                                    <a type="button" class="btn btn-primary"
                                       href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetEmailTemplate&FileName=<?php echo $emailTemplateFileName['fileName'] ?>">
                                        download
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
                <form action="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/PostEmailTemplates" method="post" enctype="multipart/form-data" >
                    <div class="form-group row px-3 pt-2">
                        You can choose new email notification files to replace to the server:
                    </div>
                    <div class="form-group row px-3 pt-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Email Template Files: </span>
                            </div>
                            <input id="emailTemplateFiles" name="file[]" type="file"
                                   placeholder="Email notification template files"
                                   class="form-control"
                                   oninvalid="this.setCustomValidity('Please select the email template file(s)!')"
                                   oninput="this.setCustomValidity('')"
                                   required multiple autocomplete="false">
                            <input class="btn btn-primary" type="submit" name="postEmailTemplates" id="postEmailTemplates" value="Upload Email Template File(s)">
                        </div>
                    </div>
                </form>
            </div>
            <div id="word" class="tab-pane fade"><br>
                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th>File Name</th>
                        <th colspan="2">Last Modified Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($this->viewbag['standardLetterTemplateFiles'] as $standardLetterTemplateFileName) {
                        ?>
                        <tr>
                            <td><?php echo $standardLetterTemplateFileName['fileName'] ?></td>
                            <td><?php echo $standardLetterTemplateFileName['lastModifiedTime'] ?></td>
                            <td>
                                <a type="button" class="btn btn-primary"
                                   href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetStandardLetterTemplate&FileName=<?php echo $standardLetterTemplateFileName['fileName'] ?>">
                                    download
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <?php
                    foreach ($this->viewbag['invitationLetterTemplateFiles'] as $invitationLetterTemplateFileName) {
                        ?>
                        <tr>
                            <td><?php echo $invitationLetterTemplateFileName['fileName'] ?></td>
                            <td><?php echo $invitationLetterTemplateFileName['lastModifiedTime'] ?></td>
                            <td>
                                <a type="button" class="btn btn-primary"
                                   href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetInvitationLetterTemplate&FileName=<?php echo $invitationLetterTemplateFileName['fileName'] ?>">
                                    download
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <?php
                    foreach ($this->viewbag['replySlipTemplateFiles'] as $replySlipTemplateFileName) {
                        ?>
                        <tr>
                            <td><?php echo $replySlipTemplateFileName['fileName'] ?></td>
                            <td><?php echo $replySlipTemplateFileName['lastModifiedTime'] ?></td>
                            <td>
                                <a type="button" class="btn btn-primary"
                                   href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetReplySlipTemplate&FileName=<?php echo $replySlipTemplateFileName['fileName'] ?>">
                                    download
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <?php
                    foreach ($this->viewbag['evaReportTemplateFiles'] as $evaReportTemplateFileName) {
                        ?>
                        <tr>
                            <td><?php echo $evaReportTemplateFileName['fileName'] ?></td>
                            <td><?php echo $evaReportTemplateFileName['lastModifiedTime'] ?></td>
                            <td>
                                <a type="button" class="btn btn-primary"
                                   href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetEvaReportTemplate&FileName=<?php echo $evaReportTemplateFileName['fileName'] ?>">
                                    download
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <form action="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/PostWordsTemplates" method="post" enctype="multipart/form-data" >
                    <div class="form-group row px-3 pt-2">
                        You can choose new Words files to replace to the server:
                    </div>
                    <div class="form-group row px-3 pt-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Words Template Files: </span>
                            </div>
                            <input id="wordsTemplateFiles" name="file[]" type="file"
                                   placeholder="Words template files"
                                   class="form-control"
                                   oninvalid="this.setCustomValidity('Please select the Words template file(s)!')"
                                   oninput="this.setCustomValidity('')"
                                   required multiple autocomplete="false">
                            <input class="btn btn-primary" type="submit" name="postWordsTemplates" id="postWordsTemplates" value="Upload Words Template File(s)">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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



