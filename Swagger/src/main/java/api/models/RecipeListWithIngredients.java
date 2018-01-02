package api.models;

import java.util.LinkedList;

public class RecipeListWithIngredients {
    private LinkedList<RecipeWithIngredients> recipes;

    public LinkedList<RecipeWithIngredients> getRecipes() {
        return recipes;
    }

    public void setRecipes(LinkedList<RecipeWithIngredients> recipes) {
        this.recipes = recipes;
    }
}
