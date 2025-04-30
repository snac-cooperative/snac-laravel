import { BButton, BInputGroup, BInputGroupAppend, BModal } from 'bootstrap-vue';
import EditableTerm from '../Term/Editable.vue';
import EditableSource from '../Source/Editable.vue';
import EditableCategory from '../Category/Editable.vue';
import MixinCategory from './mixins/Category';
import MixinDirty from './mixins/Dirty';
import MixinEditMode from './mixins/EditMode';
import MixinSource from './mixins/Source';
import MixinTerm from './mixins/Term';
import MixinRelationship from './mixins/Relationship';
import MixinDeprecate from './mixins/Deprecate';

export default {
  mixins: [
    MixinCategory,
    MixinDirty,
    MixinEditMode,
    MixinSource,
    MixinTerm,
    MixinRelationship,
    MixinDeprecate,
  ],
  components: {
    BModal,
    BButton,
    BInputGroup,
    BInputGroupAppend,
    EditableTerm,
    EditableSource,
    EditableCategory,
  },
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
      isVocabularyEditor: this.canEditVocabulary === 'true',
    };
  },
  methods: {
    alertSuccess() {
      const alert = document.querySelector('.alert-success');
      alert.classList.remove('hidden');
      setTimeout(function () {
        alert.classList.add('hidden');
      }, 3000);
    },
    alertFailure(message) {
      const alert = document.querySelector('.alert-danger');
      alert.classList.remove('hidden');
      alert.textContent = message;
      setTimeout(function () {
        alert.classList.add('hidden');
      }, 3000);
    },
  },
};
