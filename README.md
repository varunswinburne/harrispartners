# Harris Partners - Fridge Test
Fridge Test


# Working model
A working model can be found at http://harrispartners.varunczar.com/ 

# Algorithm
Step 1: Input two files ingredients.csv and recipes.json
Step 2: Check for validity of both files. If either are invalid, show an error message and move to Step 10
Step 3: If both files are valid, read the contents to memory
Step 4: Run through all recipes in the json file and compare it against the ingredients array to ensure all ingredients are available. If not discard the recipe
Step 5: 	Compare the expiry dates of all ingredients and determine the recipe that should be used first
Step 6: Check if the expiry date of any ingredient is closer than that of the recipe. If yes pick that recipe up else return “Order Takeout”


# Run Steps

#  Pre-requisite
Download the input files from https://github.com/varunswinburne/harrispartners/tree/master/input 

# Steps
Step 1 : Go to the url http://harrispartners.varunczar.com/ 
Step 2: Click on the button “My Recipe for Today”
Step 3: On the page that opens up, click on the button “Pick Ingredients and Recipe Files”
Step 4: Select the ingredients.csv and recipes.json files off your computer
Step 5: Once selected, click on Process! This will display the recipe fetched

# Test Steps
Step 1 : Go to the url http://harrispartners.varunczar.com/ 
Step 2: Click on the button “Unit Tests”
Step 3: The page that opens up will run and display a set of Automated Unit Tests from a Test Suite 
