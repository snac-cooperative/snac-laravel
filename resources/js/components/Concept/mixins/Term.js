import termApi from '../../../api/TermService';

export default {
  data() {
    return {
      terms: this.termProps.map(
        (term, index) => {
          term.index = index;
          if('undefined' === typeof term.inEdit){
            term.inEdit = false;
          }
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
        inEdit: false,
        index: this.terms.length,
      };
      this.terms.push(newTerm);
      this.updateTermIndexes();
    },
    async saveTerm(term, termIndex) {
      const finalize = (term, termIndex) => {
        term.inEdit = false;

        if (termIndex > -1) {
          this.terms.splice(termIndex, 1, term);
        }

        this.cleanDirty(term);
        this.flashSuccessAlert();
        this.updateTermIndexes();
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
      const currentPreferred = this.preferredTerm;

      if (currentPreferred && currentPreferred.id !== term.id) {
        currentPreferred.preferred = false;
        this.saveTerm(currentPreferred).then();
      }

      term.preferred = true;
      this.saveTerm(term).then();

      this.$set(this.terms, termIndex, term);
    },
    async deleteTerm(termId, termText) {
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
        this.updateTermIndexes();
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
    updateTermIndexes() {
      this.terms.forEach((term, index) => {
        term.index = index;
      });
    },
    enableInlineEdit(term, termIndex) {
      if(!this.isVocabularyEditor){
        return;
      }

      term.inEdit = true;
      this.$set(this.terms, termIndex, term);
    },
    cancelInlineEdit(term, termIndex) {
      term.inEdit = false;
      this.$set(this.terms, termIndex, term);
    }
  },
};
