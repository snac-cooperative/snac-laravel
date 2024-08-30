<template>
  <div class="term-list">
    <div v-for="term in terms" v-bind:key="term.id">
      <p class="mb-2">
        <span v-if="!conceptEditMode()">
          {{ term.text }}
        </span>
        <Editable
          v-else
          :term="term"
          @save-term="saveTerm"
          @delete-term="deleteTerm"
          @input="flagDirty"
        ></Editable>
      </p>
    </div>
    <b-button
      class="mt-2"
      variant="success"
      @click="addTerm()"
      v-if="isVocabularyEditor"
      v-show="conceptEditMode()"
    ><i class="fa fa-plus"></i> Add Term</b-button>
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
    };
  },
  props: {
    editing: Boolean,
    conceptId: Number,
    terms: {
      type: Array,
    },
    canEditVocabulary: false,
  },
  methods: {
    conceptEditMode: function () {
      return this.state.editMode;
    },
    saveTerm: function (term) {
      this.$parent.saveTerm(term);
    },
    addTerm: function () {
      this.$parent.addTerm();
    },
    deleteTerm: function (term) {
      this.$parent.deleteTerm(term);
    },
    flagDirty: function(args) {
      this.$parent.flagDirty(args);
    },
  },
  components: {
    Editable,
  },
};
</script>
<style>

</style>
