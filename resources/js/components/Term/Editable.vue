<template>
  <BInputGroup>
    <BFormInput
      type="text"
      :required="true"
      v-model="term.text"
      @input="updateTerm"
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
        @click="emitMakeTermPreferred"
        v-if="!isPreferred"
        class="btn btn-primary"
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

export default {
  data() {
    return {
      originalId: this.term.id,
      originalText: this.term.text,
      previousText: this.term.text,
    };
  },
  model: {
    prop: 'term',
    event: 'input',
  },
  props: {
    term: Object,
    isPreferred: Boolean,
  },
  components: {
    BInputGroup,
    BInputGroupAppend,
    BFormInput,
    BButton,
  },
  methods: {
    updateTerm(text) {
      this.$emit('input', { ...this.term, text: text, dirty: this.isDirty(), previous: this.previousText });
      this.previousText = text;
    },
    emitSaveTerm() {
      this.$emit('save-term', this.term);
      this.resetTerm();
    },
    emitMakeTermPreferred() {
      this.$emit('make-term-preferred', this.term);
    },
    emitDeleteTerm() {
      this.$emit('delete-term', this.term);
    },
    resetTerm() {
      this.originalId = this.term.id;
      this.originalText = this.term.text;
    },
    isDirty() {
      if(!this.term.id) {
        return !!this.term.text;
      }
      if(this.term.id !== this.originalId){
        this.resetTerm();
        return false;
      }
      return this.term.text !== this.originalText;
    }
  },
};
</script>
