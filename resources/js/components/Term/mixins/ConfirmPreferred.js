export default {
  methods: {
    showPreferredModal() {
      this.$refs.preferredModal.show();
    },
    hidePreferredModal() {
      this.$refs.preferredModal.hide();
    },
    confirmPreferred() {
      this.$emit('make-term-preferred', this.term, this.termIndex);
      this.hidePreferredModal();
    },
    focusConfirmPreferredButton() {
      this.$refs.confirmPreferredButton.focus();
    },
  },
};
