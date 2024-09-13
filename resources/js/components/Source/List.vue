<template>
  <div class="source-list">
    <div v-for="(source,index) in sources" v-bind:key="source.id">
      <Editable
        :source="source"
        :source-index="index"
        :canEditVocabulary="isVocabularyEditor"
        @save-source="emitSaveSource"
        @delete-source="emitDeleteSource"
        @input="emitFlagDirty"
      ></Editable>
    </div>
    <b-button
      class="mt-2"
      :class="{ 'disabled': hasEmptySource() }"
      :disabled="hasEmptySource()"
      variant="success"
      @click="emitAddSource()"
      v-if="isVocabularyEditor"
      v-show="conceptEditMode()"
    ><i class="fa fa-plus"></i> Add Source</b-button>
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
    sources: {
      type: Array,
    },
    canEditVocabulary: false,
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
    },
    hasEmptySource: function () {
      return this.$parent.hasEmptySource;
    }
  },
  components: {
    Editable,
  },
};
</script>
<style>
</style>
