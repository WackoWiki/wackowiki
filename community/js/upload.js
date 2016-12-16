/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

Action - module for bulk upload files on a wackowiki site with a record in the database.

* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

var $ = jQuery.noConflict();


$(document).ready(function() {
	// at dataTransfer put files that are dragged into the region div
	jQuery.event.props.push('dataTransfer');
	
	// maximum number of files at once
	var maxFiles = 20;
	
	// default alert
	var errMessage = 0;
	
	// button for file selection
	var defaultUploadBtn = $('#uploadbtn');
	
	// array with all files
	var dataArray = [];
	
	// area widget on uploaded files - hidden
	$('#uploaded-files').hide();
	
	// method when you drop the file in the upload area
	$('#drop-files').on('drop', function(e) {
		// All files are transferred to the received files
		var files = e.dataTransfer.files;
		
		// check the maximum number of files
		if (files.length <= maxFiles) {
			// pass an array with files in the upload function to preview
			loadInView(files);
		} else {
			alert(''+upload_lang.MaxFiles.replace('%', maxFiles )+'');
			files.length = 0; return;
		}
	});
	
	// clicking on the button to select the file
	defaultUploadBtn.on('change', function() {
		// fill an array of selected files
		var files = $(this)[0].files;
		
		// check the maximum number of files
		if (files.length <= maxFiles) {
			// pass an array with files in the download function to preview
			loadInView(files);
			
			// clear the INPUT file by resetting the form
			$('#frm').each(function(){
				this.reset();
			});
		} else {
			alert(''+upload_lang.MaxFiles.replace('%', maxFiles )+'');
			files.length = 0;
		}
	});
	
	// function to upload files for the preview
	function loadInView(files) {
		// show the preview area
		$('#uploaded-holder').show();
		
		// for each file
		$.each(files, function(index, file) {
			// check the number of uploadable items
			if((dataArray.length+files.length) <= maxFiles) {
				// shows the area with buttons
				$('#upload-button').css({'display' : 'block'});
			}
			else { alert(''+upload_lang.MaxFiles.replace('%', maxFiles )+''); return; }
			
			// create a new instance FileReader
			var fileReader = new FileReader();
			
			// initiate function FileReader
			fileReader.onload = (function(file) {
				return function(e) {
					// put URI file into an array
					dataArray.push({name : file.name, value : this.result, description_edit : null, name_edit : file.name, access_edit : null});
					addImage((dataArray.length-1));
				};
			})(files[index]);
			
			// reads the file by the URI
			fileReader.readAsDataURL(file);
		});
		return false;
	}
	
	// add thumbnail to page
	function addImage(ind) {
		// if the index is negative then deduce the entire array of files
		if (ind < 0 ) {
			start = 0; end = dataArray.length; 
		} else {
			// otherwise only certain file
			start = ind; end = ind+1;
		}
		
		// alerts uploaded files
		if(dataArray.length == 0) {
			// if an empty array hide buttons and the entire region
			$('#upload-button').hide();
			$('#uploaded-holder').hide();
		} else if (dataArray.length == 1) {
			$('#upload-button span').html(''+upload_lang.FileSelected+'');
		} else {
			$('#upload-button span').html(dataArray.length+' '+upload_lang.FilesSelected+'');
		}
		
		// cycle for each element of the array
		for (i = start; i < end; i++) {
			// locate uploaded files
			if($('#dropped-files > .image').length <= maxFiles) {
				$('#dropped-files').append('<div class="image" id="img-'+i+'"><div class="preview_image" style="background: url('+dataArray[i].value+') no-repeat center; background-size: contain;"></div><span class="name_file_span">'+upload_lang.FileName+':<textarea id="selectOpen2-'+i+'" name="selectOpen2" placeholder="'+dataArray[i].name+'" rows="1" cols="23" wrap="off"></textarea></span><br><span class="name_file_span">'+upload_lang.FileDescription+':<textarea id="selectOpen-'+i+'" name="selectOpen" rows="1" cols="23" wrap="off"></textarea></span><br><div class="input_span"><input type="radio" id="glloc_g-'+i+'" name="glloc-'+i+'" value="global"><label for="glloc_g-'+i+'"> '+upload_lang.FileGlobal+'</label></div><div class="input_span"><input type="radio" id="glloc_l-'+i+'" name="glloc-'+i+'" value="local" checked><label for="glloc_l-'+i+'"> '+upload_lang.FileLocal+'</label></div><a href="#" id="drop-'+i+'" class="drop-button"><span class="a-link">'+upload_lang.DeleteFile+'</span></a></div>');
			}
		}
		return false;
	}
	
	// delete all files
	function restartFiles() {
		// reset the loading bar to the default
		$('#loading-bar .loading-color').css({'width' : '0%'});
		$('#loading').css({'display' : 'none'});
		$('#loading-content').html(' ');
		
		// deletes all files on the page and hide the button
		$('#upload-button').hide();
		$('#dropped-files > .image').remove();
		$('#uploaded-holder').hide();
		
		// clear array
		dataArray.length = 0;
		return false;
	}
	
	// deletes selected files
	$("#dropped-files").on("click","a[id^='drop']", function(e) {
		e.preventDefault();
		
		// get the name of the id
		var elid = $(this).attr('id');
		
		// create an array to separate lines
		var temp = new Array();
		
		// dividing line id in 2 parts
		temp = elid.split('-');
		
		// get the value after the dash that is the index of the files in the array
		dataArray.splice(temp[1],1);
		
		// delete old thumbnails
		$('#dropped-files > .image').remove();
		
		// updating thumbnails in accordance with the updated array
		addImage(-1);
	});
	
	// delete all files button
	$('#dropped-files #upload-button .delete').click(restartFiles);
	
	// upload files
	$('#upload-button .upload').click(function() {
		// shows the progress bar
		$("#end_space").hide();
		$("#loading").show();
		
		// variables for the progress bar
		var totalPercent = 100 / dataArray.length;
		var x = 0;
		$('#loading-content').html(''+upload_lang.Uploads+' '+dataArray[0].name);
		
		// for each file
		$.each(dataArray, function(index, file) {
			dataArray[index].description_edit = $('#selectOpen-'+index+'').val();
			var temp_form = $('#selectOpen2-'+index+'').val();
			
			if(temp_form.length == 0) {
				dataArray[index].name_edit = dataArray[index].name;
			}
			else {
				dataArray[index].name_edit = $('#selectOpen2-'+index+'').val();
			}
			
			dataArray[index].access_edit = $('#glloc-'+index+':checked').val();
			
			// load the page and pass values ​​using the HTTP POST request
			var ThisA = window.location;
			
			$.post(ThisA, dataArray[index], function(data) {
				var fileName = dataArray[index].name;
				++x;
				
				// change upload bar 
				$('#loading-bar .loading-color').css({'width' : totalPercent*(x)+'%'});
				
				// If the upload is over
				if(totalPercent*(x) == 100) {
					// Loading is complete
					$('#loading-content').html(''+upload_lang.LoadingComplete+'!');
					
					// call the function to delete all files after a delay of 1 second
					setTimeout(restartFiles, 1000);
					
					// if still ongoing loading
				} else if(totalPercent*(x) < 100) {
					// which file is loaded
					$('#loading-content').html(''+upload_lang.Loading+' '+fileName);
				}
				
				// we form a list of all uploaded files
				// data formed upload.php
				var dataSplit = data.split(':');
				
				if(dataSplit[1] == upload_lang.LoadedSuccessfully) {
					$('#uploaded-files').append('<li><a href="image/'+dataSplit[0]+'">'+fileName+'</a> '+upload_lang.LoadedSuccessfully+'</li>');
				} else {
					$('#uploaded-files').append('<li><a href="image/'+data+'. '+upload_lang.FileName+': '+dataArray[index].name+'</li>');
				}
			});
		});
		
		// shows a list of uploaded files
		$('#uploaded-files').show();
		return false;
	});
	
	// simple drag and drop styles to the field
	$('#drop-files').on('dragenter', function() {
		$(this).css({'box-shadow' : 'inset 0px 0px 20px rgba(0, 0, 0, 0.1)', 'border' : '4px dashed #bb2b2b'});
		return false;
	});
	
	$('#drop-files').on('drop', function() {
		$(this).css({'box-shadow' : 'none', 'border' : '4px dashed rgba(0,0,0,0.2)'});
		return false;
	});
});