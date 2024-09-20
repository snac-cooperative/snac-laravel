<template>
  <div class="term-list">
    <div
      v-for="term in terms"
      v-bind:key="term.id"
      v-bind:text="term.text"
      v-bind:index="term.index"
    >
      <p class="mb-2">
        <EditableTerm
          v-if="conceptEditMode() || term.inEdit"
          ref="EditableTerm"
          :term-id="term.id"
          :term-text="term.text"
          :term-index="term.index"
          :concept-id="term.concept_id"
          :in-edit="term.inEdit"
          @save-term="emitSaveTerm"
          @delete-term="emitDeleteTerm"
          @make-term-preferred="emitMakeTermPreferred"
          @cancel-inline-edit="cancelInlineEdit"
          @input="emitFlagDirty"
        ></EditableTerm>
        <span
          v-else
          class="block"
          @dblclick="enableInlineEdit(term, term.index)"
        >
          {{ term.text }}
        </span>
      </p>
    </div>
    <b-button
      class="mt-2"
      :class="{ disabled: hasEmptyTerm }"
      :disabled="hasEmptyTerm"
      variant="success"
      @click="emitAddTerm()"
      v-if="isVocabularyEditor"
      v-show="conceptEditMode()"
    ><i class="fa fa-plus"></i> Add Term</b-button>
  </div>
</template>

<script>
import EditableTerm from './Editable.vue';
import state from '../../states/concept';

export default {
  data() {
    return {
      isVocabularyEditor: this.canEditVocabulary,
      state: state,
    };
  },
  props: {
    conceptId: {
      type: Number,
      default: null,
    },
    terms: {
      type: Array,
    },
    canEditVocabulary: {
      type: Boolean,
      default: false,
    },
    hasEmptyTerm: {
      type: Boolean,
      default: false,
    }
  },
  methods: {
    conceptEditMode: function () {
      return this.state.editMode;
    },
    emitSaveTerm: function (term, termIndex) {
      this.$emit('save-term', term, termIndex);
    },
    emitAddTerm: function () {
      this.$emit('add-term');
      this.$nextTick(() => {
        this.$refs.EditableTerm[this.$refs.EditableTerm.length - 1].$refs.termText.$el.focus();
      });
    },
    emitDeleteTerm: function (termId, termIndex) {
      this.$emit('delete-term', termId, termIndex);
    },
    emitMakeTermPreferred: function(term, termIndex) {
      this.$emit('make-term-preferred', term, termIndex);
    },
    emitFlagDirty: function(args) {
      this.$emit('flag-dirty', args);
    },
    enableInlineEdit: function(term, termIndex) {
      this.$emit('enable-inline-edit', term, termIndex);
    },
    cancelInlineEdit: function(term, termIndex) {
      this.$emit('cancel-inline-edit', term, termIndex);
    }
  },
  components: {
    EditableTerm,
  },
};
</script>
<style>

</style>
