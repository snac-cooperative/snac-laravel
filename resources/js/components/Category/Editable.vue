<template>
  <BInputGroup>
    <BFormSelect
      v-model="originalId"
      @input="updateCategory"
      :options="getCategories"
      :class="{ 'alert-info': isDirty }"
    ></BFormSelect>

    <BInputGroupAppend>
      <BButton
        @click="emitSaveCategory"
        class="btn btn-info"
        title="Save"
        v-show="isDirty"
      ><i class="fa fa-floppy-o"></i
      ></BButton>
      <BButton
        @click="emitMakeCategoryPrimary"
        v-if="!isPrimary"
        class="btn btn-primary"
        title="Make Primary"
      ><i class="fa fa-check-square-o"></i
      ></BButton>
      <BButton
        @click="emitDeleteCategory"
        v-if="!isPrimary"
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

export default {
  data() {
    return {
      originalId: this.category.id,
      originalValue: this.category.value,
      selectedId: this.category.id,
    };
  },
  model: {
    prop: 'category',
    event: 'input',
  },
  props: {
    category: Object,
    isPrimary: Boolean,
  },
  components: {
    BInputGroup,
    BInputGroupAppend,
    BFormSelect,
    BButton,
  },
  computed: {
    getCategories() {
      return this.$parent.getCategories(this.getCategory.id);
    },
    isDirty() {
      if(!this.category.value) {
        return !!this.category.id;
      }
      return parseInt(this.originalId) !== this.category.id;
    },
    getCategory() {
      return this.category;
    },
    resetCategory() {
      this.originalId = this.getCategory.id;
      this.originalValue = this.getCategory.value;
    },
  },
  methods: {
    updateCategory(categoryId) {
      this.selectedId = parseInt(categoryId);
      this.$emit('change', { ...this.getCategory, category: this.selectedId, dirty: this.isDirty });
    },
    emitSaveCategory() {
      console.log('newId',categoryId);
      console.log('oldId',this.category.id);

      this.$emit('save-category', this.selectedId, this.category.id);
    },
    emitMakeCategoryPrimary() {
      this.$emit('make-category-primary', this.getCategory);
    },
    emitDeleteCategory() {
      this.$emit('delete-category', this.getCategory);
    },
  },
};
</script>
