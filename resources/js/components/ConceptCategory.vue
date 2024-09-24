<template>
  <div id="concept-table" classname="">
    <div class="form-group">
      <div class="mt-3">
        <h4>Concept Category</h4>
        <b-col cols="4">
          <b-form-select
            v-model="selectedCategory"
            :options="categories"
          ></b-form-select>
        </b-col>
      </div>
    </div>
  </div>
</template>

<script>
import { categories } from '../config/categories';

export default {
  props: {
    categoriesProps: {
      type: Array,
    },
  },
  data() {
    return {
      categories,
    };
  },
};
</script>

<style scoped></style>
