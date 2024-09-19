export default {
  data() {
    return {
      sources: this.sourcesProps.map(
        (source) => {
          source.inEdit = false;
          return source;
        },
      ),
    };
  },
  computed: {
    hasEmptySource() {
      return !!(
        this.sources.length && !this.sources[this.sources.length - 1].id
      );
    },
  },
  methods: {
    addSource() {
      this.sources.push({ concept_id: this.conceptId, inEdit: true });
    },
    updateSources(source, index) {
      this.sources.splice(index, 1, source);
    },
    saveSource(source, sourceId, index) {
      const vm = this;
      if (sourceId) {
        axios
          .patch(`${this.baseURL}/api/concept_sources/${sourceId}`, source)
          .then(function (response) {
            vm.cleanDirty(response.data);
            vm.updateSources(response.data, index);
            vm.flashSuccessAlert();
          })
          .catch(function (error) {
            console.log(error);
          });
      } else {
        axios
          .post(`${this.baseURL}/api/concept_sources`, source)
          .then(function (response) {
            vm.cleanDirty(source);
            vm.updateSources(response.data, index);
            vm.flashSuccessAlert();
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
    deleteSource(sourceId, index) {
      if (!sourceId) {
        this.cleanDirty(this.sources[index]);
        this.sources.splice(index, 1);
        return;
      }

      const vm = this;

      axios
        .delete(`${this.baseURL}/api/concept_sources/${sourceId}`)
        .then(function (response) {
          vm.cleanDirty(vm.sources[index]);
          vm.sources.splice(index, 1);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
