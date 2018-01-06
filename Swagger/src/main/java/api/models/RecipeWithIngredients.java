package api.models;

import java.util.LinkedList;

public class RecipeWithIngredients {
    private int recipe_id;
    private String recipeName;
    private String instructions;
    private LinkedList<RecipeIngredient> ingredients;

    public int getRecipe_id() {
        return recipe_id;
    }

    public void setRecipe_id(int recipe_id) {
        this.recipe_id = recipe_id;
    }

    public String getInstructions() {
        return instructions;
    }

    public void setInstructions(String instructions) {
        this.instructions = instructions;
    }

    public LinkedList<RecipeIngredient> getIngredients() {
        return ingredients;
    }

    public void setIngredients(LinkedList<RecipeIngredient> recipeIngredients) {
        this.ingredients = recipeIngredients;
    }

    public String getRecipeName() {
        return recipeName;
    }

    public void setRecipeName(String recipeName) {
        this.recipeName = recipeName;
    }

    private class RecipeIngredient {
        private String ingredient;
        private float amount;
        private String measurement;

        public String getIngredient() {
            return ingredient;
        }

        public void setIngredient(String ingredient) {
            this.ingredient = ingredient;
        }

        public float getAmount() {
            return amount;
        }

        public void setAmount(int amount) {
            this.amount = amount;
        }

        public String getMeasurement() {
            return measurement;
        }

        public void setMeasurement(String measurement) {
            this.measurement = measurement;
        }
    }
}
