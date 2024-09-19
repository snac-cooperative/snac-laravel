import { BButton, BInputGroup, BInputGroupAppend } from 'bootstrap-vue';
import EditableTerm from '../Term/Editable.vue';
import EditableSource from '../Source/Editable.vue';
import EditableCategory from '../Category/Editable.vue';
import MixinCategory from './mixins/Category';
import MixinDirty from './mixins/Dirty';
import MixinEditMode from './mixins/EditMode';
import MixinSource from './mixins/Source';
import MixinTerm from './mixins/Term';
import src from 'vue-multiselect/src';

export default {
  mixins: [MixinCategory, MixinDirty, MixinEditMode, MixinSource, MixinTerm],
  components: { BButton, BInputGroup, BInputGroupAppend, EditableTerm, EditableSource, EditableCategory },
  props: {
    conceptProps: {
      type: Object,
    },
    termProps: {
      type: Array,
    },
    categoriesProps: {
      type: Array,
    },
    sourcesProps: {
      type: Array,
    },
    canEditVocabulary: false,
  },
  data() {
    return {
      deprecated: this.conceptProps.deprecated,
      conceptId: this.conceptProps.id,
      selected_concept: '',
      relationType: '',
      isVocabularyEditor: this.canEditVocabulary !== 'false',
      baseURL: process.env.MIX_APP_URL,
    };
  },
  computed: {
    src() {
      return src;
    },
  },

  methods: {
    fetchConcept() {
      fetch(`${this.baseURL}/api/concepts/` + this.terms[0].concept_id)
        .then((data) => data.json())
        .then((data) => {
          this.terms = data.terms.map(
            (term) => {
              term.inEdit = false;
              return term;
            },
          );
        });
    },
    flashSuccessAlert() {
      const alert = document.querySelector('.alert-success');
      alert.classList.remove('hidden');
      setTimeout(function () {
        alert.classList.add('hidden');
      }, 3000);
    },
  },
};
