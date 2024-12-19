import ConceptService from '../../../api/ConceptService';

export default {
  methods: {
    async deprecateConcept() {
      console.log('Deprecating concept', this.selectedConcept);
      if (!confirm('This action cannot be undone. Are you sure you want to deprecate?')) {
        return;
      }
      const [error, data] = await ConceptService.deprecateConcept(
        this.conceptId,
        this.selectedConcept.id,
      );

      if (error) {
        console.error('Failed to deprecate concept:', error);
        return;
      }
      this.flashSuccessAlert();
      window.location.reload();
    },
  },
};
