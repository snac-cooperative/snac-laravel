<template>
  <div>
    <div class="alert alert-success hidden" role="alert">
      Your changes have been saved.
    </div>
    <div class="mb-3 float-right" v-if="isVocabularyEditor">
      <b-button
        variant="primary"
        @click="toggleEditMode()"
        v-show="!getEditMode()"
        ><i class="fa fa-edit"></i> Edit</b-button
      >
      <b-button
        variant="secondary"
        @click="toggleEditMode()"
        v-show="getEditMode()"
        >Done Editing</b-button
      >
    </div>

    <h2>{{ preferredTerm.text }}<span v-if="deprecated">(deprecated)</span></h2>
    <hr />

    <div id="concept-table">
      <div class="form-group">
        <div class="col-xs-8">
          <h4>Preferred Term</h4>
          <p v-if="!getEditMode()">{{ preferredTerm.text }}</p>
          <Editable
            v-else
            :term="preferredTerm"
            is-preferred="is-preferred"
            @save-term="saveTerm"
            @input="flagDirty"
          ></Editable>

          <h4 class="mt-3" v-show="alternateTerms.length || getEditMode()">Alternate Terms</h4>

          <term-list
            :terms="alternateTerms"
            :canEditVocabulary="isVocabularyEditor"
          ></term-list>
        </div>
      </div>

      <div class="my-3" v-if="sources.length || getEditMode()">
        <h4>Concept Sources</h4>
        <div class="mt-1" :key="source.id" v-for="(source, index) in sources">
          <concept-source
            :canEditVocabulary="isVocabularyEditor"
            :concept-id="source.concept_id"
            :concept-source-id="source.id"
            :source-index="index"
          ></concept-source>
        </div>
      </div>

      <div class="my-3" v-if="cats.length || getEditMode()">
        <h4>Categories</h4>

        <category-list
          :cats="cats"
          :canEditVocabulary="isVocabularyEditor"
        ></category-list>
      </div>
    </div>

<!--    <concept-edit-->
<!--      id="conceptEdit"-->
<!--      v-if="isVocabularyEditor"-->
<!--      v-show="getEditMode()"-->
<!--      :concept-props="conceptProps"-->
<!--      :term-props="terms"-->
<!--      :sources-props="sources"-->
<!--      :canEditVocabulary="isVocabularyEditor"-->
<!--    >-->
<!--    </concept-edit>-->
  </div>
</template>

<script>
// import TermItem from './TermItem.vue';
import state from '../../states/concept';
import Editable from '../Term/Editable.vue';

export default {
  components: { Editable },
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
      categories: [
        { value: process.env.MIX_ETHNICITY_ID, text: 'Ethnicity' },
        { value: process.env.MIX_OCCUPATION_ID, text: 'Occupation' },
        { value: process.env.MIX_ACTIVITY_ID, text: 'Activity' },
        { value: process.env.MIX_SUBJECT_ID, text: 'Subject' },
        { value: process.env.MIX_RELIGION_ID, text: 'Religion' },
        { value: process.env.MIX_RELATION_ID, text: 'Relation' },
      ],
      cats: this.conceptProps.concept_categories,
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
    saveTerm: function (term) {
      console.log(`Saving ${term.text} with id ${term.id}`);
      const vm = this;
      if (!term.id) {
        this.postTerm(term);
        vm.cleanDirty(term);
        // TODO: prevent a double-click from posting twice
      } else {
        axios
          .patch(`${this.baseURL}/api/terms/${term.id}`, term)
          .then(function (response) {
            term.inEdit = false;
            vm.cleanDirty(term);
            vm.flashSuccessAlert();
            // vm.fetchConcept();    // Do we want to reload full concept after each save? Maybe not, if that would reset other unsaved fields...
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
    postTerm: function (term) {
      console.log(`Creating new term ${term.text}`);
      axios
        .post(`${this.baseURL}/concepts/${term.concept_id}/add_term`, term) // TODO: Move to an api call
        .then(function (response) {
          console.log('Created! ', response);
          term.inEdit = false;
          // this.fetchConcept();
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    deleteTerm: function(term) {
      if(!confirm('Are you sure you want to delete this term?')) {
        return;
      }

      let index = this.terms.findIndex((t) => t.id === term.id);
      if (index === -1) {
        index = this.terms.findIndex((t) => t.text === term.text);
      }
      this.terms.splice(index, 1);

      this.cleanDirty(term);

      if(term.id) {
        axios
          .delete(`${this.baseURL}/api/terms/${term.id}/destroy`)
          .then(function (response) {
            term.inEdit = false;
            // vm.fetchConcept();    // Do we want to reload full concept after each save? Maybe not, if that would reset other unsaved fields...
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
    toggleEditMode: function () {
      if ( this.getEditMode() && this.isDirty() ) {
        if ( !confirm('You have unsaved changes. Are you sure you want to exit Edit Mode?') ) {
          return;
        }
      }

      this.state.editMode = !this.state.editMode;
    },
    getEditMode: function () {
      return this.state.editMode;
    },
    flashSuccessAlert: function () {
      const alert = document.querySelector('.alert-success');
      alert.classList.remove('hidden');
      setTimeout(
        function() {
          alert.classList.add('hidden');
        },
        3000
      );
    },
    isDirty: function () {
      return this.state.isDirty.length > 0;
    },
    flagDirty: function ( obj ) {
      if ( obj.dirty ) {
        this.markDirty(obj);
      } else {
        this.cleanDirty(obj);
      }
    },
    markDirty: function(obj) {
      if(obj.id) {
        for (let i = 0; i < this.state.isDirty.length; i++) {
          if (this.state.isDirty[i].id === obj.id) {
            return;
          }
        }
      } else {
        for (let i = 0; i < this.state.isDirty.length; i++) {
          if (this.state.isDirty[i].text === obj.previous) {
            this.state.isDirty[i].text = obj.text;
            return;
          }
        }
      }
      this.state.isDirty[this.state.isDirty.length] = obj;
    },
    cleanDirty: function(obj) {
      for (let i = 0; i < this.state.isDirty.length; i++) {
        if (this.state.isDirty[i].id && this.state.isDirty[i].id === obj.id) {
          this.state.isDirty.splice(i, 1);
          return;
        } else if (this.state.isDirty[i].text && this.state.isDirty[i].text === obj.text) {
          this.state.isDirty.splice(i, 1);
          return;
        } else if (this.state.isDirty[i].value && this.state.isDirty[i].value === obj.value) {
          this.state.isDirty.splice(i, 1);
          return;
        }
      }
    },
    resetDirty: function() {
      this.state.isDirty = [];
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
.alert {
  transition: all 200ms ease-in-out;
  position: fixed;
  top: 100px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1000;
  opacity: 1;
}
.alert.hidden {
  top: -100px;
  opacity: 0;
  visibility: hidden;
  z-index: -1000;
}
</style>
