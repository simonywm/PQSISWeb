<?php //@session_start(); Yii::app()->setLanguage(isset($_SESSION['lang'])?Yii::app()->setLanguage($_SESSION['lang']):Yii::app()->setLanguage('zh_hk')); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <link rel="icon" href="/CUHK.ico">


		   <!-- Bootstrap core JavaScript
    ================================================== -->
    
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery-3.5.1.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap/bootstrap.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap/bootstrap.bundle.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/selectize/selectize.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/numeric/jquery.numeric.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/DataTables-1.10.21/jquery.dataTables.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap/bootstrap-select.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/fontawesome_all.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/selectize.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/common_util.js"></script>

	    
	    <!-- Bootstrap core CSS -->
	    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap-grid.css" />
	    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap-reboot.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap-select.css" />
		<!--selectize CSS -->
	    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/selectize/selectize.bootstrap3.css" />
	    <!-- datatable CSS -->
		 <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/DataTables-1.10.21/jquery.dataTables.min.css" />
		 <!--fontawesome_all -->
		 <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/all.min.css" />
		 	    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/sticky-footer.css" />
	    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/selectize/selectize.bootstrap3.css" />
	    <!--loadingGifCSS -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css" />

	    <title><?php echo Yii::t('globalmessage', Yii::app()->name) ?></title>
	</head>
	
	<body>
		<div id="page_content">
			<?php echo $content; ?>	
		</div>
	</body>

	<!-- FOOTER -->
	<div class="footer">
		<div class="container" id="page_footer">
			<div class="row">
				<div class="col-12" style="text-align:center;">			
					<?php echo Yii::t('globalmessage', 'Powered by JKTech-Ltd'); ?>
				</div>
			</div>
	    </div>
	</div>

 
    </body>
</html>
