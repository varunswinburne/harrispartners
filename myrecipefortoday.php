<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/styles.css" />
  <script type="text/javascript" src="js/script.js"></script>
  <title>Harris Partners - Fridge Test</title>
</head>
<body>
<div id="upload">
	<div id="title">
		Fridge Test - My Recipe for Today
	</div>
	
	<form action="" method="post" enctype="multipart/form-data" id="form">
		<input type="button" id="chooseButton" value="Pick Ingredients and Recipe Files"/><br/>
		<input type="file" id="file" name="files[]" multiple="multiple"/><br/>
		<input type="button" value="Process!" id="uploadButton" />
	</form>
	<div id="fileNames">
	
	</div>


<?php

	/*
	* Load the Recipe Processor
	*/
	require_once('recipeprocessor.php');
	/*
	* Load the Utils File
	*/
	require_once('recipeutils.php');
	
	/*
	* Initialise valid file types
	*/
	$valid_formats = array("csv", "json");
	
	$message="";
	$count=0;
	$recipe=false;
	/*
	* Process files if uploaded
	*/
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
	{
		foreach ($_FILES['files']['name'] as $f => $name) {  
		
			$extension = pathinfo($name, PATHINFO_EXTENSION);
			
			/*
			* Skip invalid files that are not csv nor json
			*/
			if(! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message.=$name." is an invalid file<br/>";
				continue; // Skip invalid file formats
			}
			
			if($extension=='csv'|| $extension == 'json')
			{
				if($extension=='csv')
				{
					/*
					* Read CSV Contents
					*/
					$ingredients=getcsvcontents($_FILES['files']['tmp_name'][$count]);
				}
				if($extension=='json')
				{
					/*
					* Read JSON Contents
					*/
					$recipes=getjsoncontents($_FILES['files']['tmp_name'][$count]);
				}
			}
			$count++;
		
		}
		
		/*
		* If ingredients and recipes have been  successfully loaded, process them
		*/
		if($ingredients && $recipes)
		{
			$recipeProcessor = new RecipeProcessor();
			$recipeProcessor->setIngredients($ingredients);
			$recipeProcessor->setRecipes($recipes);
			/*
			* Find the recipe
			*/
			$recipe = $recipeProcessor->findTheRightRecipe();
		}
		/*
		* Invalid CSV file
		*/
		if(!$ingredients)
		{
			$message.="Invalid csv file<br/>";
		}
		/*
		* Invalid JSON file
		*/
		if(!$recipes)
		{
			$message.="Invalid json file<br/>";
		}
		
	}
	
	

	/*
	*	Display the recipe if fetched
	*/
	if($recipe)
	{
	
		if(is_array($recipe))
		{
			echo '<div class="recipediv">'.$recipe['name'].'</div>'; 
		}
		else
		{
			echo '<div class="recipediv">'.$recipe.'</div>'; 
		}
	}
	/*
	*	Display an error message if not fetched
	*/
	else if($message)
	{
		echo '<div class="errordiv">'.$message.'</div>';
	}

?>
</div>



  
</body>


</html>