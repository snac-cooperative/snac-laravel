<template>
  <div class="source-list">
    <div v-for="(source,index) in sources" v-bind:key="source.id">
      <Editable
        :concept-id="source.concept_id"
        :concept-source-id="source.id"
        :source-index="index"
        :canEditVocabulary="isVocabularyEditor"
        :in-edit="source.inEdit"
        @save-source="emitSaveSource"
        @delete-source="emitDeleteSource"
        @input="emitFlagDirty"
      ></Editable>
    </div>
    <BButton
      class="mt-2"
      :class="{ 'disabled': hasEmptySource }"
      :disabled="hasEmptySource"
      variant="success"
      @click="emitAddSource()"
      v-if="isVocabularyEditor"
      v-show="conceptEditMode()"
    ><i class="fa fa-plus"></i> Add Source</BButton>
  </div>
</template>

<script>
import { BButton } from 'bootstrap-vue';
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
    sources: {
      type: Array,
    },
    canEditVocabulary: false,
  },
  computed: {
    hasEmptySource () {
      return !!(this.sources.length && !this.sources[
        this.sources.length - 1
      ].id);
    }
  },
  methods: {
    conceptEditMode: function () {
      return this.state.editMode;
    },
    emitSaveSource: function (source, sourceId, index) {
      this.$emit('save-source', source, sourceId, index);
    },
    emitAddSource: function () {
      this.$emit('add-source' );
    },
    emitDeleteSource: function (sourceId, index) {
      this.$emit('delete-source', sourceId, index);
    },
    emitFlagDirty: function(args) {
      this.$emit('flag-dirty', args);
    }
  },
  components: {
    Editable,
  },
};
</script>
<style>
</style>
