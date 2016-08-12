/*
	This script handles all client side validation for the Fridge-Test application

*/


	/*
	*	This method uploads the files to the processing script
	*	@return void
	*/
	function uploadAndProcessFiles()
	{
		var chooseHiddenButton = document.getElementById("file");
		var length = chooseHiddenButton.files.length;
		var hasJson=false;
		var hasCsv=false;
		var files=[];
		var fileNames = document.getElementById("fileNames");
		fileNames.innerHTML = "";
		//Validate files
		for (var i = 0; i < chooseHiddenButton.files.length; i++)
		{
			var fileName = chooseHiddenButton.files[i].name;
			var extensionFields = fileName.split(".");
			var extension = extensionFields[(extensionFields.length)-1];
			files.push(fileName);
			if(extension=='csv')
			{
				hasCsv=true;
			}
			if(extension=='json')
			{
				hasJson=true;
			}
			
		 }
		 //If files are valid submit to recipeprocessor for processing
		if(length==2&& hasCsv && hasJson)
		{
			document.getElementById("form").submit(); 
		}
		else
		{
			if(length==0)
			{
				fileNames.innerHTML = "No files uploaded. Please select ingredients.csv and recipes.json to continue";
			}
			else
			{
				fileNames.innerHTML="Please select only ingredients.csv and recipes.json to continue<br/><br/><u>Files Uploaded</u><br/><br/>";
				for(var fileIndex=0;fileIndex<length;fileIndex++)
				{
					fileNames.innerHTML+=files[fileIndex]+"<br/>";
				}
			}
		}
		
	}

	/*
	*	This method is called when the file picker is clicked
	*	@return void
	*/
  	function initiateUpload()
	{
	
		var chooseHiddenButton = document.getElementById("file");
		chooseHiddenButton.click();
		
		chooseHiddenButton.onchange = function () {
		var fileNames = document.getElementById("fileNames");
		fileNames.innerHTML = "";
		 fileNames.innerHTML="<u>Files Uploaded</u><br/><br/>";
		 var length = chooseHiddenButton.files.length;

				for(var fileIndex=0;fileIndex<length;fileIndex++)
				{
					fileNames.innerHTML+=chooseHiddenButton.files[fileIndex].name+"<br/>";
				}
		};
	}
	
	/*
	*	This method initialises necessary variables for further processing
	*	@return void
	*/
	function init()
	{
		var chooseButton = document.getElementById("chooseButton");
		chooseButton.onclick=initiateUpload;
		var uploadButton = document.getElementById("uploadButton");
		uploadButton.onclick=uploadAndProcessFiles;
		var acc = document.getElementsByClassName("accordion");
		
		
	
	}
	
	//Call init on page load
	window.onload=init;