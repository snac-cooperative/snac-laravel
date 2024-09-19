import state from '../../../states/concept';

export default {
  data() {
    return {
      state: state,
    };
  },mounted() {
    document.addEventListener('keydown', this.handleEscapeKey);
  },
  beforeDestroy() {
    document.removeEventListener('keydown', this.handleEscapeKey);
  },
  methods: {
    toggleEditMode() {
      if (this.getEditMode() && this.isDirty()) {
        if (
          !confirm(
            'You have unsaved changes. Are you sure you want to exit Edit Mode?',
          )
        ) {
          return;
        }
        this.resetDirty();
      }

      this.state.editMode = !this.state.editMode;
    },
    getEditMode() {
      return this.state.editMode;
    },
    handleEscapeKey(event) {
      if (event.key === 'Escape' && this.getEditMode()) {
        this.toggleEditMode();
      }
    },
  },
};
