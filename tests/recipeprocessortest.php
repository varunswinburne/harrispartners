<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="../css/styles.css" />
  
  <title>Harris Partners - Fridge Test - Unit Tests</title>
</head>
<body>
<div id="upload">
	<div id="title">
		Fridge Test - Unit Tests
	</div>
	<div id="testresults">
<?php

	require_once('../recipeprocessor.php');
	require_once('../recipeutils.php');

	$recipeProcessor;
	$ingredients;
	$recipes;
	
	function assertTrue($titlemessage,$conditionresult,$successmessage)
	{
		echo "Test : ".$titlemessage."<br/>";
		if($conditionresult)
		{
			echo "Success : ".$successmessage;
		}
		else
		{
			echo "Failure";
		}
		echo "<br/><br/>";
	}
	
	function testinstantiation()
	{		
		$recipeProcessor = new RecipeProcessor();
		assertTrue("testInstantiation",assert($recipeProcessor),"RecipeProcessor Instantiated");
	}
	
	function testgetcsvcontents()
	{
		$ingredients=getcsvcontents("ingredients.csv");
		assertTrue("testgetcsvcontents",assert($ingredients),"Ingredients Loaded");
	}
	
	function testgetjsoncontents()
	{
		$recipes=getjsoncontents("recipes.json");
		assertTrue("testgetjsoncontents",assert($recipes),"Recipes Loaded");
	}
	
	function testingredientssetget()
	{
		$recipeProcessor = new RecipeProcessor();
		$ingredients=getcsvcontents("ingredients.csv");
		$recipeProcessor->setIngredients($ingredients);
		assertTrue("testingredientssetget",assert($recipeProcessor->getIngredients()),"Ingredients Set");
	}
	
	function testrecipessetget()
	{
		$recipeProcessor = new RecipeProcessor();
		$recipes=getjsoncontents("recipes.json");
		$recipeProcessor->setRecipes($recipes);
		assertTrue("testrecipessetget",assert($recipeProcessor->getRecipes()),"Recipes Set");
	}
	
	function testfindtherightrecipe()
	{
		$recipeProcessor = new RecipeProcessor();
		$ingredients=getcsvcontents("ingredients.csv");
		$recipeProcessor->setIngredients($ingredients);
		$recipes=getjsoncontents("recipes.json");
		$recipeProcessor->setRecipes($recipes);
		$recipe=$recipeProcessor->findTheRightRecipe();
		$expected='salad sandwich';
		assertTrue("testfindtherightrecipe",assert($recipe['name']==$expected),"Find the Right Recipe");
	
	}
	
	function testnorecipesfound()
	{
		$recipeProcessor = new RecipeProcessor();
		$ingredients=getcsvcontents("missing_ingredients.csv");
		$recipeProcessor->setIngredients($ingredients);
		$recipes=getjsoncontents("recipes.json");
		$recipeProcessor->setRecipes($recipes);

		
		assertTrue("testnorecipesfound",assert($recipeProcessor->findTheRightRecipe()=="Order Takeout"),"Find the Right Recipe - No Recipes Found");
	
	}
	

	function runtestsuite()
	{
		testinstantiation();
		testgetcsvcontents();
		testgetjsoncontents();
		testingredientssetget();
		testrecipessetget();
		testfindtherightrecipe();
		testnorecipesfound();
	}



	 runtestsuite();








?>
</div></div>

  
</body>
</html>