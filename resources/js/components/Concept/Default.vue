<template>
  <div>
    <div class="alert alert-success hidden" role="alert">
      <p>Your changes have been saved.</p>
    </div>
    <div class="alert alert-danger hidden" role="alert">
      <p></p>
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
          variant="danger"
          v-show="getEditMode() && !this.conceptProps.deprecated"
          v-b-modal.concept-deprecation-to-search
        >
          Deprecate
          <i class="fa fa-trash"></i>
        </BButton>
        <BButton
          variant="secondary"
          @click="leaveEditMode()"
          v-show="getEditMode()"
        >
          Done Editing
        </BButton>

        <BModal
          id="concept-deprecation-to-search"
          title="Deprecate Concept"
          size="xl"
          @ok="deprecateConcept()"
          ref="deprecate-modal"
          :ok-disabled="!selectedConcept"
        >
          <div class="form-group">
            <label for="relation-search"
              >Search and select the concept that replaces
              "{{ preferredTerm.text }}"</label
            >
            <b-form-input
              v-model="searchTerm"
              @input="searchConcepts"
              placeholder="Type to search..."
            ></b-form-input>


            <div v-if="isSearching" class="text-center my-2">
              <b-spinner small></b-spinner> Searching...
            </div>

            <div class="search-results mt-2">
              <div
                v-for="concept in searchResults"
                :key="concept.id"
                class="search-result p-2"
                :class="{
                  selected:
                    selectedConcept && selectedConcept.id === concept.id,
                }"
                @click="selectConcept(concept)"
              >
                {{ concept.preferred_term.text }}
              </div>
            </div>
          </div>
        </BModal>

        <BModal
          id="exit-confirmation-modal"
          ref="exitModal"
          title="Confirm Exit"
          @shown="focusConfirmExitButton"
          hide-footer
        >
          <div class="d-block text-center">
            <p>
              You have unsaved changes. Are you sure you want to exit Edit Mode?
            </p>
            <BButton
              ref="confirmExitButton"
              variant="danger"
              @click="confirmExit"
              >Yes, exit</BButton
            >
            <BButton variant="secondary" @click="hideExitModal">No</BButton>
          </div>
        </BModal>
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
          <EditableTerm
            v-if="getEditMode() || preferredTerm.inEdit"
            :key="preferredTerm.id"
            :term-id="preferredTerm.id"
            :term-text="preferredTerm.text"
            :term-index="preferredTerm.index"
            :term-language-id="preferredTerm.language_id"
            :concept-id="preferredTerm.concept_id"
            :in-edit="preferredTerm.inEdit"
            is-preferred="is-preferred"
            @save-term="saveTerm"
            @cancel-inline-edit="cancelInlineEdit"
            @input="flagDirty"
          ></EditableTerm>
          <p
            v-else
            @dblclick="enableInlineEdit(preferredTerm, preferredTerm.index)"
          >
            {{ preferredTerm.text }}
          </p>

          <h4 class="mt-3" v-show="alternateTerms.length || getEditMode()">
            Alternate Terms
          </h4>

          <term-list
            :terms="alternateTerms"
            :canEditVocabulary="isVocabularyEditor"
            :has-empty-term="hasEmptyTerm"
            @save-term="saveTerm"
            @delete-term="deleteTerm"
            @add-term="addTerm"
            @make-term-preferred="makeTermPreferred"
            @enable-inline-edit="enableInlineEdit"
            @cancel-inline-edit="cancelInlineEdit"
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
              <span v-if="!getEditMode() || !canEditVocabulary">
                {{ cat.value }}
              </span>
              <EditableCategory
                v-else
                :category-id="cat.id"
                :category-value="cat.value"
                :category-index="index"
                :selected-categories="selectedCategories"
                @save-category="saveCategory"
                @delete-category="deleteCategory"
                @change="flagDirty"
              ></EditableCategory>
            </p>
          </div>
          <BButton
            class="mt-2"
            :class="{ disabled: hasEmptyCategory }"
            :disabled="hasEmptyCategory"
            variant="success"
            @click="addCategory"
            v-if="isVocabularyEditor"
            v-show="
              getEditMode() && selectedCategories.length !== categories.length
            "
            ><i class="fa fa-plus"></i> Add Category</BButton
          >
        </div>
      </div>

      <div class="my-3">
        <h4>Relationships</h4>

        <div v-if="getEditMode()">
          <BButton variant="success" @click="showAddRelationship" class="mb-3">
            <i class="fa fa-plus"></i> Add Relationship
          </BButton>
        </div>

        <!-- Relationship Modal -->
        <BModal
          v-model="showRelationshipModal"
          title="Add Relationship"
          @ok="saveRelationship"
          :ok-disabled="!selectedConcept || !relationshipType"
        >
          <div class="form-group">
            <label>Relationship Type</label>
            <b-form-select
              v-model="relationshipType"
              :options="relationshipTypes"
            ></b-form-select>
          </div>

          <div class="form-group">
            <label>Search Concepts</label>
            <b-form-input
              v-model="searchTerm"
              @input="searchConcepts"
              placeholder="Type to search..."
            ></b-form-input>

            <div v-if="isSearching" class="text-center my-2">
              <b-spinner small></b-spinner> Searching...
            </div>

            <div class="search-results mt-2">
              <div
                v-for="concept in searchResults"
                :key="concept.id"
                class="search-result p-2"
                :class="{
                  selected:
                    selectedConcept && selectedConcept.id === concept.id,
                }"
                @click="selectConcept(concept)"
              >
                {{ concept.preferred_term.text }}
              </div>
            </div>
          </div>
        </BModal>

        <!-- Display existing relationships -->
        <div v-if="hasAnyRelationships" class="relations mx-0" style="display: grid; grid-auto-flow: column; grid-auto-columns: minmax(0, 1fr); column-gap: 2rem;">
          <div v-if="relationships.broader && relationships.broader.length">
            <h3>Broader</h3>
            <div v-for="relation in relationships.broader" :key="relation.id">
              <div class="d-flex justify-content-between align-items-center">
                <a :href="`/concepts/${relation.id}`">{{ relation.preferred_term.text }}</a>
                <BButton
                  v-if="getEditMode()"
                  variant="danger"
                  size="sm"
                  @click="removeRelationship('broader', relation.id)"
                >
                  <i class="fa fa-times"></i>
                </BButton>
              </div>
            </div>
          </div>

          <div v-if="relationships.narrower && relationships.narrower.length">
            <h3>Narrower</h3>
            <div v-for="relation in relationships.narrower" :key="relation.id">
              <div class="d-flex justify-content-between align-items-center">
                <a :href="`/concepts/${relation.id}`">{{ relation.preferred_term.text }}</a>
                <BButton
                  v-if="getEditMode()"
                  variant="danger"
                  size="sm"
                  @click="removeRelationship('narrower', relation.id)"
                >
                  <i class="fa fa-times"></i>
                </BButton>
              </div>
            </div>
          </div>

          <div v-if="relationships.related && relationships.related.length">
            <h3>Related</h3>
            <div v-for="relation in relationships.related" :key="relation.id">
              <div class="d-flex justify-content-between align-items-center">
                <a :href="`/concepts/${relation.id}`">{{ relation.preferred_term.text }}</a>
                <BButton
                  v-if="getEditMode()"
                  variant="danger"
                  size="sm"
                  @click="removeRelationship('related', relation.id)"
                >
                  <i class="fa fa-times"></i>
                </BButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Component from './Default.js';

export default Component;
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

.search-result {
  cursor: pointer;
  border: 1px solid #ddd;
  margin-bottom: 4px;
  border-radius: 4px;
}

.search-result:hover {
  background-color: #f8f9fa;
}

.search-result.selected {
  background-color: #e9ecef;
  border-color: #007bff;
}

.relations {
  margin-top: 1rem;
}

.relations h3 {
  font-size: 1.25rem;
  margin-bottom: 1rem;
}

.relations a {
  display: block;
  margin-bottom: 0.5rem;
  color: #2c5282;
  text-decoration: none;
}

.relations a:hover {
  text-decoration: underline;
}

.relations .d-flex {
  margin-bottom: 0.5rem;
}

.relations .btn-sm {
  padding: 0.25rem 0.5rem;
  margin-left: 0.5rem;
}
</style>
