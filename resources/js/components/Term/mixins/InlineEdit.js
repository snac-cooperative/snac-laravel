import state from '../../../states/concept';

export default {
  data() {
    return {
      state,
    };
  },
  computed: {
    inlineEdit() {
      return this.inEdit;
    },
  },
  methods: {
    conceptEditMode: function () {
      return this.state.editMode;
    },
    showCancelModal() {
      this.$refs.cancelModal.show();
    },
    hideCancelModal() {
      this.$refs.cancelModal.hide();
    },
    confirmCancel() {
      this.$emit('cancel-inline-edit', this.term, this.termIndex);
      this.text = this.originalText;
      this.resetTerm();
      this.hideCancelModal();
    },
    focusConfirmCancelButton() {
      this.$refs.confirmCancelButton.focus();
    },
    cancelInlineEdit() {
      if (!this.inlineEdit || this.conceptEditMode()) {
        return;
      }
      if (this.isDirty()) {
        this.showCancelModal();
        return;
      }

      this.confirmCancel();
    },
  },
};
