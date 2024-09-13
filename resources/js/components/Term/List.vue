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
          @save-term="emitSaveTerm"
          @delete-term="emitDeleteTerm"
          @make-term-preferred="emitMakeTermPreferred"
          @input="emitFlagDirty"
        ></Editable>
      </p>
    </div>
    <b-button
      class="mt-2"
      variant="success"
      @click="emitAddTerm()"
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
    emitSaveTerm: function (term) {
      this.$emit('save-term', term);
    },
    emitAddTerm: function () {
      this.$emit('add-term' );
    },
    emitDeleteTerm: function (term) {
      this.$emit('delete-term', term);
    },
    emitMakeTermPreferred: function(term) {
      this.$emit('make-term-preferred', term);
    },
    emitFlagDirty: function(args) {
      this.$emit('flag-dirty', args);
    },
  },
  components: {
    Editable,
  },
};
</script>
<style>

</style>
