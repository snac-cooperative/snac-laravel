export default {
  computed: {
    inlineEdit() {
      return this.inEdit;
    },
  },
  methods: {
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
      if (this.isDirty()) {
        this.showCancelModal();
      } else {
        this.$emit('cancel-inline-edit', this.term, this.termIndex);
        this.text = this.originalText;
        this.resetTerm();
      }
    },
  },
};
