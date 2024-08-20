<template>
  <BInputGroup>
    <BFormInput
      type="text"
      :required="true"
      v-model="term.text"
      @input="updateTerm"
    ></BFormInput>

    <BInputGroupAppend>
      <BButton @click="emitSaveTerm" class="btn btn-info" title="Make Preferred"
        ><i class="fa fa-floppy-o"></i
      ></BButton>
      <BButton
        @click="emitMakeTermPreferred"
        class="btn btn-primary"
        title="Make Preferred"
        ><i class="fa fa-check-square-o"></i
      ></BButton>
      <BButton @click="emitDeleteTerm" class="btn btn-danger" title="Delete"
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
  model: {
    prop: 'term',
    event: 'input',
  },
  props: {
    term: Object,
  },
  components: {
    BInputGroup,
    BInputGroupAppend,
    BFormInput,
    BButton,
  },
  methods: {
    updateTerm(event) {
      this.$emit('input', { ...this.term, text: event.target.value });
    },
    emitSaveTerm() {
      this.$emit('save-term', this.term);
    },
    emitMakeTermPreferred() {
      this.$emit('make-term-preferred', this.term);
    },
    emitDeleteTerm() {
      this.$emit('delete-term', this.term);
    },
  },
};
</script>
