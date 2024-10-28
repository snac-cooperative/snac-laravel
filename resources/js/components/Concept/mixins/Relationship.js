import ConceptService from '../../../api/ConceptService';

export default {
  data() {
    return {
      showRelationshipModal: false,
      searchTerm: '',
      searchResults: [],
      selectedConcept: null,
      relationshipType: null,
      relationshipTypes: [
        { value: 'broader', text: 'Broader' },
        { value: 'narrower', text: 'Narrower' },
        { value: 'related', text: 'Related' },
      ],
      isSearching: false,
    };
  },

  computed: {
    relationships() {
      return {
        broader: this.conceptProps?.broader || [],
        narrower: this.conceptProps?.narrower || [],
        related: this.conceptProps?.related || [],
      };
    },
  },

  methods: {
    showAddRelationship() {
      this.showRelationshipModal = true;
      this.searchTerm = '';
      this.searchResults = [];
      this.selectedConcept = null;
      this.relationshipType = null;
    },

    async searchConcepts() {
      if (this.searchTerm.length < 2) {
        this.searchResults = [];
        return;
      }

      this.isSearching = true;
      const [error, response] = await ConceptService.searchConcepts(
        this.searchTerm,
      );

      if (error) {
        console.error('Search failed:', error);
        this.searchResults = [];
      } else {
        // Filter out current concept and deprecated concepts
        this.searchResults = response.data.filter(
          (c) => c.id !== this.conceptId && !c.deprecated,
        );
      }

      this.isSearching = false;
    },

    selectConcept(concept) {
      this.selectedConcept = concept;
    },

    async saveRelationship() {
      if (!this.selectedConcept || !this.relationshipType) return;

      const relationshipData = {
        type: this.relationshipType,
        relatedId: this.selectedConcept.id,
      };

      const [error, data] = await ConceptService.relateConcept(
        this.conceptId,
        relationshipData,
      );

      if (error) {
        console.error('Failed to create relationship:', error);
        return;
      }

      this.concept.broader = data.broader;

      console.log(data);

      this.showRelationshipModal = false;
      this.flashSuccessAlert();
    },
  },
};
