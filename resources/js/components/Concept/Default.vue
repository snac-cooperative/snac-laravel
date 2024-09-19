<template>
  <div>
    <div class="alert alert-success hidden" role="alert">
      Your changes have been saved.
    </div>

    <header class="sticky-top bg-white">
      <div class="mb-3 float-right" v-if="isVocabularyEditor">
        <BButton
          variant="primary"
          @click="toggleEditMode()"
          v-show="!getEditMode()"
        >
          <i class="fa fa-edit"></i> Edit
        </BButton>
        <BButton
          variant="secondary"
          @click="toggleEditMode()"
          v-show="getEditMode()"
        >
          Done Editing
        </BButton>
      </div>

      <h2>
        {{ preferredTerm.text }}
        <span v-if="deprecated">(deprecated)</span>
      </h2>

      <hr />
    </header>

    <div id="concept-table">
      <div class="form-group">
        <div class="col-xs-8">
          <h4>Preferred Term</h4>
          <p v-if="!getEditMode()">{{ preferredTerm.text }}</p>
          <EditableTerm
            v-else
            :term="preferredTerm"
            is-preferred="is-preferred"
            @save-term="saveTerm"
            @input="flagDirty"
          ></EditableTerm>

          <h4 class="mt-3" v-show="alternateTerms.length || getEditMode()">
            Alternate Terms
          </h4>

          <term-list
            :terms="alternateTerms"
            :canEditVocabulary="isVocabularyEditor"
            @save-term="saveTerm"
            @delete-term="deleteTerm"
            @add-term="addTerm"
            @make-term-preferred="makeTermPreferred"
            @flat-dirty="flagDirty"
          ></term-list>
        </div>
      </div>

      <div class="my-3" v-if="sources.length || getEditMode()">
        <h4>Concept Sources</h4>
        <div
          v-for="(source, index) in sources"
          v-bind:key="source.id"
          v-bind:citation="source.citation"
          v-bind:url="source.url"
          v-bind:found_data="source.found_data"
          v-bind:note="source.note"
        >
          <EditableSource
            :concept-id="source.concept_id"
            :concept-source-id="source.id"
            :source-index="index"
            :canEditVocabulary="isVocabularyEditor"
            :in-edit="source.inEdit"
            @save-source="saveSource"
            @delete-source="deleteSource"
            @input="flagDirty"
          ></EditableSource>
        </div>

        <BButton
          class="mt-2"
          :class="{ disabled: hasEmptySource }"
          :disabled="hasEmptySource"
          variant="success"
          @click="addSource"
          v-if="isVocabularyEditor"
          v-show="getEditMode()"
          ><i class="fa fa-plus"></i> Add Source</BButton
        >
      </div>

      <div class="my-3" v-if="cats.length || getEditMode()">
        <h4>Categories</h4>

        <div class="category-list">
          <div
            v-for="(cat, index) in cats"
            v-bind:key="cat.id"
            v-bind:index="index"
          >
            <p class="mb-2">
              <span
                v-if="!getEditMode() || !canEditVocabulary"
                :class="{ 'font-weight-bold': index === 0 }"
              >
                {{ cat.value }}
              </span>
              <EditableCategory
                v-else
                :category-id="cat.id"
                :category-value="cat.value"
                :category-index="index"
                :is-primary="0 === index"
                :selected-categories="selectedCategories"
                @save-category="saveCategory"
                @delete-category="deleteCategory"
                @change="flagDirty"
              ></EditableCategory>
            </p>
          </div>
          <BButton
            class="mt-2"
            :class="{ 'disabled': hasEmptyCategory }"
            :disabled="hasEmptyCategory"
            variant="success"
            @click="addCategory"
            v-if="isVocabularyEditor"
            v-show="getEditMode()"
            ><i class="fa fa-plus"></i> Add Category</BButton
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { BButton, BInputGroup, BInputGroupAppend } from 'bootstrap-vue';
import state from '../../states/concept';
import EditableTerm from '../Term/Editable.vue';
import EditableSource from '../Source/Editable.vue';
import EditableCategory from '../Category/Editable.vue';
import { categories } from '../../config/categories';
import conceptApi from '../../api/ConceptService';
import src from 'vue-multiselect/src';

export default {
  components: { BInputGroup, BInputGroupAppend, EditableTerm, EditableSource, EditableCategory },
  props: {
    conceptProps: {
      type: Object,
    },
    termProps: {
      type: Array,
    },
    categoriesProps: {
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
      cats: this.categoriesProps,
      // concept: this.termProps.slice()
      conceptId: this.conceptProps.id,
      termSearch: [],
      allTermsSearch: false,
      selected_concept: '',
      relationType: '',
      state: state,
      categories,
      isVocabularyEditor: this.canEditVocabulary !== 'false',
      baseURL: process.env.MIX_APP_URL,
    };
  },
  computed: {
    src() {
      return src;
    },
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
    hasEmptySource() {
      return !!(
        this.sources.length && !this.sources[this.sources.length - 1].id
      );
    },
    selectedCategories() {
      return this.cats.map((cat) => cat.id);
    },
    hasEmptyCategory() {
      console.log( 'cats', this.cats );
      return !!(
        this.cats.length &&
        !this.cats[
          this.cats.length - 1
        ].id
      );
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
      const vm = this;
      if (!term.id) {
        vm.postTerm(term);
        vm.cleanDirty(term);
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
      axios
        .post(`${this.baseURL}/concepts/${term.concept_id}/add_term`, term) // TODO: Move to an api call
        .then(function (response) {
          term.inEdit = false;
          // this.fetchConcept();
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    makeTermPreferred: function (term) {
      if (
        !confirm(
          `Are you sure you want to make '${term.text}' the preferred term for this concept?`,
        )
      ) {
        return;
      }

      const oldPreferred = this.preferredTerm;
      oldPreferred.preferred = false;
      term.preferred = true;

      this.saveTerm(oldPreferred);
      this.saveTerm(term);
    },
    deleteTerm: function (term) {
      if (!confirm('Are you sure you want to delete this term?')) {
        return;
      }

      const vm = this;
      let index = this.terms.findIndex((t) => t.id === term.id);
      if (index === -1) {
        index = this.terms.findIndex((t) => t.text === term.text);
      }

      if (!term.id) {
        this.terms.splice(index, 1);
        this.cleanDirty(term);
        return;
      }

      axios
        .delete(`${this.baseURL}/api/terms/${term.id}/destroy`)
        .then(function (response) {
          term.inEdit = false;
          vm.terms.splice(index, 1);
          vm.cleanDirty(term);
          // vm.fetchConcept();    // Do we want to reload full concept after each save? Maybe not, if that would reset other unsaved fields...
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getCategories(selectedId) {
      return this.categories.filter((cat) => {
        return (
          this.cats.filter((currentCat) => {
            return currentCat.id === parseInt(cat.value);
          }).length === 0 || selectedId === parseInt(cat.value)
        );
      });
    },
    updateCategories: function() {
      this.conceptProps.concept_categories = this.cats;
      conceptApi.updateConcept(this.conceptId, {
        conceptCategories: this.cats,
      });
      this.flashSuccessAlert();
    },
    addCategory: function () {
      if (this.hasEmptyCategory) {
        return;
      }

      const newCategory = {
        pivot: {
          concept_id: this.conceptId,
        },
        type: 'concept_category',
      };
      this.cats.push(newCategory);
    },
    saveCategory: function (categoryId, index) {
      console.log(`Saving Category with id ${categoryId}`);
      const categoryText = this.categories.find((cat) => parseInt(cat.value) === categoryId).text;
      const category = { ...this.cats[index], id: categoryId, value: categoryText };

      this.$set(this.cats, index, category);

      this.cleanDirty({ id: categoryId });

      this.updateCategories();
    },
    deleteCategory: function(categoryId, index) {
      console.log(`Deleting Category with id ${categoryId}`);

      this.cats.splice(index, 1);

      this.updateCategories();
    },
    addSource: function () {
      this.sources.push({ concept_id: this.conceptId, inEdit: true });
    },
    updateSources: function (source, index) {
      this.sources.splice(index, 1, source);
    },
    saveSource: function (source, sourceId, index) {
      console.log(
        `Saving ${sourceId} ConceptId: ${this.conceptId}, Index: ${index}`,
      );
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
    deleteSource: function (sourceId, index) {
      console.log(`Deleting Source with id ${sourceId}`);

      if (!sourceId) {
        this.cleanDirty(this.sources[index]);
        this.sources.splice(index, 1);
        return;
      }

      const vm = this;

      axios
        .delete(`${this.baseURL}/api/concept_sources/${sourceId}`)
        .then(function (response) {
          console.log('Deleted!', response);
          vm.cleanDirty(vm.sources[index]);
          vm.sources.splice(index, 1);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    toggleEditMode: function () {
      if (this.getEditMode() && this.isDirty()) {
        if (
          !confirm(
            'You have unsaved changes. Are you sure you want to exit Edit Mode?',
          )
        ) {
          return;
        }
        this.resetDirty();
      }

      this.state.editMode = !this.state.editMode;
    },
    getEditMode: function () {
      return this.state.editMode;
    },
    flashSuccessAlert: function () {
      const alert = document.querySelector('.alert-success');
      alert.classList.remove('hidden');
      setTimeout(function () {
        alert.classList.add('hidden');
      }, 3000);
    },
    isDirty: function () {
      return this.state.isDirty.length > 0;
    },
    flagDirty: function (obj) {
      if (obj.dirty) {
        this.markDirty(obj);
      } else {
        this.cleanDirty(obj);
      }
    },
    markDirty: function (obj) {
      if (obj.id) {
        for (let i = 0; i < this.state.isDirty.length; i++) {
          if (this.state.isDirty[i].id === obj.id) {
            return;
          }
        }
      } else {
        let prev = obj.previous;
        delete obj.previous;
        delete obj.dirty;

        for (let i = 0; i < this.state.isDirty.length; i++) {
          if (JSON.stringify(this.state.isDirty[i]) === JSON.stringify(prev)) {
            this.state.isDirty[i] = obj;
            return;
          }
        }
      }
      this.state.isDirty[this.state.isDirty.length] = obj;
    },
    cleanDirty: function (obj) {
      delete obj.previous;
      delete obj.dirty;

      for (let i = 0; i < this.state.isDirty.length; i++) {
        if (this.state.isDirty[i].id && this.state.isDirty[i].id === obj.id) {
          this.state.isDirty.splice(i, 1);
          return;
        } else if (
          JSON.stringify(this.state.isDirty[i]) === JSON.stringify(obj)
        ) {
          this.state.isDirty.splice(i, 1);
          return;
        }
      }
    },
    resetDirty: function () {
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
  z-index: 1200;
  opacity: 1;
}
.alert.hidden {
  top: -100px;
  opacity: 0;
  visibility: hidden;
  z-index: -1000;
}

header.sticky-top {
  top: 56px; /* offset for top navigation */
  padding-top: 0.5rem;
}
</style>
