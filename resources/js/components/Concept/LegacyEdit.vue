<template>
  <div id="concept-table">
    <div class="mt-3">
      <b-button
        v-if="isVocabularyEditor"
        v-b-modal.concept-relations-search
        variant="info"
        ><i class="fa fa-plus"></i> Add Relationship</b-button
      >
    </div>

    <b-modal
      id="concept-relations-search"
      title="Concept Relations"
      size="xl"
      @ok="relateConcept()"
    >
      <!-- TODO: extract concept search form into ConceptSearch.vue-->
      <!-- ok-title="Create Relationship" -->
      <form
        id="concept-relationship-form"
        @submit.stop.prevent="searchConcept()"
      >
        <div class="form-group">
          <label for="relation-search">Related Concept</label>
          <div class="input-group mb-3">
            <input
              id="relation-search"
              ref="searchQuery"
              type="text"
              class="form-control"
              placeholder="Related Concept"
              aria-label="Related Concept"
            />
            <div class="input-group-append">
              <button
                class="btn btn-info"
                type="button"
                @click="searchConcept()"
              >
                Search
              </button>
            </div>
          </div>
        </div>
        <div class="form-check">
          <input
            type="checkbox"
            class="form-check-input"
            id="is-preferred"
            v-model="allTermsSearch"
            title="Search only Preferred Terms"
          />
          <label class="form-check-label" for="is-preferred"
            >Search non-preferred terms</label
          >
        </div>

        <h4 class="mt-4">Relation Type</h4>
        <div class="form-check">
          <input
            class="form-check-input"
            v-model="relationType"
            type="radio"
            name="relation-type"
            value="broader"
          />
          <label class="form-check-label" for="broader-relation-check">
            Broader
          </label>
        </div>
        <div class="form-check">
          <input
            class="form-check-input"
            v-model="relationType"
            type="radio"
            name="relation-type"
            value="narrower"
          />
          <label class="form-check-label" for="narrower-relation-check">
            Narrower
          </label>
        </div>
        <div class="form-check">
          <input
            class="form-check-input"
            v-model="relationType"
            type="radio"
            name="relation-type"
            value="related"
          />
          <label class="form-check-label" for="broader-relation-check">
            Related
          </label>
        </div>
        <div class="">
          <table class="table table-hover mt-3" v-if="termSearch.length">
            <thead>
              <tr>
                <th></th>
                <th>Term</th>
                <th>Category</th>
              </tr>
            </thead>
            <tbody>
              <tr :key="term.term_id" v-for="term in termSearch">
                <td>
                  <input
                    type="radio"
                    name="relation-choice"
                    :value="term.concept_id"
                    v-model="selected_concept"
                  />
                </td>
                <td>
                  <a :href="term.concept_id">{{ term.term }}</a>
                </td>
                <td>{{ term.category }}</td>
                <!-- <td>{{ term.preferred }}</td> -->
                <!-- TODO: Handle multiple categories by conjoining.  -->
                <!-- TODO: Display result count.  -->
              </tr>
            </tbody>
          </table>
        </div>
        <b-button
          @click="relateConcept()"
          class="btn btn-info"
          title="Make Preferred"
          >Relate Concepts <i class="fa fa-floppy-o"></i
        ></b-button>
      </form>
    </b-modal>

    <div class="mt-3" v-show="devFeatures">
      <b-button
        v-if="isVocabularyEditor && !deprecated"
        v-b-modal.concept-deprecation-to-search
        variant="danger"
        ><i class="fa fa-trash"></i> Deprecate Concept</b-button
      >
    </div>

    <b-modal
      id="concept-deprecation-to-search"
      title="Concept Deprecation"
      size="xl"
      @ok="deprecateConcept()"
      ref="deprecate-modal"
    >
      <!-- ok-title="Create Relationship" -->
      <!-- TODO: Rename this form to fix collision -->
      <form
        id="concept-relationship-form"
        @submit.stop.prevent="searchConcept()"
      >
        <div class="form-group">
          <label for="relation-search"
            >Optional - Search and select the concept that replaces
            {{ preferredTerm.text }}</label
          >
          <div class="input-group mb-3">
            <input
              id="relation-search"
              ref="searchQuery"
              type="text"
              class="form-control"
              placeholder="Concept"
              aria-label="Concept"
            />
            <div class="input-group-append">
              <button
                class="btn btn-info"
                type="button"
                @click="searchConcept()"
              >
                Search
              </button>
            </div>
          </div>
        </div>
        <div class="form-check">
          <input
            type="checkbox"
            class="form-check-input"
            id="is-preferred"
            v-model="allTermsSearch"
            title="Search only Preferred Terms"
          />
          <label class="form-check-label" for="is-preferred"
            >Search non-preferred terms</label
          >
        </div>

        <div class="">
          <table class="table table-hover mt-3" v-if="termSearch.length">
            <thead>
              <tr>
                <th></th>
                <th>Term</th>
                <th>Category</th>
              </tr>
            </thead>
            <tbody>
              <tr :key="term.term_id" v-for="term in termSearch">
                <td>
                  <input
                    type="radio"
                    :id="term.concept_id"
                    name="relation-choice"
                    :value="term.concept_id"
                    v-model="selected_concept"
                  />
                </td>
                <td>
                  <label :for="term.concept_id">{{ term.term }}</label>
                  <a target="_blank" :href="term.concept_id"
                    ><i class="fa fa-external-link"></i
                  ></a>
                </td>
                <td>{{ term.category }}</td>
                <!-- <td>{{ term.preferred }}</td> -->
                <!-- TODO: Handle multiple categories by conjoining.  -->
                <!-- TODO: Display result count.  -->
              </tr>
            </tbody>
          </table>
        </div>
        <b-button
          @click="deprecateConcept()"
          class="btn btn-info"
          title="Make Preferred"
          >Deprecate Concept <i class="fa fa-floppy-o"></i
        ></b-button>
      </form>
    </b-modal>
  </div>
</template>

<script>
// import TermItem from './TermItem.vue';
import { categories } from '../../config/categories';

export default {
  props: {
    conceptProps: {
      type: Object,
    },
    termProps: {
      type: Array,
    },
    sourcesProps: {
      type: Array,
    },
    canEditVocabulary: false,
  },
  data() {
    return {
      deprecated: this.conceptProps.deprecated,
      // Do we need to make a copy of termProps with slice() or [...this.termProps]?
      terms: this.termProps.map(
        // populating terms with our custom temporary variables
        (term) => {
          term.inEdit = false;
          return term;
        },
      ),
      sources: this.sourcesProps.map(
        // populating terms with our custom temporary variables
        (source) => {
          source.inEdit = false;
          return source;
        },
      ),
      // concept: this.termProps.slice()
      conceptId: this.conceptProps.id,
      termSearch: [],
      allTermsSearch: false,
      selected_concept: '',
      relationType: '',
      editMode: false,
      // populating terms with our custom temporary variables
      // concept: this.termProps.slice()
      categories,
      cats: this.conceptProps.concept_categories,
      selectedCategory: this.conceptProps.concept_categories[0].id,
      isVocabularyEditor: this.canEditVocabulary === 'true',
      baseURL: '',
      devFeatures: process.env.MIX_INCLUDE_DEVELOPMENT_FEATURES == 'true',
    };
  },
  computed: {
    alternateTerms() {
      return this.terms
        .map((term) => {
          term.inEdit = false;
          return term;
        })
        .filter((term) => !term.preferred)
        .sort();
    },
    preferredTerm() {
      return this.terms.find((term) => term.preferred);
    },
  },
  created() {
    console.log('Concept component loaded');
    console.log(this.terms);
    console.log('hello: ');
    console.log(this.conceptProps.concept_categories[0].value);
  },
  methods: {
    fetchConcept: function () {
      fetch(`${this.baseURL}/api/concepts/` + this.terms[0].concept_id)
        .then((data) => data.json())
        .then((data) => {
          console.log('here you are: ', data);
          this.terms = data.terms.map(
            // populating terms with our custom temporary variables
            (term) => {
              term.inEdit = false;
              return term;
            },
          );
        });
    },
    editTerm: function (term) {
      console.log(`Editing ${term.text} with id ${term.id}`);

      term.inEdit = true;
    },
    saveTerm: function (term) {
      console.log(`Saving ${term.text} with id ${term.id}`);
      if (!term.id) {
        this.postTerm(term);
        // TODO: prevent a double-click from posting twice
      } else {
        axios
          .patch(`${this.baseURL}/api/terms/${term.id}`, term)
          .then(function (response) {
            term.inEdit = false;
            // vm.fetchConcept();    // Do we want to reload full concept after each save? Maybe not, if that would reset other unsaved fields...
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
    addTerm: function () {
      if (!this.terms[this.terms.length - 1].text) {
        return;
      }

      const conceptID = this.terms[0].concept_id;
      const newTerm = {
        concept_id: conceptID,
        id: null,
        language_id: null,
        preferred: false,
        text: null,
        // TODO: Find out how to add new terms without resetting the terms state.
        inEdit: true,
      };
      this.terms.push(newTerm);
    },
    searchConcept: function () {
      let query = this.$refs.searchQuery.value; // Is there a better way to do this?
      if (this.allTermsSearch) {
        query += '&all_terms';
      }

      const promise = axios.get(`search?term=${query}`);
      promise.then((response) => {
        const terms = response.data;
        const terms_result = terms.map((term) => {
          return {
            id: term.term_id,
            concept_id: term.concept_id,
            term: term.text,
            category: term.category,
            preferred: term.preferred,
          };
        });
        this.totalRows = response.data.total;
        this.termSearch = terms_result || [];
      });
    },
    relateConcept: function () {
      const concept_id = this.terms[0].concept_id;
      const relation_type = this.relationType;

      if (!this.selected_concept || relation_type === undefined) {
        return;
      }

      axios
        .put(
          `${this.baseURL}/api/concepts/${concept_id}/relate_concept?related_id=${this.selected_concept}&relation_type=${relation_type}`,
        )
        .then(function (response) {
          console.log('related!', response);
          location.reload();
        })
        .catch(function (error) {
          console.log(error);
        });
      this.selected_concept = '';
    },
    getConcepts: function () {
      const promise = axios.get(`${this.baseURL}/search?term=teach`);
      promise.then((response) => {
        const terms = response.data;
        const terms_result = terms.map((term) => {
          return {
            id: term.concept_id,
            link: '/concepts/' + term.concept_id,
            term: term.text,
            category: term.category,
            preferred: term.preferred,
          };
        });
        this.totalRows = response.data.total;
        this.termSearch = terms_result || [];
      });
    },
    deprecateConcept: function () {
      const concept_id = this.terms[0].concept_id;
      const vm = this;
      let url = `${this.baseURL}/api/concepts/${concept_id}/deprecate`;
      if (this.selected_concept) {
        url += `?to=${this.selected_concept}`;
      }
      axios
        .put(url)
        .then(function (response) {
          console.log('deprecated!', response);
          vm.deprecated = response.data;
          vm.$refs['deprecate-modal'].hide();
        })
        .catch(function (error) {
          console.log(error);
        });
      this.selected_concept = '';
    },
    addSource: function () {
      this.sources.push({ concept_id: this.conceptId, editMode: true });
    },
    updateSource: function (source, index) {
      Vue.set(this.sources, index, source);
    },
    toggleEditMode: function () {
      this.editMode = !this.editMode;
    },
  },
};
</script>

<style scoped>
b-input-group {
  min-width: 500px;
  margin-bottom: 50px;
}

/* Find why input needs this, fix */
.input-group-btn button {
  margin-top: -4px;
}
</style>
