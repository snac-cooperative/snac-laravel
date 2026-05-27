<template>
  <div>
    <multiselect
      v-model="selectedValue"
      :options="languages"
      :close-on-select="true"
      :clear-on-select="false"
      :preserve-search="false"
      placeholder="Language"
      label="name"
      track-by="code"
      :preselect-first="true"
      :allow-empty="false"
      @select="handleSelect"
    >
      <template slot="selection" slot-scope="{ values, search, isOpen }">
      </template>
    </multiselect>
    <!-- Show debugging -->
    <!-- <pre class="language-json"><code>{{ value  }}</code></pre> -->
    <!-- <pre class="language-json"><code>{{ selectedValue  }}</code></pre> -->
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import { languages } from '../config/languages';

export default {
  components: { Multiselect },
  props: {
    value: {
      type: Number,
      required: false,
      default: languages.find((lang) => lang['code'] == 'eng')['id'],
    },
  },
  data() {
    return {
      languages,
      selectedValue: languages.find((lang) => lang['id'] == this?.value),
    };
  },
  methods: {
    handleSelect(selectedOption) {
      this.$emit('language-selected', selectedOption.id);
    },
  },
};
</script>

<!-- Add Multiselect CSS. Can be added as a static asset or inside a component. -->
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style></style>
