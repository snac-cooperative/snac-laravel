<template>
  <div>
    <div class="mb-3 float-right" v-if="isVocabularyEditor">
      <b-button
        variant="primary"
        @click="toggleEditMode()"
        v-show="!getEditMode()"
        ><i class="fa fa-edit"></i> Edit</b-button
      >
      <b-button variant="secondary" @click="toggleEditMode()" v-show="getEditMode()"
        >Cancel</b-button
      >
    </div>

    <h2>{{ preferredTerm.text }}<span v-if="deprecated">(deprecated)</span></h2>
    <hr />

    <div id="concept-table" v-show="!getEditMode()">
      <div class="form-group">
        <div class="col-xs-8">
          <h4>Preferred Term</h4>
          <p>{{ preferredTerm.text }}</p>

          <h4 v-if="alternateTerms.length" class="mt-3">Alternate Terms</h4>
          <div v-bind:key="term.id" v-for="term in alternateTerms">
            <!-- Extract into Term Component? -->
            <p>{{ term.text }}</p>
            <!-- Extract into Term Component? -->
          </div>

          <div class="mt-3">
            <h4>Concept Sources</h4>
            <div
              class="mt-1"
              :key="source.id"
              v-for="(source, index) in sources"
            >
              <concept-source
                :canEditVocabulary="isVocabularyEditor"
                :concept-id="source.concept_id"
                :concept-source-id="source.id"
                :source-index="index"
              ></concept-source>
            </div>
          </div>
        </div>
      </div>
    </div>

    <concept-edit-form
      id="conceptEditForm"
      v-if="isVocabularyEditor"
      v-show="getEditMode()"
      :concept-props="conceptProps"
      :term-props="terms"
      :sources-props="sources"
      :canEditVocabulary="isVocabularyEditor"
    >
    </concept-edit-form>
  </div>
</template>

<script>
// import TermItem from './TermItem.vue';
import state from '../../states/concept';

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
      state: state,
      // populating terms with our custom temporary variables
      // concept: this.termProps.slice()
      cats: this.conceptProps.concept_categories,
      selectedCategory: this.conceptProps.concept_categories[0].id,
      isVocabularyEditor: this.canEditVocabulary !== 'false',
      baseURL: process.env.MIX_APP_URL,
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
    toggleEditMode: function () {
      this.state.editMode = !this.state.editMode;
    },
    getEditMode: function () {
      return this.state.editMode;
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
