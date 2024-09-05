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

export default {
  data() {
    return {
      preferredTerm: null,
      conceptId: null,
      saved: false,
      categories: [
        { value: process.env.MIX_ETHNICITY_ID, text: 'Ethnicity' },
        { value: process.env.MIX_OCCUPATION_ID, text: 'Occupation' },
        { value: process.env.MIX_ACTIVITY_ID, text: 'Activity' },
        { value: process.env.MIX_SUBJECT_ID, text: 'Subject' },
        { value: process.env.MIX_RELIGION_ID, text: 'Religion' },
        { value: process.env.MIX_RELATION_ID, text: 'Relation' },
      ],
      categoryId: null,
      baseURL: process.env.MIX_APP_URL,
    };
  },
  methods: {
    createConcept: function () {
      if (!this.canSave) {
        return;
      }

      let data = {
        preferred_term: this.preferredTerm,
        category_id: this.categoryId,
      };
      let vm = this;
      axios
        .post(`${this.baseURL}/api/concepts`, data)
        .then(function (response) {
          let result = response.data;
          console.log(response);
          if (!result.error && result.id) {
            vm.conceptId = result.id;
            vm.saved = true;
            vm.redirectToConcept();
          } else {
            console.error('Error creating', result.error);
            console.error('Exception', result.exception);
          }
        })
        .catch(function (error) {
          console.log(error);
        });
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
