<template>
  <div>
    <div v-for="term in terms" v-bind:key="term.id">
      <p v-if="!editing">{{ term.text }}</p>
      <Editable v-else :term="term"></Editable>
    </div>
  </div>
</template>

<script>
import Editable from './Editable.vue';

export default {
  data() {
    return {};
  },
  props: {
    editing: Boolean,
    conceptId: Number,
    terms: {
      type: Array,
    },
  },
  components: {
    Editable,
  },
};
</script>
