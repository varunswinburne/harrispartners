<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/styles.css" />
  
  <title>Harris Partners - Fridge Test</title>
</head>
<body>
<div id="upload">
  <form action="" method="post" enctype="multipart/form-data" id="form">
<input type="button" id="chooseButton" value="Choose Ingredients and Recipe Files"/><br/>
    <input type="file" id="file" name="files[]" multiple="multiple"/><br/>
  <input type="button" value="Process!" id="uploadButton" />
</form>
<div id="fileNames">

</div>




<?php

	require_once('recipeprocessor.php');
	require_once('recipeutils.php');
	
	$valid_formats = array("csv", "json");
	
	$message="";
	$count=0;
	
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
	{
		foreach ($_FILES['files']['name'] as $f => $name) {  
		
			$extension = pathinfo($name, PATHINFO_EXTENSION);
			
			
			if(! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message.=$name." is an invalid file<br/>";
				continue; // Skip invalid file formats
			}
			
			if($extension=='csv'|| $extension == 'json')
			{
				if($extension=='csv')
				{
					$ingredients=getcsvcontents($_FILES['files']['tmp_name'][$count]);
				}
				if($extension=='json')
				{
				
					$recipes=getjsoncontents($_FILES['files']['tmp_name'][$count]);
				}
			}
			$count++;
		
		}
		
		if($ingredients && $recipes)
		{
			$recipeProcessor = new RecipeProcessor();
			$recipeProcessor->setIngredients($ingredients);
			$recipeProcessor->setRecipes($recipes);
			
			$recipe = $recipeProcessor->findTheRightRecipe();
		}
		if(!$ingredients)
		{
			$message.="Invalid csv file<br/>";
		}
		if(!$recipes)
		{
			$message.="Invalid json file<br/>";
		}
		
	}
	
	

	
	if($recipe)
	{
		echo '<div class="recipediv">'.$recipe.'</div>'; 
	}
	else if($message)
	{
		echo '<div class="errordiv">'.$message.'</div>';
	}

?>
</div>
<script type="text/javascript" >



	function uploadAndProcessFiles()
	{
		var chooseHiddenButton = document.getElementById("file");
		var length = chooseHiddenButton.files.length;
		var hasJson=false;
		var hasCsv=false;
		var files=[];
		var fileNames = document.getElementById("fileNames");
		fileNames.innerHTML = "";
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

  	function initiateUpload()
	{
	
		var chooseHiddenButton = document.getElementById("file");
		chooseHiddenButton.click();
	}
	function init()
	{
		var chooseButton = document.getElementById("chooseButton");
		chooseButton.onclick=initiateUpload;
		var uploadButton = document.getElementById("uploadButton");
		uploadButton.onclick=uploadAndProcessFiles;
		var acc = document.getElementsByClassName("accordion");
		
		
	
	}
	
	window.onload=init;
  </script>
  
</body>
</html>