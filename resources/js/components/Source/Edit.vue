<template>
  <div v-show="editMode" class="mt-3">
    <b-row class="my-1">
      <b-input-group class="mt-2">
        <b-col sm="2">
          <label for="citation">Citation:</label>
        </b-col>
        <b-col sm="10">
          <b-form-input
            v-model="citation"
            :citation="citation"
            type="text"
          ></b-form-input>
        </b-col>
      </b-input-group>
    </b-row>

    <b-row class="my-1">
      <b-input-group class="mt-2">
        <b-col sm="2">
          <label for="url">URL:</label>
        </b-col>
        <b-col sm="10">
          <b-form-input v-model="url" :url="url" type="text"></b-form-input>
        </b-col>
      </b-input-group>
    </b-row>

    <b-row class="my-1">
      <b-input-group class="mt-2">
        <b-col sm="2">
          <label for="found_data">Found Data:</label>
        </b-col>
        <b-col sm="10">
          <b-form-input
            v-model="foundData"
            :foundData="foundData"
            type="text"
          ></b-form-input>
        </b-col>
      </b-input-group>
    </b-row>

    <b-row class="my-1">
      <b-input-group class="mt-2">
        <b-col sm="2">
          <label for="note">Note:</label>
        </b-col>
        <b-col sm="10">
          <b-form-input v-model="note" :note="note" type="text"></b-form-input>
        </b-col>
      </b-input-group>
    </b-row>

    <b-button @click="deleteSource" v-if="hasConceptSourceId" variant="danger" class="float-right"
      ><i class="fa fa-trash"></i> Delete</b-button
    >
    <b-button variant="primary" @click="saveConceptSource()"
      ><i class="fa fa-save"></i> Save</b-button
    >
    <b-button @click="cancelAddSource">Cancel</b-button>
  </div>
</template>

<script>
export default {
  props: {
    conceptId: {
      type: Number,
    },
    conceptSourceId: {
      type: Number,
    },
    canEditVocabulary: false,
    sourceIndex: null,
  },
  mounted() {
    this.getConceptSource();
  },
  computed: {
    hasConceptSourceId() {
      return 'undefined' !== typeof this.conceptSourceId;
    },
  },
  data() {
    return {
      citation: null,
      url: null,
      foundData: null,
      editMode: false,
      note: null,
      isVocabularyEditor: this.canEditVocabulary === true,
      index: this.sourceIndex,
      baseURL: '',
    };
  },
  methods: {
    cancelAddSource: function () {
      if (!this.hasConceptSourceId) {
        this.$emit('delete-source', this.conceptSourceId, this.sourceIndex);
        return;
      }
      this.toggleEditMode();
    },
    getConceptSource: function () {
      if (!this.hasConceptSourceId) {
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
    saveConceptSource: function () {
      let source = {
        concept_id: this.conceptId,
        citation: this.citation,
        url: this.url,
        found_data: this.foundData,
        note: this.note,
      };
      this.$emit('save-source', source, this.conceptSourceId, this.sourceIndex);
      this.toggleEditMode();
    },
    deleteSource: function () {
      if ( !confirm('Are you sure you want to delete this source?') ) {
        return;
      }

      this.$emit('delete-source', this.conceptSourceId, this.sourceIndex);
    },
    toggleEditMode() {
      this.editMode = false;
      this.$emit('toggle-edit-mode');
    }
  },
};
</script>

<style scoped></style>
