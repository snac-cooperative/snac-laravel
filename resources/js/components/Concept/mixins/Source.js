import sourceApi from '../../../api/ConceptSourceService';

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
    async saveSource(source, sourceId, index) {
      if (sourceId) {
        const [error,response] = await sourceApi.updateConceptSource(sourceId, source);
        if(!error){
          this.cleanDirty(response);
          this.updateSources(response, index);
          this.flashSuccessAlert();
        }
      } else {
        const [error,response] = await sourceApi.createConceptSource(source);
        if(!error){
          this.cleanDirty(source);
          this.updateSources(response, index);
          this.flashSuccessAlert();
        }
      }
    },
    async deleteSource(sourceId, index) {
      if (!sourceId) {
        this.cleanDirty(this.sources[index]);
        this.sources.splice(index, 1);
        return;
      }

      const [error,response] = await sourceApi.deleteConceptSource(sourceId);
      if(!error){
        this.cleanDirty(this.sources[index]);
        this.sources.splice(index, 1);
      }
    },
  },
};
