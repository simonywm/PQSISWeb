<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4" style="text-align: center;padding-bottom:0px;">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading">
    					<h3 class="panel-title"><b>新增帳戶</b></h3>
  					</div>				
  					<div class="panel-body">
  						<div align="left"><font id="msgFont" color="red"></font></div>
  						<div class="row">
  							<div class="col-12">
								<div class="input-group">
									<?php 
									if ($groupType != "C")
										echo '<span id="usernamePrefix" grpId="GRP-H" class="input-group-addon">H</span>';
									else
										echo '<span id="usernamePrefix" grpId="GRP-G" class="input-group-addon">C</span>';
									?>
  									<!-- <span id="usernamePrefix" class="input-group-addon">H</span> -->
								    <input id="usernameTx" type="text" class="form-control" placeholder="帳戶名稱"/>
								</div>  							
  							</div>
  						</div>
  						<div class="row">
  							<div class="col-12">
  							<input id="passwordTx" type="text" class="form-control" maxlength="8" placeholder="電話號碼" />
  							</div>
  						</div>
  						<!-- 
  						<div class="row">
  							<div class="col-12">
  								<select id="groupTypeSelect">
  									<option value="GRP-H" selected>GROUP H</option>
  									<option value="GRP-G">GROUP G</option>
  								</select>
  							</div>
  						</div>
  						 -->
  						<div class="row">
	  						<div id="createDiv" class="col-md-12">
	  							<button id="createBtn" type="button" class="btn btn-primary" style="margin-top:10px;width:100%;align:left;">建立</button>
	  						</div>
  						</div>
  					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(function () {
		$("#usernameTx").numeric();
		$("#passwordTx").numeric();
		
		$("#createBtn").unbind().bind("click", function() {
			// check if password id 8 digit
			if ($("#passwordTx").val().length != 8)
			{
				$("#msgFont").html("電話號碼一定要是8位數字");
				$("#msgFont").attr("color", "red");
				return;
			}
			
			$(this).prop("disabled", true);
			var ranId = makeid();
			var usernameWithGrp = $("#usernamePrefix").html() + $("#usernameTx").val();

/*			if ($("#groupTypeSelect").val() == "GRP-H")
				usernameWithGrp = "H" + $("#usernameTx").val();
			else if ($("#groupTypeSelect").val() == "GRP-G")
				usernameWithGrp = "C" + $("#usernameTx").val();
*/
			$.ajax({
				url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Site/ProcessCreateUser&ranId=" + ranId,
				type: "POST",
				cache: false,
				//data: { username: usernameWithGrp, password: $("#passwordTx").val(), groupType: $("#groupTypeSelect").val() } 
				data: { username: usernameWithGrp, password: $("#passwordTx").val(), groupType: $("#usernamePrefix").attr("grpId") }
			}).done(function( data ) {
				var retJson = JSON.parse(data);
				$("#msgFont").html(retJson.retMessage);

				if (retJson.status == "SUCCESS")
				{
					$("#msgFont").attr("color", "blue");
				//	window.location.href = "<?php echo Yii::app()->request->baseUrl; ?>/";
				}
				else if (retJson.status == "FAIL")
					$("#msgFont").attr("color", "red");
			}).fail(function (xhr, textStatus, errorThrown) {
				alert("Error in creating user account");
	        }).always(function () {
	        	$("#createBtn").prop("disabled", false);		        
	        });			
		});

		/*
		$("#groupTypeSelect").unbind().bind("change", function() {
			if ($(this).val() == "GRP-H")
				$("#usernamePrefix").html("H");
			else if ($(this).val() == "GRP-G")
				$("#usernamePrefix").html("C");
		});
		*/
	});
	
</script>