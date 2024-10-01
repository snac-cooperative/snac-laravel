<template>
  <div>
    <BInputGroup>
      <div
        v-if="originalId"
        class="category-item custom-select"
      >
        {{ selectedValue }}
      </div>
      <BFormSelect
        v-else
        v-model="selectedId"
        @change="trackChanges"
        :options="getCategories"
        :class="{ 'alert-info': isDirty() }"
        aria-placeholder="Select a category"
        placeholder="Select a category"
      ></BFormSelect>

      <BInputGroupAppend>
        <BButton
          @click="emitSaveCategory"
          class="btn btn-info"
          title="Save"
          v-show="!originalId && isDirty()"
          ><i class="fa fa-floppy-o"></i
        ></BButton>
        <BButton @click="showDeleteModal" class="btn btn-danger" title="Delete"
          ><i class="fa fa-trash"></i
        ></BButton>
      </BInputGroupAppend>
    </BInputGroup>

    <BModal
      id="delete-confirmation-modal"
      ref="deleteModal"
      title="Confirm Deletion"
      @hide="resetCategory"
      @shown="focusConfirmDeleteButton"
      hide-footer
    >
      <div class="d-block text-center">
        <p>Are you sure you want to delete this category?</p>
        <BButton variant="danger" ref="confirmDeleteButton" @click="confirmDelete">Yes, delete</BButton>
        <BButton variant="secondary" @click="hideDeleteModal">Cancel</BButton>
      </div>
    </BModal>
  </div>
</template>

<script>
import {
  BButton,
  BFormInput,
  BFormSelect,
  BInputGroup,
  BInputGroupAppend,
  BModal,
} from 'bootstrap-vue';
import { categories } from '../../config/categories';

export default {
  data() {
    return {
      selectedId: this.categoryId,
      originalId: this.categoryId,
      selectedValue: this.categoryValue,
      previous: null,
      categories,
    };
  },
  model: {
    event: 'input',
  },
  props: {
    categoryId: {
      type: Number,
      default: null,
    },
    categoryValue: {
      type: String,
      default: null,
    },
    categoryIndex: {
      type: Number,
      default: null,
    },
    selectedCategories: {
      type: Array,
      default: () => [],
    },
  },
  components: {
    BFormInput,
    BInputGroup,
    BInputGroupAppend,
    BFormSelect,
    BButton,
  },
  computed: {
    getCategories() {
      const filtered = this.categories.filter((cat) => {
        return (
          this.selectedCategories.filter((currentCat) => {
            return currentCat === parseInt(cat.value);
          }).length === 0 || this.categoryId === parseInt(cat.value)
        );
      });

      if (!this.selectedId && filtered.length) {
        filtered.unshift({
          value: null,
          text: 'Select a category',
          disabled: true,
        });
      }

      return filtered;
    },
  },
  methods: {
    trackChanges() {
      const selectedId = parseInt(this.selectedId);

      this.$emit('change', {
        id: selectedId,
        dirty: this.isDirty(),
        previous: this.previous,
      });
      this.previous = selectedId;
    },
    emitSaveCategory() {
      const selectedId = parseInt(this.selectedId);
      this.$emit('save-category', selectedId, this.categoryIndex);
      this.originalId = selectedId;
      this.selectedValue = this.categories.find(
        (cat) => parseInt(cat.value) === this.originalId,
      ).text;
    },
    showDeleteModal() {
      this.$refs.deleteModal.show();
    },
    focusConfirmDeleteButton() {
      this.$refs.confirmDeleteButton.focus();
    },
    hideDeleteModal() {
      this.$refs.deleteModal.hide();
    },
    confirmDelete() {
      this.$emit('delete-category', this.categoryId, this.categoryIndex);
      this.hideDeleteModal();
    },
    isDirty() {
      if (!this.selectedId) {
        return !!this.categoryId;
      }
      return this.originalId !== parseInt(this.selectedId);
    },
    resetCategory() {
      this.selectedId = this.categoryId;
    },
  },
};
</script>
<style>
.category-item.custom-select {
  background-image: none;
}
</style>
