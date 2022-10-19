<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;
?>
<html>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

 


<div class="row" id="loginDiv">
	<div class="col-md-4"></div>
	<div class="col-md-4" style="text-align: center;padding-bottom:0px;">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading">
    					<h3 class="panel-title"><b>Login</b></h3>
  					</div>				
  					<div class="panel-body">
  						<div align="left"><font id="msgFont" color="red"></font></div>
						  <input id="txLoginId" name="txLoginId" type="text" class="form-control" placeholder="Input Login Name" value=""  />


						  <br />
				    <div class="form-group show_hide_password">                  
                       <div class="input-group">
                           <input id="txPassword" name="txPassword" type="password" class="form-control" placeholder="Password" value="" />

                         <div class="input-group-prepend">
                           <button class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                         </div>
                       </div>
                    </div>
					<div id="editableDiv" class="form-check" style="text-align:left;">
    					<input id="txEditable" type="checkbox" class="form-check-input" >
    					<label class="form-check-label" for="txEditable">Editable</label>
  					</div>
  						<div id="loginButtonDiv" class="col-md-12" >
  							<button id="loginBtn" type="button" class="btn btn-primary" style="margin-top:10px;width:100%;align:right;">Login</button>
  						</div>
  						
  					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</html>

<script>
	$(function () {

		$(".show_hide_password button").on('click', function (event) {
            event.preventDefault();
            if ($('.show_hide_password input').attr("type") == "text") {
                $('.show_hide_password input').attr('type', 'password');
                $('.show_hide_password button svg').attr("data-icon", "eye-slash")

            } else if ($('.show_hide_password input').attr("type") == "password") {
                $('.show_hide_password input').attr('type', 'text');
                $('.show_hide_password button svg').attr("data-icon", "eye")
            }
        });
		$("#loginBtn").unbind().bind("click", function() {
			if ($("#txLoginId").val() == "")
			{
				$("#msgFont").html("Please input Password");
				return;
			}
			if ($("#txPassword").val() == "")
			{
				$("#msgFont").html("Please input Password");
				return;
			}
			if($("#txEditable:checked").val() == "on"){
				check = "on";
			}
			else{
				check="off"
			}
			$.ajax({
				
				url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Site/AjaxLogin",
				type: "POST",
				cache: false,
				data: { loginId: $("#txLoginId").val(), password: $("#txPassword").val(),editable: check} 
			}).done(function( data ) {

				console.log(data);
				var retJson = JSON.parse(data);

				console.log(retJson);
				
				if (retJson.status == "OK")
				{
					window.location.href = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch";
				}
				else
					$("#msgFont").html(retJson.retMessage);
			}).fail(function (xhr, textStatus, errorThrown) {
				console.log(xhr);
	            $("body").html(xhr.responseText);
	        });		
		});

		$("#txLoginId").focus();
	});
	
</script>