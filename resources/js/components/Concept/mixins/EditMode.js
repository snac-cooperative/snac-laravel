import state from '../../../states/concept';

export default {
  data() {
    return {
      state: state,
    };
  },
  mounted() {
    document.addEventListener('keydown', this.handleEscapeKey);
  },
  beforeDestroy() {
    document.removeEventListener('keydown', this.handleEscapeKey);
  },
  methods: {
    leaveEditMode() {
      if (this.getEditMode() && this.isDirty()) {
        this.showExitModal();
        return;
      }
      this.toggleEditMode();
    },
    toggleEditMode() {
      this.state.editMode = !this.state.editMode;
    },
    getEditMode() {
      return this.state.editMode;
    },
    handleEscapeKey(event) {
      if (event.key === 'Escape' && this.getEditMode()) {
        this.leaveEditMode();
      }
    },
    showExitModal() {
      this.$refs.exitModal.show();
    },
    hideExitModal() {
      this.$refs.exitModal.hide();
    },
    confirmExit() {
      this.hideExitModal();
      this.resetDirty();
      this.toggleEditMode();
    },
    focusConfirmExitButton() {
      this.$refs.confirmExitButton.focus();
    },
  },
};
