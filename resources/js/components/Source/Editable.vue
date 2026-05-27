<template>
  <div
    style="padding: 0.5rem"
    :class="{ stripe: 1 === sourceIndex % 2, 'alert-info': isDirty() }"
  >
    <div v-if="!editMode || !conceptEditMode()">
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
          <BButton size="sm" variant="danger" @click="showDeleteModal"
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
          @click="showDeleteModal"
          v-if="conceptSourceId"
        ><i class="fa fa-trash"></i> Delete</BButton
        >
        <BButton variant="primary" @click="emitSaveSource"
        ><i class="fa fa-save"></i> Save</BButton
        >
        <BButton
          @click="showCancelModal"
        >Cancel</BButton
        >
      </div>
    </div>

    <BModal
      id="delete-confirmation-modal"
      ref="deleteModal"
      title="Confirm Deletion"
      @shown="focusConfirmDeleteButton"
      hide-footer
    >
      <div class="d-block text-center">
        <p>Are you sure you want to delete this source?</p>
        <BButton ref="confirmDeleteButton" variant="danger" @click="confirmDelete">Yes, delete</BButton>
        <BButton variant="secondary" @click="hideDeleteModal">Cancel</BButton>
      </div>
    </BModal>

    <BModal
      id="cancel-confirmation-modal"
      ref="cancelModal"
      title="Confirm Cancel"
      @shown="focusConfirmCancelButton"
      hide-footer
    >
      <div class="d-block text-center">
        <p>Cancelling will cause you to lose your changes. Are you sure you want to cancel?</p>
        <BButton ref="confirmCancelButton" variant="danger" @click="confirmCancel">Yes, cancel</BButton>
        <BButton variant="secondary" @click="hideCancelModal">No</BButton>
      </div>
    </BModal>
  </div>
</template>

<script>
import { BButton, BFormInput, BInputGroup, BModal } from 'bootstrap-vue';
import conceptSourceApi from '../../api/ConceptSourceService';
import state from '../../states/concept';

export default {
  components: {
    BInputGroup,
    BFormInput,
    BButton,
    BModal,
  },
  data() {
    return {
      isVocabularyEditor: this.canEditVocabulary,
      originalSource: {},
      previousSource: {},
      state,
      editMode: this.inEdit,
      citation: null,
      url: null,
      foundData: null,
      note: null,
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
  mounted() {
    this.getConceptSource();
  },
  methods: {
    async getConceptSource() {
      if (!this.conceptSourceId) {
        this.resetSource();
        return;
      }

      const [error,source] = await conceptSourceApi.getConceptSource(this.conceptSourceId);
      if (!error) {
        this.citation = source.citation;
        this.url = source.url;
        this.foundData = source.found_data;
        this.note = source.note;
        this.conceptId = source.concept_id;

        this.resetSource();
      }
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
    showDeleteModal() {
      this.$refs.deleteModal.show();
    },
    hideDeleteModal() {
      this.$refs.deleteModal.hide();
    },
    confirmDelete() {
      this.$emit('delete-source', this.conceptSourceId, this.sourceIndex);
      this.hideDeleteModal();
    },
    focusConfirmDeleteButton() {
      this.$refs.confirmDeleteButton.focus();
    },
    showCancelModal() {
      this.$refs.cancelModal.show();
    },
    hideCancelModal() {
      this.$refs.cancelModal.hide();
    },
    confirmCancel() {
      this.toggleEditMode();
      this.hideCancelModal();

      if (this.conceptSourceId) {
        this.resetSource(this.originalSource);
        this.trackChanges();
        return;
      }

      this.$emit('delete-source', this.conceptSourceId, this.sourceIndex);
    },
    focusConfirmCancelButton() {
      this.$refs.confirmCancelButton.focus();
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
