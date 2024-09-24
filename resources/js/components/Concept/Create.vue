<template>
  <div>
    <BFormGroup
      id="preferred-term-fieldset"
      label="Preferred Term"
      label-for="preferred-term"
      label-size="lg"
      label-class="font-weight-bold"
      :invalid-feedback="preferredTermInvalid"
      :state="preferredTermState"
    >
      <BFormInput
        type="text"
        id="preferred-term"
        v-model="preferredTerm"
        placeholder="Enter Preferred Term"
        :state="preferredTermState"
      ></BFormInput>
    </BFormGroup>

    <BFormGroup
      id="category-fieldset"
      label="Concept Category"
      label-for="concept-category"
      label-size="lg"
      label-class="font-weight-bold"
      :invalid-feedback="conceptCategoryInvalid"
      :state="conceptCategoryState"
    >
      <BFormSelect
        id="concept-category"
        v-model="categoryId"
        :options="categories"
        :state="conceptCategoryState"
      ></BFormSelect>
    </BFormGroup>

    <template v-if="alternateTerms.length > 0">
      <h3>Alternate Terms</h3>
      <BInputGroup
        class="mb-2"
        v-for="(term, index) in alternateTerms"
        :key="index"
      >
        <BFormInput
          type="text"
          v-model="alternateTerms[index]"
          :id="`alternate-term-${index}`"
          :state="alternateTermState(term)"
        ></BFormInput>

        <BInputGroupAppend>
          <BButton
            @click="removeAlternateTerm(index)"
            class="btn btn-danger"
            title="Delete"
            ><i class="fa fa-trash"></i
          ></BButton>
        </BInputGroupAppend>

        <BFormInvalidFeedback :id="`alternate-term-${index}`">
          {{ alternateTermInvalid }}
        </BFormInvalidFeedback>
      </BInputGroup>
    </template>

    <br />
    <BButton
      @click="createConcept"
      :disabled="!canSave"
      variant="info"
      title="Save"
      ><i class="fa fa-floppy-o"></i> Save</BButton
    >
    <BButton @click="addAlternateTerm">Add Term</BButton>
  </div>
</template>

<script>
import {
  BFormGroup,
  BButton,
  BFormInput,
  BFormSelect,
  BInputGroup,
  BInputGroupAppend,
  BFormInvalidFeedback,
} from 'bootstrap-vue';
import { categories } from '../../config/categories';
import ConceptService from '../../api/ConceptService';

export default {
  data() {
    return {
      preferredTerm: null,
      alternateTerms: [],
      conceptId: null,
      saved: false,
      saving: false,
      categories,
      categoryId: null,
      baseURL: '',
      preferredTermInvalid: 'Preferred Term is required.',
      alternateTermInvalid: 'Alternate Term cannot be empty.',
    };
  },
  methods: {
    async createConcept() {
      if (!this.canSave) {
        return;
      }

      this.saving = true;

      const [error, concept] = await ConceptService.createConcept({
        preferred_term: this.preferredTerm,
        category_id: this.categoryId,
        alternate_terms: this.alternateTerms,
      });

      if (error) console.error(error);
      else {
        this.conceptId = concept.id;
        this.saved = true;
        this.redirectToConcept();
      }
    },
    redirectToConcept: function () {
      window.location.href = `/concepts/${this.conceptId}`;
    },
    addAlternateTerm() {
      this.alternateTerms.push(null);
    },
    removeAlternateTerm(index) {
      this.alternateTerms.splice(index, 1);
    },
    alternateTermState(term) {
      if (term === null) {
        return null;
      }

      return term.length > 0;
    },
  },
  computed: {
    preferredTermState() {
      if (this.preferredTerm === null) {
        return null;
      }

      return this.preferredTerm.length > 0;
    },
    conceptCategoryState() {
      if (this.categoryId === null) {
        return null;
      }

      return this.categories.some(
        (category) => category.value === this.categoryId,
      );
    },
    alternateTermsState() {
      return this.alternateTerms.every((term) => this.alternateTermState(term));
    },
    conceptCategoryInvalid() {
      const validCategories = this.categories
        .map((category) => category.text)
        .join(', ');
      return `Invalid category. The category must be one of the following: ${validCategories}.`;
    },
    canSave() {
      return (
        !this.saved &&
        !this.saving &&
        this.preferredTermState === true &&
        this.conceptCategoryState === true &&
        this.alternateTermsState === true
      );
    },
  },
  components: {
    BFormGroup,
    BButton,
    BFormInput,
    BFormSelect,
    BInputGroup,
    BInputGroupAppend,
    BFormInvalidFeedback,
  },
};
</script>

<style scoped></style>
