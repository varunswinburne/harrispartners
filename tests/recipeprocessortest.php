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

		$expected='a:3:{s:4:"name";s:14:"salad sandwich";s:11:"ingredients";a:2:{i:0;a:3:{s:4:"item";s:5:"bread";s:6:"amount";s:1:"2";s:4:"unit";s:6:"slices";}i:1;a:3:{s:4:"item";s:11:"mixed salad";s:6:"amount";s:3:"200";s:4:"unit";s:5:"grams";}}s:10:"expiryDate";s:10:"25/12/2016";}';
		assertTrue("testfindtherightrecipe",assert(serialize($recipeProcessor->findTheRightRecipe())==$expected),"Find the Right Recipe");
	
	}
	
	function testfindtherightrecipeexpiredingredients()
	{
		$recipeProcessor = new RecipeProcessor();
		$ingredients=getcsvcontents("expired_ingredients.csv");
		$recipeProcessor->setIngredients($ingredients);
		$recipes=getjsoncontents("recipes.json");
		$recipeProcessor->setRecipes($recipes);

		
		assertTrue("testfindtherightrecipeexpiredingredients",assert($recipeProcessor->findTheRightRecipe()=="Order Takeout"),"Find the Right Recipe - Expired Ingredients");
	
	}
	

	function runtestsuite()
	{
		testinstantiation();
		testgetcsvcontents();
		testgetjsoncontents();
		testingredientssetget();
		testrecipessetget();
		testfindtherightrecipe();
		testfindtherightrecipeexpiredingredients();
	}



	 runtestsuite();








?>