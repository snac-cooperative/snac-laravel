export default {
  methods: {
    isDirty() {
      return this.state.isDirty.length > 0;
    },
    flagDirty(obj) {
      if (obj.dirty) {
        this.markDirty(obj);
      } else {
        this.cleanDirty(obj);
      }
    },
    markDirty(obj) {
      if (obj.id) {
        for (let i = 0; i < this.state.isDirty.length; i++) {
          if (this.state.isDirty[i].id === obj.id) {
            return;
          }
        }
      } else {
        let prev = obj.previous;
        delete obj.previous;
        delete obj.dirty;

        for (let i = 0; i < this.state.isDirty.length; i++) {
          if (JSON.stringify(this.state.isDirty[i]) === JSON.stringify(prev)) {
            this.state.isDirty[i] = obj;
            return;
          }
        }
      }
      this.state.isDirty[this.state.isDirty.length] = obj;
    },
    cleanDirty(obj) {
      delete obj.previous;
      delete obj.dirty;

      for (let i = 0; i < this.state.isDirty.length; i++) {
        if (this.state.isDirty[i].id && this.state.isDirty[i].id === obj.id) {
          this.state.isDirty.splice(i, 1);
          return;
        } else if (
          JSON.stringify(this.state.isDirty[i]) === JSON.stringify(obj)
        ) {
          this.state.isDirty.splice(i, 1);
          return;
        }
      }
    },
    resetDirty() {
      this.state.isDirty = [];
    },
  },
};
