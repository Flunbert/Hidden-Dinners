package api.models;

import java.util.LinkedList;

public class IngredientList {
    private LinkedList<Ingredient> ingredients;

    public LinkedList<Ingredient> getIngredients() {
        return ingredients;
    }

    public void setIngredients(LinkedList<Ingredient> ingredients) {
        this.ingredients = ingredients;
    }
}