<template>
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
        @click="emitMakeTermPreferred"
        v-if="!isPreferred && termId"
        class="btn"
        title="Make Preferred"
      ><i class="fa fa-check-square-o"></i
      ></BButton>
      <BButton
        @click="emitDeleteTerm"
        v-if="!isPreferred"
        class="btn btn-danger"
        title="Delete"
      ><i class="fa fa-trash"></i
      ></BButton>
    </BInputGroupAppend>
  </BInputGroup>
</template>

<script>
import {
  BButton,
  BFormInput,
  BInputGroup,
  BInputGroupAppend,
} from 'bootstrap-vue';
import termApi from '../../api/TermService';

export default {
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
  components: {
    BInputGroup,
    BInputGroupAppend,
    BFormInput,
    BButton,
  },
  mounted() {
    this.getConceptTerm();
  },
  computed: {
    inlineEdit () {
      return this.inEdit;
    },
  },
  methods: {
    async getConceptTerm () {
      if (!this.termId) {
        this.resetTerm();
        return;
      }

      const [error,term] = await termApi.getTerm(this.termId);
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
    emitMakeTermPreferred() {
      this.$emit('make-term-preferred', this.term, this.termIndex);
    },
    emitDeleteTerm() {
      this.$emit('delete-term', this.termId, this.termIndex);
    },
    resetTerm() {
      this.originalText = this.text;
      this.originalId = this.termId;
    },
    isDirty() {
      if(!this.termId){
        return !!this.text;
      }
      if(this.termId !== this.originalId){
        this.resetTerm();
        return false;
      }
      return this.text !== this.originalText;
    },
    cancelInlineEdit() {
      if(this.isDirty()){
        if(!confirm('Cancelling will cause you to lose your changes. Are you sure you want to cancel?')){
          return;
        }
      }
      this.$emit('cancel-inline-edit', this.term, this.termIndex);
      this.text = this.originalText;
      this.resetTerm();
    }
  },
};
</script>
