import { categories } from '../../../config/categories';
import conceptApi from '../../../api/ConceptService';

export default {
  data() {
    return {
      cats: this.categoriesProps,
      categories,
    };
  },
  computed: {
    selectedCategories() {
      return this.cats.map((cat) => cat.id);
    },
    hasEmptyCategory() {
      return !!(
        this.cats.length &&
        !this.cats[
          this.cats.length - 1
        ].id
      );
    },
  },
  methods: {
    getCategories(selectedId) {
      return this.categories.filter((cat) => {
        return (
          this.cats.filter((currentCat) => {
            return currentCat.id === parseInt(cat.value);
          }).length === 0 || selectedId === parseInt(cat.value)
        );
      });
    },
    async updateCategories() {
      this.conceptProps.concept_categories = this.cats;
      const [error, response] = await conceptApi.updateConcept(this.conceptId, {
        conceptCategories: this.cats,
      });
      if (!error) {
        this.flashSuccessAlert();
      }
    },
    addCategory() {
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
    saveCategory(categoryId, index) {
      const categoryText = this.categories.find((cat) => parseInt(cat.value) === categoryId).text;
      const category = { ...this.cats[index], id: categoryId, value: categoryText };

      this.$set(this.cats, index, category);

      this.cleanDirty({ id: categoryId });

      this.updateCategories().then();
    },
  },
};
