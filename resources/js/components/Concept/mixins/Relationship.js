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
        { value: 'related', text: 'Related' }
      ],
      isSearching: false
    };
  },

  computed: {
    relationships() {
      return {
        broader: this.concept?.broader || [],
        narrower: this.concept?.narrower || [],
        related: this.concept?.related || []
      };
    }
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
      try {
        const response = await axios.get(`/api/concepts`, {
          params: {
            term: this.searchTerm,
            per_page: 10
          }
        });
        this.searchResults = response.data.data.filter(c => 
          c.id !== this.conceptId && !c.deprecated
        );
      } catch (error) {
        console.error('Search failed:', error);
        this.searchResults = [];
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
        relatedId: this.selectedConcept.id
      };

      const [error, data] = await ConceptService.relateConcept(this.conceptId, relationshipData);
      
      if (error) {
        console.error('Failed to create relationship:', error);
        return;
      }

      this.showRelationshipModal = false;
      this.flashSuccessAlert();
    }
  }
};
