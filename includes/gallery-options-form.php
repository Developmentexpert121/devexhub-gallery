<!-- gallery-options-form.php -->

<div class="wrap">
	<div class="container px-3">
    <!-- <h2 class="text-center fw-bold pb-5">Gallery Options</h2> -->
    <div class="d-flex justify-content-between align-items-center py-3">
    	<h2 class="text-center fw-bold">Gallery Options</h2>
    	<button type="button" class="btn" id="btn_form_devexhub" style="background-color: #095075; color: #fff;">
  			Contact Us
		</button>
    </div>
    <div class="row layout-form justify-content-center" style="display: flex;">
    	<div class="p-3 col-md-12 shadow-lg"  style="border-radius: 6px 0 0 6px;">
        <form method="post" action="">
            <h4 class="fs-4">Select Layout</h4>
            	<div class="row">
            		<div class="col-md-4">
            			<div class="flex-grow mx-1 p-2 border rounded">
            			<?php echo gallery_layout_option('layout1', 'Layout 1', 'layout_1.png', $selected_layout); ?>
            			<div class="h-200">
            			<p>The layout displays categories on the left side and gallery images on the right. Images are arranged in accordance with their resolution, and as the cursor hovers over an image, it gradually zooms out to reveal a larger version of the image.</p>
            		</div>
            		</div>
            	</div>
            		<div class="col-md-4">
            			<div class="flex-grow mx-1 p-2 border rounded">
	            		<?php echo gallery_layout_option('layout2', 'Layout 2', 'layout_2.png', $selected_layout); ?>
	            		<div class="h-200">
            				<p>The gallery image part is below and the categories are at the top of the full width design.The resolution of the photographs is clustered with a few little gaps.</p>
            				 	</div>
	           
	            	</div>
	            </div>
	            	<div class="col-md-4">
	            		<div class="flex-grow mx-1 p-2 border rounded">
	            		<?php echo gallery_layout_option('layout3', 'Layout 3', 'layout_3.png', $selected_layout); ?>
	            		<div class="h-200">
	            		<p>The categories are on the left, while the gallery image section is on the right. The photos have a set resolution and are covered in vibrant overlays that include titles. Hover effect added to view the original image</p>
	            	</div>
	            	</div>
            	</div>
            </div>
        	

            <!-- Add more layouts if needed -->
			<div class="text-center my-3">
				<input type="submit" class="px-3 py-1 border-0  text-white rounded" style="font-size: 22px; background-color: #095075 ;" value="Save Layout">
			</div>
        </form>
    	</div>
    </div>
</div>
</div>
<div class="modal fade shadow" id="Formmodal_devexhub" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 60px;">
  <div class="modal-dialog shadow">
    <div class="modal-content">
    	<div class="modal-header justify-content-end p-0" style="position: relative;" id="close_btn_devexhub">
    		<button type="button" class="btn btn-secondary" style="position: absolute; top: -14px; right: -8px; border-radius: 50px; background-color: #095075;">X</button>
    	</div>
      <div class="modal-body">
      	<div class="row justify-content-center">
      		<div class="col-md-10">
         <form id="email-form">
		    	<h2 class="text-center fw-bold">Contact Us</h2>
		        <div class="form-group" style="margin-bottom: 10px;">
		            <label class="form-label" style="display: block; font-size: 20px; margin-bottom: 6px;" for="name">Name</label>
		            <input class="form-control" id="name" type="text" placeholder="john" style="width: 100%; font-size: 17px;">
		        </div>
		        <div class="form-group" style="margin-bottom: 10px;">
		            <label class="form-label" style="display: block; font-size: 20px; margin-bottom: 6px;" for="email">Email</label>
		            <input id="email" type="email" placeholder="john@" style="width: 100%; font-size: 17px;">
		        </div>
		        <div class="form-group" style="margin-bottom: 10px;">
		            <label class="form-label" style="display: block; font-size: 20px; margin-bottom: 6px;" for="message">Message</label>
		            <textarea id="message" placeholder="message......." style="width: 100%; font-size: 17px;"></textarea>
		        </div>
		        <div class="form-group" style="margin-bottom: 10px;display:none;" id="sent_message_success" >
		        	Message sent successfully.
		        </div>
		        <div class="text-center my-3">
		        <button id="submit-button" class="px-5 py-1 border-0 text-white rounded" style="font-size: 22px; background-color: #095075 ;">Submit</button>
		    </div>
		    </form>
		</div>
		</div>
      </div>
      
    </div>
  </div>
</div>
