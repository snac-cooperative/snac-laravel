export default {
  methods: {
    showDeleteModal() {
      this.$refs.deleteModal.show();
    },
    hideDeleteModal() {
      this.$refs.deleteModal.hide();
    },
    confirmDelete() {
      this.$emit('delete-term', this.termId, this.termIndex);
      this.hideDeleteModal();
    },
    focusConfirmDeleteButton() {
      this.$refs.confirmDeleteButton.focus();
    },
  },
};
