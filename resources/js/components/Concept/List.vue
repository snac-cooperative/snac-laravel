<template>
  <div>
    <BCol sm="4" md="5" class="my-1">
      <BFormGroup
        label="Per page"
        label-cols-sm="6"
        label-cols-md="4"
        label-cols-lg="3"
        label-align-sm="right"
        label-size="sm"
        label-for="perPageSelect"
        class="mb-0"
      >
        <BFormSelect
          v-model="perPage"
          id="perPageSelect"
          size="sm"
          :options="pageOptions"
        ></BFormSelect>
      </BFormGroup>
    </BCol>

    <BCol sm="7" md="6" class="my-1">
      <BPagination
        v-model="currentPage"
        :total-rows="totalRows"
        :per-page="perPage"
        align="fill"
        size="sm"
        class="my-0"
      ></BPagination>
    </BCol>
    <BTable
      show-empty
      small
      stacked="md"
      :items="getConcepts"
      :fields="fields"
      striped
      primary-key="id"
      :tbody-transition-props="transProps"
      :current-page="currentPage"
      :per-page="perPage"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
    >
      <template v-slot:cell(preferredTerm)="row">
        <BLink :href="row.item.link">{{ row.item.preferredTerm }}</BLink>
      </template>

      <template v-slot:cell(actions)="row">
        <BButton
          size="sm"
          @click="info(row.item, row.index, $event.target)"
          class="mr-1"
        >
          Info modal
        </BButton>
        <BButton size="sm" @click="row.toggleDetails">
          {{ row.detailsShowing ? 'Hide' : 'Show' }} Details
        </BButton>
      </template>

      <template v-slot:bottom-row="row"> </template>

      <template v-slot:row-details="row">
        <BCard>
          <ul>
            <li v-for="(value, key) in row.item" :key="key">
              {{ key }}: {{ value }}
            </li>
          </ul>
        </BCard>
      </template>
    </BTable>
  </div>
</template>

<script>
import {
  BButton,
  BCard,
  BCol,
  BFormGroup,
  BFormSelect,
  BLink,
  BPagination,
  BTable,
} from 'bootstrap-vue';
import { ConceptService } from '../../api';
import { sortBy } from 'lodash';

export default {
  data: function () {
    return {
      transProps: {
        //transition name
        name: 'flip-list',
      },
      sortBy: 'preferredTerm',
      sortDesc: true,
      fields: [
        { key: 'preferredTerm', sortable: true },
        { key: 'category', sortable: true },
      ],
      concepts: [],
      pageOptions: [5, 10, 15],
      currentPage: 1,
      perPage: 15,
      totalRows: 1,
      baseURL: '',
    };
  },
  computed: {
    sortOrder() {
      return this.sortDesc ? 'asc' : 'desc';
    },
  },
  methods: {
    async getConcepts() {
      const [error, concepts] = await ConceptService.listConcepts(
        this.perPage,
        this.sortBy,
        this.sortOrder,
        this.currentPage,
      );

      let conceptData = [];

      if (error) console.error(error);
      else {
        this.totalRows = concepts.meta.total;
        conceptData = concepts.data.map((concept) => {
          return {
            id: concept.id,
            link: `${this.baseURL}/concepts/${concept.id}`,
            preferredTerm: concept.preferred_term.text,
            category: concept.concept_categories[0].value,
          };
        });
        this.loading = false;
      }

      return conceptData;
    },
  },
  components: {
    BCol,
    BFormGroup,
    BFormSelect,
    BPagination,
    BTable,
    BLink,
    BButton,
    BCard,
  },
};
</script>
