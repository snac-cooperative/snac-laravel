<template>
  <div
    style="padding: 0.5rem"
    :class="{ stripe: 1 === index % 2, 'alert-info': isDirty() }"
  >
    <div v-if="!editMode">
      <div style="display: flex; gap: 0.5rem; align-items: baseline">
        <div style="flex-basis: calc(100% - 0.5rem - 42px)">
          <p class="mb-0" v-if="source.citation">{{ source.citation }}</p>
          <p class="mb-0" v-if="source.url">
            <a :href="source.url">{{ source.url }}</a>
          </p>
          <p class="mb-0" v-if="source.found_data">{{ source.found_data }}</p>
          <p class="mb-0" v-if="source.note">{{ source.note }}</p>
        </div>

        <BButtonGroup
          v-if="isVocabularyEditor"
          v-show="conceptEditMode() && !editMode"
        >
          <BButton size="sm" variant="primary" @click="toggleEditMode()"
            ><i class="fa fa-edit"></i
          ></BButton>
          <BButton size="sm" variant="danger" @click="emitDeleteSource"
            ><i class="fa fa-trash"></i>
          </BButton>
        </BButtonGroup>
      </div>
    </div>
    <div v-else>
      <BInputGroup>
        <BCol sm="2" class="mb-2">
          <label for="citation">Citation:</label>
        </BCol>
        <BCol sm="10" class="mb-2">
          <BFormInput
            type="text"
            v-model="source.citation"
            :citation="source.citation"
            @input="updateSource"
          ></BFormInput>
        </BCol>

        <BCol sm="2" class="mb-2">
          <label for="citation">URL:</label>
        </BCol>
        <BCol sm="10" class="mb-2">
          <BFormInput
            type="url"
            placeholder="https://"
            v-model="source.url"
            :url="source.url"
            @input="updateSource"
          ></BFormInput>
        </BCol>

        <BCol sm="2" class="mb-2">
          <label for="found_data">Found Data:</label>
        </BCol>
        <BCol sm="10" class="mb-2">
          <BFormInput
            type="text"
            v-model="source.found_data"
            :found_data="source.found_data"
            @input="updateSource"
          ></BFormInput>
        </BCol>

        <BCol sm="2">
          <label for="note">Note:</label>
        </BCol>
        <BCol sm="10">
          <BFormInput
            type="text"
            v-model="source.note"
            :note="source.note"
            @input="updateSource"
          ></BFormInput>
        </BCol>
      </BInputGroup>

      <div class="mt-2">
        <BButton
          variant="danger"
          class="float-right"
          @click="emitDeleteSource"
          v-if="hasConceptSourceId"
          ><i class="fa fa-trash"></i> Delete</BButton
        >
        <BButton variant="primary" @click="emitSaveSource"
          ><i class="fa fa-save"></i> Save</BButton
        >
        <BButton
          @click="cancelAddSource"
          v-show="!hasConceptSourceId || isDirty()"
          >Cancel</BButton
        >
      </div>
    </div>
  </div>
</template>

<script>
import {
  BButton,
  BFormInput,
  BInputGroup,
  BCol,
} from 'bootstrap-vue';

import state from '../../states/concept';

export default {
  data() {
    return {
      isVocabularyEditor: this.canEditVocabulary !== 'false',
      originalSource: Object.assign( {}, this.source ),
      previousSource: Object.assign( {}, this.source ),
      state,
      editMode: this.source.inEdit,
      index: this.sourceIndex,
      conceptSourceId: this.source.id,
      conceptId: this.source.concept_id,
    };
  },
  model: {
    prop: 'source',
    event: 'input',
  },
  props: {
    source: {
      type: Object,
    },
    sourceIndex: {
      type: Number,
      default: null,
    },
    canEditVocabulary: false,
  },
  components: {
    BInputGroup,
    BFormInput,
    BButton,
  },
  computed: {
    hasConceptSourceId() {
      return this.source.id;
    },
  },
  methods: {
    conceptEditMode: function () {
      return this.state.editMode;
    },
    updateSource() {
      this.$emit('input', { ...this.source, dirty: this.isDirty(), previous: this.previousSource });
      this.previousSource = Object.assign( {}, this.source );
    },
    cancelAddSource: function () {
      if(this.isDirty()) {
        if(!confirm('Cancelling will cause you to lose your changes. Are you sure you want to cancel?')) {
          return;
        }
      }

      this.toggleEditMode();

      if(this.hasConceptSourceId) {
        return;
      }

      const sourceId = this.hasConceptSourceId ? this.conceptSourceId : null;
      this.$emit('delete-source', sourceId, this.sourceIndex);
    },
    emitSaveSource() {
      this.$emit('save-source', this.source, this.conceptSourceId, this.sourceIndex);
      this.resetSource();
      this.toggleEditMode();
    },
    emitDeleteSource() {
      if ( !confirm('Are you sure you want to delete this source?') ) {
        return;
      }

      this.$emit('delete-source', this.conceptSourceId, this.sourceIndex);
    },
    resetSource() {
      this.originalSource = Object.assign( {}, this.source );
    },
    isDirty() {
      if ( !this.conceptEditMode()) {
        return false;
      }
      return ! this.compare(this.source, this.originalSource);
    },
    compare( primaryObj, secondaryObj ) {
      const keys = Object.keys(primaryObj);

      for (let key of keys) {
        const val1 = primaryObj[key];
        const val2 = secondaryObj[key];

        if (val1 === val2 || !val1 && !val2) {
          continue;
        }
        return false;
      }

      return true;
    },
    toggleEditMode() {
      this.editMode = !this.editMode;
    },
  },
};
</script>
<style>
.stripe:not(.alert-info) {
  background-color: #eee;
}
</style>
