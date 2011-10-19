<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js')?>"></script>
   <div class="formpage">
        <div class="navigation">
        	<input type="button" class="backbutton" id="btnBack"
              value="<?php echo __("Back")?>" tabindex="13" />
        </div>
        <div id="status"></div>
        <div class="outerbox">
            <div class="mainHeading"><h2><?php echo __("Memberships : Membership Type")?></h2></div>
            	<form name="frmSave" id="frmSave" method="post"  action="">
                
                 <label for="txtSkillName"><?php echo __("Name")?> <span class="required">*</span></label>
                     <input id="txtMemTypeDescription"  name="txtMemTypeDescription" type="text"  class="formInputText" value="" tabindex="5" />
             		 <br class="clear"/>
             	
					  
                <div class="formbuttons">
                    <input type="button" class="savebutton" id="editBtn"
                       
                        value="<?php echo __("Save")?>" tabindex="11" />
                    <input type="button" class="clearbutton" id="resetBtn"
                         value="<?php echo __("Reset")?>" tabindex="12" />
                </div>
            </form>
        </div>
         <div class="requirednotice"><?php echo preg_replace('/#star/', '<span class="required">*</span>', __("Fields marked with an asterisk #star are required.") ); ?>.</div>
   </div>
   
   <script type="text/javascript">

		$(document).ready(function() {

			

			//Validate the form
			 $("#frmSave").validate({
				
				 rules: {
				 	txtMemTypeDescription: { required: true }
				 	
			 	 },
			 	 messages: {
			 		txtMemTypeDescription: "<?php echo __("Name is required")?>"
			 		
			 	 }
			 });

			// When click edit button
				$("#editBtn").click(function() {
					$('#frmSave').submit();
				});

			 //When Click back button 
			 $("#btnBack").click(function() {
				 location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/admin/listMembershipType')) ?>";  
				});

			//When click reset buton 
				$("#resetBtn").click(function() {
					document.forms[0].reset('');
				 });
				
		 });
</script>
       