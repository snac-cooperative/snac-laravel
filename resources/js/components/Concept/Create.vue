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
    <br />
    <BButton
      v-show="!saved"
      @click="createConcept"
      :disabled="!canSave"
      variant="info"
      title="Make Preferred"
      ><i class="fa fa-floppy-o"></i> Save</BButton
    >
    <BButton>Add Term</BButton>
    <div v-show="saved" class="mt-3">
      <BButton variant="success" @click="redirectToConcept"
        ><i class="fa fa-plus"></i> Manage Concept</BButton
      >
    </div>
  </div>
</template>

<script>
import { BFormGroup, BButton, BFormInput, BFormSelect } from 'bootstrap-vue';
import { categories } from '../../config/catgegories';
import { ConceptService } from '../../api';

export default {
  data() {
    return {
      preferredTerm: null,
      conceptId: null,
      saved: false,
      categories,
      categoryId: null,
      baseURL: process.env.MIX_APP_URL,
    };
  },
  methods: {
    async createConcept() {
      if (!this.canSave) {
        return;
      }

      const [error, concept] = await ConceptService.createConcept({
        preferred_term: this.preferredTerm,
        category_id: this.categoryId,
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
  },
  computed: {
    preferredTermState() {
      if (this.preferredTerm === null) {
        return null;
      }

      return this.preferredTerm.length > 0;
    },
    preferredTermInvalid() {
      return 'Preferred Term is required.';
    },
    conceptCategoryState() {
      if (this.categoryId === null) {
        return null;
      }

      return this.categories.some(
        (category) => category.value === this.categoryId,
      );
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
        this.preferredTermState === true &&
        this.conceptCategoryState === true
      );
    },
  },
  components: {
    BFormGroup,
    BButton,
    BFormInput,
    BFormSelect,
  },
};
</script>

<style scoped></style>
