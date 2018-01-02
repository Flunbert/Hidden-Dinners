package api.models;

import java.util.LinkedList;

public class RecipeList {
    private LinkedList<Recipe> recipes;

    public LinkedList<Recipe> getRecipes() {
        return recipes;
    }

    public void setRecipes(LinkedList<Recipe> recipes) {
        this.recipes = recipes;
    }
}
