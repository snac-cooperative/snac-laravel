<template>
  <div>
    <h4>Preferred Term</h4>
      <b-form-input type="text"
        :class="'alert-info'"
        :required="true"
        v-model="preferredTerm"
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
            { value:  400833, text: 'ethnicity'},
            { value:  400831, text: 'occupation'},
            { value:  400830, text: 'function'},
            { value:  400829, text: 'subject'},
            { value:  400834, text: 'religion'},
            { value:  400832, text: 'relation'},
        ],
        categoryId: null
      };
    },
    methods: {
      createConcept: function() {
        let data = {
          preferred_term: this.preferredTerm,
          category_id: this.categoryId
        };
        let vm = this;
        axios.post(`/api/concepts`, data)
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
