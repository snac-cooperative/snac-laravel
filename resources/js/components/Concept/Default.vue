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
            :key="preferredTerm.id"
            :term-id="preferredTerm.id"
            :term-text="preferredTerm.text"
            :term-index="preferredTerm.index"
            :concept-id="preferredTerm.concept_id"
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
            :has-empty-term="hasEmptyTerm"
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
            v-show="getEditMode() && selectedCategories.length !== categories.length"
            ><i class="fa fa-plus"></i> Add Category</BButton
          >
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
</style>
