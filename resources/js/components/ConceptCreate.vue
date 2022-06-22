<template>
  <div>
    <h4>Preferred Term</h4>
      <b-form-input type="text"
        :class="'alert-info'"
        :required="true"
        v-model="preferredTerm"
        style="width:75%"
      >
      </b-form-input>
    <h4>Concept Category</h4>
    <b-col cols="4">
            <b-form-select v-model="categoryId" :options="categories"></b-form-select>
    </b-col>
    <br>
        <b-button v-show="!saved" @click="createConcept" class="btn btn-info" title="Make Preferred"><i class="fa fa-floppy-o"></i> Save</b-button>
    <div v-show="saved" class="mt-3">
      <b-button variant="success" @click="redirectToConcept"><i class="fa fa-plus"></i> Manage Concept</b-button>
    </div>
  </div>
</template>

<script>
  export default{
    data() {
      return {
        preferredTerm: null,
        conceptId: null,
        saved: false,
        categories: [
          { value:  process.env.MIX_ETHNICITY_ID, text: 'Ethnicity'},
          { value:  process.env.MIX_OCCUPATION_ID, text: 'Occupation'},
          { value:  process.env.MIX_ACTIVITY_ID, text: 'Activity'},
          { value:  process.env.MIX_SUBJECT_ID, text: 'Subject'},
          { value:  process.env.MIX_RELIGION_ID, text: 'Religion'},
          { value:  process.env.MIX_RELATION_ID, text: 'Relation'},
        ],
        categoryId: null,
        baseURL: process.env.MIX_APP_URL
      };
    },
    methods: {
      createConcept: function() {
        let data = {
          preferred_term: this.preferredTerm,
          category_id: this.categoryId
        };
        let vm = this;
        axios.post(`${this.baseURL}/api/concepts`, data)
          .then(function(response) {
            let result = response.data;
            console.log(response);
            if(!result.error && result.id) {
              vm.conceptId = result.id;
              vm.saved = true;
              vm.redirectToConcept();
            } else {
              console.error("Error creating",result.error);
              console.error("Exception",result.exception);
            }
          }).catch(function(error) {
            console.log(error);
          })
      },
      redirectToConcept: function() {
        window.location.href = `/concepts/${this.conceptId}`;
      }
    }
  }
</script>

<style scoped>

</style>
