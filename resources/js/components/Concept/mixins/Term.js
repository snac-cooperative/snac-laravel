import termApi from '../../../api/TermService';

export default {
  data() {
    return {
      terms: this.termProps.map(
        (term, index) => {
          term.inEdit = false;
          term.index = index;
          return term;
        },
      ),
      termSearch: [],
      allTermsSearch: false,
    };
  },
  computed: {
    alternateTerms() {
      return this.terms
        .filter((term) => !term.preferred)
        .sort();
    },
    preferredTerm() {
      return this.terms.find((term) => term.preferred);
    },
    hasEmptyTerm() {
      return !!(
        this.terms.length &&
        !this.terms[
          this.terms.length - 1
        ].text
      );
    },
  },
  methods: {
    addTerm() {
      if (this.hasEmptyTerm) {
        return;
      }

      const conceptID = this.terms[0].concept_id;
      const newTerm = {
        concept_id: conceptID,
        id: null,
        preferred: false,
        text: null,
        inEdit: true,
        index: this.terms.length,
      };
      this.terms.push(newTerm);
    },
    async saveTerm(term, termIndex) {
      const finalize = (term, termIndex) => {
        term.inEdit = false;

        if (termIndex > -1) {
          this.terms.splice(termIndex, 1, term);
        }

        this.cleanDirty(term);
        this.flashSuccessAlert();
      };

      if (!term.id) {
        term = await this.createTerm(term);
        finalize(term, termIndex);
        return;
      }

      const [error, response] = await termApi.updateTerm(term.id, term);
      if (!error) {
        finalize(term);
      }
    },
    async createTerm(term) {
      const [error, response] = await termApi.createTerm(term);
      if (!error) {
        return response;
      }
      return term;
    },
    makeTermPreferred(term, termIndex) {
      if (
        !confirm(
          `Are you sure you want to make '${term.text}' the preferred term for this concept?`,
        )
      ) {
        return;
      }

      const currentPreferred = this.preferredTerm;

      if (currentPreferred && currentPreferred.id !== term.id) {
        currentPreferred.preferred = false;
        this.saveTerm(currentPreferred);
      }

      term.preferred = true;
      this.saveTerm(term);

      this.$set(this.terms, termIndex, term);
    },
    async deleteTerm(termId, termText) {
      if (!confirm('Are you sure you want to delete this term?')) {
        return;
      }

      let term = {
        id: termId,
        text: termText,
        concept_id: this.conceptId,
        preferred: false,
      };

      let index = this.terms.findIndex((t) => t.id === termId);
      if (index === -1) {
        index = this.terms.findIndex((t) => t.text === termText);
      }
      if (index > -1) {
        term = this.terms[index];
      }

      const finalize = (term, index) => {
        this.terms.splice(index, 1);
        this.cleanDirty(term);
      };

      if (!termId) {
        finalize(term, index);
        return;
      }

      const [error, response] = await termApi.deleteTerm(termId);
      if (!error) {
        finalize(term, index);
      }
    },
  },
};