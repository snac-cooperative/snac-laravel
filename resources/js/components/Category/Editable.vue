<template>
  <BInputGroup>
    <div
      v-if="originalId"
      class="category-item custom-select"
      :class="{'font-weight-bold': isPrimary}"
    >
      {{ selectedValue }}
    </div>
    <BFormSelect
      v-else
      v-model="selectedId"
      @change="trackChanges"
      :options="getCategories"
      :class="{ 'alert-info': isDirty() }"
      aria-placeholder="Select a category"
      placeholder="Select a category"
    ></BFormSelect>

    <BInputGroupAppend>
      <BButton
        @click="emitSaveCategory"
        class="btn btn-info"
        title="Save"
        v-show="!originalId && isDirty()"
      ><i class="fa fa-floppy-o"></i
      ></BButton>
      <BButton
        @click="emitMakeCategoryPrimary"
        v-if="!isPrimary && originalId"
        class="btn btn-primary"
        title="Make Primary"
      ><i class="fa fa-check-square-o"></i
      ></BButton>
      <BButton
        @click="emitDeleteCategory"
        class="btn btn-danger"
        title="Delete"
      ><i class="fa fa-trash"></i
      ></BButton>
    </BInputGroupAppend>
  </BInputGroup>
</template>

<script>
import {
  BButton,
  BFormSelect,
  BInputGroup,
  BInputGroupAppend,
} from 'bootstrap-vue';
import { categories } from '../../config/categories';

export default {
  data() {
    return {
      selectedId: this.categoryId,
      originalId: this.categoryId,
      selectedValue: this.categoryValue,
      previous: null,
      categories,
    };
  },
  model: {
    event: 'input',
  },
  props: {
    categoryId: {
      type: Number,
      default: null,
    },
    isPrimary: {
      type: Boolean,
      default: false,
    },
    categoryValue: {
      type: String,
      default: null,
    },
    categoryIndex: {
      type: Number,
      default: null,
    },
    selectedCategories: {
      type: Array,
      default: () => [],
    },
  },
  components: {
    BInputGroup,
    BInputGroupAppend,
    BFormSelect,
    BButton,
  },
  computed: {
    getCategories() {
      const filtered = this.categories.filter((cat) => {
        return (
          this.selectedCategories.filter((currentCat) => {
            return currentCat === parseInt(cat.value);
          }).length === 0 || this.categoryId === parseInt(cat.value)
        );
      });

      if(!this.selectedId){
        filtered.unshift({ value: null, text: 'Select a category', disabled: true });
      }

      return filtered;
    },
  },
  methods: {
    trackChanges(categoryId) {
      const selectedId = parseInt(this.selectedId);

      this.$emit('change', { id: selectedId, dirty: this.isDirty(), previous: this.previous });
      this.previous = selectedId;
    },
    emitSaveCategory() {
      const selectedId = parseInt(this.selectedId);
      this.$emit('save-category', selectedId, this.categoryIndex);
      this.originalId = selectedId;
      this.selectedValue = this.categories.find((cat) => parseInt(cat.value) === this.originalId).text;
    },
    emitMakeCategoryPrimary() {
      this.$emit('make-category-primary', this.categoryId, this.categoryIndex);
    },
    emitDeleteCategory() {
      this.$emit('delete-category', this.categoryId, this.categoryIndex);
    },
    isDirty() {
      if(!this.selectedId) {
        return !!this.categoryId;
      }
      return this.originalId !== parseInt(this.selectedId);
    },
    resetCategory() {
      this.selectedId = this.categoryId;
    },
  },
};
</script>
<style>
.category-item.custom-select {
  background-image: none;
}
</style>
