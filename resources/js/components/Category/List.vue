<template>
  <div class="category-list">
    <div v-for="(cat,index) in cats" v-bind:key="cat.id">
      <p class="mb-2">
        <span
          v-if="!conceptEditMode()"
          :class="{ 'font-weight-bold': index === 0 }"
        >
          {{ cat.value }}
        </span>
        <Editable
          v-else
          :category="cat"
          :is-primary="0 === index"
          @save-category="saveCategory"
          @change="flagDirty"
        ></Editable>
      </p>
    </div>
    <b-button
      class="mt-2"
      variant="success"
      @click="addCategory()"
      v-if="isVocabularyEditor"
      v-show="conceptEditMode()"
    ><i class="fa fa-plus"></i> Add Category</b-button>
  </div>
</template>

<script>
import Editable from './Editable.vue';
import state from '../../states/concept';

export default {
  data() {
    return {
      isVocabularyEditor: this.canEditVocabulary !== 'false',
      state: state,
      categories: [
        { value: process.env.MIX_ETHNICITY_ID, text: 'Ethnicity' },
        { value: process.env.MIX_OCCUPATION_ID, text: 'Occupation' },
        { value: process.env.MIX_ACTIVITY_ID, text: 'Activity' },
        { value: process.env.MIX_SUBJECT_ID, text: 'Subject' },
        { value: process.env.MIX_RELIGION_ID, text: 'Religion' },
        { value: process.env.MIX_RELATION_ID, text: 'Relation' },
      ],
    };
  },
  props: {
    editing: Boolean,
    conceptId: Number,
    cats: {
      type: Array,
    },
    canEditVocabulary: false,
  },
  methods: {
    conceptEditMode: function () {
      return this.state.editMode;
    },
    saveCategory: function (newCat,oldCat) {
      this.$parent.saveCategory(newCat,oldCat);
    },
    addCategory: function () {
      this.$parent.addCategory();
    },
    flagDirty: function(args) {
      this.$parent.flagDirty(args);
    },
    getCategories: function(selected) {
      return this.categories.filter((cat) => {
        return this.cats.filter((currentCat) => {
          return currentCat.id === parseInt(cat.value);
        }).length === 0 || selected === parseInt(cat.value);
      });
    }
  },
  components: {
    Editable,
  },
};
</script>
<style>
</style>
