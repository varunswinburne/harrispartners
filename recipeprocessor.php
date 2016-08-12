<?php
/**
 * This class processes ingredients and recipes and determines the recipe to be used based off ingredients in the fridge,
 * and also based off their expiry dates
 */

class RecipeProcessor {
	

	/**
	 * Ingredients content
	 */
	private $ingredients;

	/**
	 * Recipes content
	 */
	private $recipes;

	/**
	 * The recommended recipe.
	 */
	private $recommendedRecipe;

	/**
	 * Default RecipeProcessor Constructor
	 * @return void
	 */
	public function __construct() {
		

	}

	/**
	 * Set the ingredients content
	 *
	 * @return void
	 * @param string $ingredientscontent The ingredients data array.
	 */
	
	public function setIngredients($ingredientscontent) {
		$this->ingredients= $ingredientscontent;
	}

	/**
	 * Set the recipes content
	 * @return void
	 * @param string $recipescontent The recipes data array.
	 */
	
	public function setRecipes($recipescontent) {
		$this->recipes = $recipescontent;
		return $this;
	}

	/**
	 * Return the ingredients array
	 * @return object || bool
	 */
	public function getIngredients() {
		return $this->ingredients;
	}

	/**
	 * Return the recipes array
	 *
	 * @return object || bool
	 */
	public function getRecipes() {
		return $this->recipes;
	}

	/**
	 * Fetch the recipe recommended based off ingredients in the fridge and their expiry dates
	 * @return str The recommended recipe.
	 */
	public function findTheRightRecipe() {
		if (!$this->chooseRecipe()) {
			return "Order Takeout";
		}

		return $this->recommendedRecipe;
	}

	/**
	 * Choose the best fitting recipe based on the list of ingredients available.
	 * @return object
	 */
	public function chooseRecipe() {
		
		if (!empty($this->ingredients) && !empty($this->recipes)) {
			
			// Remove all ingredients that have expired
			$this->removeExpiredIngredients();

			/**
			 * Populate an associative array of ingredients for quicker processing - where key is an integer and value is the ingredient
			 */
			$fridgeIngredients = array();
			foreach ($this->ingredients as $ingredientKey => $ingredient)
			{
				$fridgeIngredients[$ingredientKey] = $ingredient[0];
			}

			/**
			 * Run through every recipe and check what ingredients are missing.
			 * Discard any recipes that have no ingredients available/expired
			 */
			foreach ($this->recipes as $recipeUniqueKey => $recipe) 
			{
			
				foreach ($recipe['ingredients'] as $recipeIngredientKey => $recipeIngredient) 
				{
					
					// Search for the index of the current ingredient
					$indexOfIngredient = array_search($recipeIngredient['item'], $fridgeIngredients);

					if ($indexOfIngredient === false) {
						// Delete recipes for which ingredients aren't available
						unset($this->recipes[$recipeUniqueKey]);
						break;
					} 
					else {
							/**
							 * Compare the expiry dates of all ingredients and determine the recipe that should be used first 
							 */
							if (!isset($this->recipes[$recipeUniqueKey]['expiryDate'])) 
							{
							
								$this->recipes[$recipeUniqueKey]['expiryDate'] = $this->ingredients[$indexOfIngredient][3];
							} 
							else 
							{
								// Check if the expiry date of any ingredient is closer than that of the recipe. If yes pick that recipe up
								$recipeExpiryDate = new DateTime(str_replace('/', '-', $this->recipes[$recipeUniqueKey]['expiryDate']));
								$ingredientExpiryDate = new DateTime(str_replace('/', '-', $this->ingredients[$indexOfIngredient][3]));
								if($recipeExpiryDate < $ingredientExpiryDate)
								{
									$this->recipes[$recipeUniqueKey]['expiryDate'] =  $this->recipes[$recipeUniqueKey]['expiryDate'];
								}
								else
								{
									$this->recipes[$recipeUniqueKey]['expiryDate'] =  $this->ingredients[$indexOfIngredient][3]; 
							}
							
						}
					}
				}
			}

			/**
			 * Sort all recipes by their expiry date in an ascending order. 
			 * This would help us pick up conflicting recipes (if there are multiple ones that are due to expire)
						 */
			if (!empty($this->recipes)) 
			{
				if (count($this->recipes) >= 2) 
				{
					/*
						Sort recipes based on the expiry date
					*/
					usort($this->recipes, array($this,'dateComparator'));
				}
				/*
					Pick the first recipe off the list
				*/
				$this->recommendedRecipe = $this->recipes[0]['name'];
			} 
			else 
			{
				return false;
			}
		} 
		else 
		{
			return false;
		}

		return $this;
	}

	/**
	 * Check the expiry date of the ingredients and remove any that have expired.
	 * @return object || bool
	 */
	public function removeExpiredIngredients() {
		if (!is_null($this->ingredients)) {
			
			foreach ($this->ingredients as $ingredientKey => $ingredient) {
				
				$currentDate= new DateTime();

				// Format the use by date as a valid date string that can be interpreted as a DateTime object.
				$expiryDate= new DateTime(str_replace('/', '-', $ingredient[3]));

				// Remove any ingredient that's gone past it's expiry
				if ($currentDate> $expiryDate) {
					unset($this->ingredients[$ingredientKey]);
				}
			}
		} else {
			return false;
		}

		return $this;
	}

	/**
	 * Date comparator
	 * @param array $dateParam1
	 * @param array $dateParam2
	 * @return int
	 */
	public function dateComparator($dateParam1, $dateParam2) {
		// Convert Strings to Date Objects
		$dateOne= new DateTime(str_replace('/', '-', $dateParam1['expiryDate']));
	    $dateTwo= new DateTime(str_replace('/', '-', $dateParam2['expiryDate']));

	    if ($dateOne== $dateTwo) {
	        return 0;
	    }
	    
	    if($dateOne> $dateTwo)
	    {
	    	return 1;
	    }
	    
	    else if($dateOne < $dateTwo)
	    {
	    	return -1;
	    }

	}
}