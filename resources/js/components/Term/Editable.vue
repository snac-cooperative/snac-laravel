<template>
  <div>
    <BInputGroup>
      <BFormInput
        type="text"
        ref="termText"
        :required="true"
        v-model="text"
        @input="trackChanges"
        @keydown.enter="emitSaveTerm"
        :class="{ 'alert-info': isDirty() }"
      ></BFormInput>

      <BInputGroupAppend>
        <BButton
          @click="emitSaveTerm"
          class="btn btn-info"
          title="Save"
          v-show="isDirty()"
        ><i class="fa fa-floppy-o"></i
        ></BButton>
        <BButton
          @click="cancelInlineEdit"
          v-if="inlineEdit"
        ><i class="fa fa-ban"></i></BButton>
        <BButton
          variant="primary"
          @click="showPreferredModal"
          v-if="!isPreferred && termId"
          class="btn"
          title="Make Preferred"
        ><i class="fa fa-check-square-o"></i
        ></BButton>
        <BButton
          @click="showDeleteModal"
          v-if="!isPreferred"
          class="btn btn-danger"
          title="Delete"
        ><i class="fa fa-trash"></i
        ></BButton>
      </BInputGroupAppend>
    </BInputGroup>

    <BModal
      id="delete-confirmation-modal"
      ref="deleteModal"
      title="Confirm Deletion"
      @hide="resetTerm"
      @shown="focusConfirmDeleteButton"
      hide-footer
    >
      <div class="d-block text-center">
        <p>Are you sure you want to delete this term?</p>
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

    <BModal
      id="preferred-confirmation-modal"
      ref="preferredModal"
      title="Confirm Preferred Term"
      @shown="focusConfirmPreferredButton"
      hide-footer
    >
      <div class="d-block text-center">
        <p>Are you sure you want to make this term the preferred term for this concept?</p>
        <BButton ref="confirmPreferredButton" variant="primary" @click="confirmPreferred">Yes, make preferred</BButton>
        <BButton variant="secondary" @click="hidePreferredModal">Cancel</BButton>
      </div>
    </BModal>
  </div>
</template>

<script>
import {
  BButton,
  BFormInput,
  BInputGroup,
  BInputGroupAppend,
  BModal,
} from 'bootstrap-vue';
import InlineEdit from './mixins/InlineEdit';
import ConfirmDelete from './mixins/ConfirmDelete';
import ConfirmPreferred from './mixins/ConfirmPreferred';
import termApi from '../../api/TermService';

export default {
  mixins: [InlineEdit, ConfirmDelete, ConfirmPreferred],
  components: {
    BButton,
    BFormInput,
    BInputGroup,
    BInputGroupAppend,
    BModal,
  },
  data() {
    return {
      term: null,
      text: this.termText,
      originalId: this.termId,
      originalText: this.termText,
      previous: this.termText,
    };
  },
  model: {
    event: 'input',
  },
  props: {
    termId: {
      type: Number,
      default: null,
    },
    termText: {
      type: String,
      default: '',
    },
    conceptId: {
      type: Number,
      default: null,
    },
    isPreferred: {
      type: Boolean,
      default: false,
    },
    termIndex: {
      type: Number,
      default: null,
    },
    inEdit: {
      type: Boolean,
      default: false,
    },
  },
  mounted() {
    this.getConceptTerm();
  },
  methods: {
    async getConceptTerm () {
      if (!this.termId) {
        this.resetTerm();
        return;
      }

      const [error, term] = await termApi.getTerm(this.termId);
      if(term) {
        this.term = { ...term, inEdit: false };
        this.text = term.text;
        this.originalText = term.text;
        this.previous = term.text;
      }
    },
    trackChanges(text) {
      this.$emit('input', { ...this.term, text, dirty: this.isDirty(), previous: this.previous });
      this.previous = text;
    },
    emitSaveTerm() {
      if(!this.isDirty()){
        return;
      }
      const term = {
        ...this.term,
        text: this.text,
        preferred: this.isPreferred,
        concept_id: this.conceptId,
      };
      this.$emit('save-term', term, this.termIndex);
      this.resetTerm();
    },
    resetTerm() {
      this.originalText = this.text;
      this.originalId = this.termId;
    },
    isDirty() {
      if(!this.termId){
        return !!this.text;
      }
      if(this.termId !== this.originalId) {
        this.resetTerm();
        return false;
      }
      return this.text !== this.originalText;
    },
  },
};
</script>
