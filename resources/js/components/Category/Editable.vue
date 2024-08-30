<template>
  <BInputGroup>
    <BFormSelect
      v-model="category.id"
      @input="updateCategory"
      :options="getCategories()"
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
      originalCat: this.category.id,
      isDirty: false,
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
  methods: {
    updateCategory(category) {
      // this.isDirty = parseInt( category ) !== parseInt( this.originalCat );
      this.$emit('input', { ...this.category, category: category, dirty: this.isDirty });
    },
    emitSaveCategory() {
      this.$emit('save-category', this.category);
    },
    emitMakeCategoryPrimary() {
      this.$emit('make-category-primary', this.category);
    },
    emitDeleteCategory() {
      this.$emit('delete-category', this.category);
    },
    getCategories() {
      return this.$parent.getCategories(this.category.id);
    }
  },
};
</script>
