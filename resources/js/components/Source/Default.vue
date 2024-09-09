<template>
  <div>
    <div style="display: flex; gap: 0.5rem; align-items: baseline;">
      <b-button
        variant="primary"
        @click="toggleEditMode()"
        v-if="isVocabularyEditor"
        v-show="conceptEditMode() && !editMode"
      ><i class="fa fa-edit"></i> Edit Source</b-button>

      <div v-show="!editMode">
        <p class="mb-0" v-if="citation">{{ citation }}</p>
        <a :href="url" v-if="url">{{ url }}</a>
        <p class="mb-0" v-if="foundData">{{ foundData }}</p>
        <p class="mb-0" v-if="note">{{ note }}</p>
      </div>
    </div>

    <concept-source-edit
      v-if="isVocabularyEditor"
      v-show="editMode"
      :canEditVocabulary="isVocabularyEditor"
      :concept-id="conceptId"
      :concept-source-id="conceptSourceId"
      :source-index="index"
    ></concept-source-edit>
  </div>
</template>

<script>
import state from '../../states/concept';

export default {
  props: {
    conceptId: {
      type: Number,
    },
    conceptSourceId: {
      type: Number,
    },
    sourceEditMode: {
      type: Boolean,
      default: false,
    },
    canEditVocabulary: false,
    sourceIndex: null,
  },
  mounted() {
    this.getConceptSource();
  },
  data() {
    return {
      citation: null,
      url: null,
      foundData: null,
      note: null,
      editMode: this.sourceEditMode || false,
      isVocabularyEditor: this.canEditVocabulary === true,
      index: this.sourceIndex,
      baseURL: '',
      state: state,
    };
  },
  methods: {
    getConceptSource: function () {
      if (!this.conceptSourceId) {
        return;
      }

      fetch(`${this.baseURL}/api/concept_sources/` + this.conceptSourceId)
        .then((data) => data.json())
        .then((data) => {
          this.citation = data.citation;
          this.url = data.url;
          this.foundData = data.found_data;
          this.note = data.note;
        });
    },
    toggleEditMode: function () {
      this.editMode = !this.editMode;
    },
    conceptEditMode: function () {
      return this.state.editMode;
    }
  },
};
</script>

<style scoped></style>
