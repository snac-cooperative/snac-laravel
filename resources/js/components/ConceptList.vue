<template>
  <div>
      <b-col sm="4" md="5" class="my-1">
        <b-form-group
          label="Per page"
          label-cols-sm="6"
          label-cols-md="4"
          label-cols-lg="3"
          label-align-sm="right"
          label-size="sm"
          label-for="perPageSelect"
          class="mb-0"
        >
          <b-form-select
            v-model="perPage"
            id="perPageSelect"
            size="sm"
            :options="pageOptions"
          ></b-form-select>
        </b-form-group>
      </b-col>

      <b-col sm="7" md="6" class="my-1">
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="fill"
          size="sm"
          class="my-0"
        ></b-pagination>
      </b-col>
    <b-table
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
    >
      <template v-slot:cell(name)="row">
        {{ row.value.first }} {{ row.value.last }}
      </template>

      <template v-slot:cell(actions)="row">
        <b-button size="sm" @click="info(row.item, row.index, $event.target)" class="mr-1">
          Info modal
        </b-button>
        <b-button size="sm" @click="row.toggleDetails">
          {{ row.detailsShowing ? 'Hide' : 'Show' }} Details
        </b-button>
      </template>

      <template v-slot:row-details="row">
        <b-card>
          <ul>
            <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
          </ul>
        </b-card>
      </template>
    </b-table>

  </div>
</template>

<script>
  export default{
    data: function() {
      return {
        transProps: {
          //transition name
          name: 'flip-list'
        },
        fields: [
          { key: 'id', sortable: true},
          { key: 'term', sortable: true},
          { key: 'category', sortable: true},
        ],
        concepts: [{key: "hi", value: 10}],
        pageOptions: [5, 10, 15],
        currentPage: 1,
        perPage: 14,
        totalRows: 1,
      }
    },
    mounted() {
      this.getConcepts();
    },
    methods: {
      getConcepts: function() {
        const promise = axios.get(`concepts/?page=${this.currentPage}&per_page=${this.perPage}`);

        return promise.then( response => {
          let concepts = response.data.data;
          let concept_result = concepts.map( concept => {
            return {
              id: concept.id,
              term: concept.terms[0].text,
              category: concept.concept_categories[0].value
            };
          });
          this.totalRows = response.data.total;
          this.concepts = concept_result;
          return concept_result || [];
        });
      }
    },
  }
</script>

<style scoped>

</style>
