<template>
  <div
    style="padding: 0.5rem"
    :class="{ stripe: 1 === sourceIndex % 2, 'alert-info': isDirty() }"
  >
    <div v-if="!editMode">
      <div style="display: flex; gap: 0.5rem; align-items: baseline">
        <div style="flex-basis: calc(100% - 0.5rem - 42px)">
          <p class="mb-0" v-if="citation">{{ citation }}</p>
          <p class="mb-0" v-if="url">
            <a :href="url">{{ url }}</a>
          </p>
          <p class="mb-0" v-if="foundData">{{ foundData }}</p>
          <p class="mb-0" v-if="note">{{ note }}</p>
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
            v-model="citation"
            @input="trackChanges"
          ></BFormInput>
        </BCol>

        <BCol sm="2" class="mb-2">
          <label for="url">URL:</label>
        </BCol>
        <BCol sm="10" class="mb-2">
          <BFormInput
            type="url"
            placeholder="https://"
            v-model="url"
            @input="trackChanges"
          ></BFormInput>
        </BCol>

        <BCol sm="2" class="mb-2">
          <label for="found_data">Found Data:</label>
        </BCol>
        <BCol sm="10" class="mb-2">
          <BFormInput
            type="text"
            v-model="foundData"
            @input="trackChanges"
          ></BFormInput>
        </BCol>

        <BCol sm="2">
          <label for="note">Note:</label>
        </BCol>
        <BCol sm="10">
          <BFormInput
            type="text"
            v-model="note"
            @input="trackChanges"
          ></BFormInput>
        </BCol>
      </BInputGroup>

      <div class="mt-2">
        <BButton
          variant="danger"
          class="float-right"
          @click="emitDeleteSource"
          v-if="conceptSourceId"
        ><i class="fa fa-trash"></i> Delete</BButton
        >
        <BButton variant="primary" @click="emitSaveSource"
        ><i class="fa fa-save"></i> Save</BButton
        >
        <BButton
          @click="cancelSaveSource"
        >Cancel</BButton
        >
      </div>
    </div>
  </div>
</template>

<script>
import { BButton, BFormInput, BInputGroup } from 'bootstrap-vue';
import state from '../../states/concept';

export default {
  data() {
    return {
      isVocabularyEditor: this.canEditVocabulary !== 'false',
      originalSource: {},
      previousSource: {},
      state,
      editMode: this.inEdit,
      citation: null,
      url: null,
      foundData: null,
      note: null,
      baseURL: process.env.MIX_APP_URL,
    };
  },
  model: {
    event: 'input',
  },
  props: {
    conceptId: {
      type: Number,
      default: null,
    },
    conceptSourceId: {
      type: Number,
      default: null,
    },
    sourceIndex: {
      type: Number,
      default: null,
    },
    inEdit: {
      type: Boolean,
      default: false,
    },
    canEditVocabulary: false,
  },
  components: {
    BInputGroup,
    BFormInput,
    BButton,
  },
  mounted() {
    this.getConceptSource();
  },
  methods: {
    getConceptSource: function () {
      if (!this.conceptSourceId) {
        this.resetSource();
        return;
      }

      fetch(`${this.baseURL}/api/concept_sources/` + this.conceptSourceId)
        .then((data) => data.json())
        .then((data) => {
          this.citation = data.citation;
          this.url = data.url;
          this.foundData = data.found_data;
          this.note = data.note;
          this.conceptId = data.concept_id;

          this.resetSource();
        });
    },
    conceptEditMode: function () {
      return this.state.editMode;
    },
    trackChanges() {
      this.$emit('input', {
        ...this.getSource(),
        dirty: this.isDirty(),
        previous: this.previousSource,
      });
      this.previousSource = this.getSource();
    },
    cancelSaveSource: function () {
      if (this.isDirty()) {
        if (
          !confirm(
            'Cancelling will cause you to lose your changes. Are you sure you want to cancel?',
          )
        ) {
          return;
        }
      }

      this.toggleEditMode();

      if (this.conceptSourceId) {
        this.resetSource(this.originalSource);
        this.trackChanges();
        return;
      }

      this.$emit('delete-source', this.conceptSourceId, this.sourceIndex);
    },
    emitSaveSource() {
      this.$emit(
        'save-source',
        this.getSource(),
        this.conceptSourceId,
        this.sourceIndex,
      );
      this.resetSource();
      this.toggleEditMode();
    },
    emitDeleteSource() {
      if (!confirm('Are you sure you want to delete this source?')) {
        return;
      }

      this.$emit('delete-source', this.conceptSourceId, this.sourceIndex);
    },
    resetSource(to) {
      if (!to) {
        to = this.getSource();
      }

      this.citation = to.citation;
      this.url = to.url;
      this.foundData = to.foundData || to.found_data;
      this.note = to.note;

      this.originalSource = to;
      this.previousSource = to;
    },
    isDirty() {
      if (!this.conceptEditMode()) {
        return false;
      }
      return !this.compare(this.getSource(), this.originalSource);
    },
    getSource() {
      const source = {
        concept_id: this.conceptId,
        citation: this.citation,
        url: this.url,
        found_data: this.foundData,
        note: this.note,
      };

      if ( this.conceptSourceId ) {
        source.id = this.conceptSourceId;
      }

      return source;
    },
    compare(primaryObj, secondaryObj) {
      const keys = Object.keys(primaryObj);

      for (let key of keys) {
        const val1 = primaryObj[key];
        const val2 = secondaryObj[key];

        if (val1 === val2 || (!val1 && !val2)) {
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
.stripe.alert-info {
  background-color: #bdd9df;
}
</style>
