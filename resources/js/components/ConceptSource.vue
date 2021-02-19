<template>
  <div>
    <div v-show="editMode" class="mt-3">
      <b-row class='my-1'>

        <b-input-group class="mt-2">
          <b-col sm="2">
            <label for="citation">Citation:</label>
          </b-col>
          <b-col sm="10">
            <b-form-input v-model="citation" :citation="citation" type="text"></b-form-input>
          </b-col>
        </b-input-group>
      </b-row>

      <b-row class='my-1'>

        <b-input-group class="mt-2">
          <b-col sm="2">
            <label for="url">URL:</label>
          </b-col>
          <b-col sm="10">
            <b-form-input v-model="url" :url="url" type="text"></b-form-input>
          </b-col>
        </b-input-group>
      </b-row>

      <b-row class='my-1'>

        <b-input-group class="mt-2">
          <b-col sm="2">
            <label for="found_data">Found Data:</label>
          </b-col>
          <b-col sm="10">
            <b-form-input v-model="foundData" :foundData="foundData" type="text"></b-form-input>
          </b-col>
        </b-input-group>
      </b-row>

      <b-row class='my-1'>

        <b-input-group class="mt-2">
          <b-col sm="2">
            <label for="note">Note:</label>
          </b-col>
          <b-col sm="10">
            <b-form-input v-model="note" :note="note" type="text"></b-form-input>
          </b-col>
        </b-input-group>
      </b-row>

      <b-button @click="deleteSource()" variant="danger"><i class="fa fa-trash"></i> Delete</b-button>
      <b-button variant="primary" @click="saveConceptSource()" ><i class="fa fa-save"></i> Save</b-button>
      <b-button @click="toggleEditMode()" >Cancel</b-button>
    </div>
    <div v-show="!editMode">
      <p>{{citation}}</p> <br/>
      <p>{{url}}</p> <br/>
      <p>{{foundData}}</p> <br/>
      <p>{{note}}</p> <br/>
      <b-button variant="primary" @click="toggleEditMode()" v-if="isVocabularyEditor" v-show="!editMode"><i class="fa fa-edit"></i> Edit Source</b-button>
    </div>
  </div>
</template>

<script>
  export default{
    props: {
      conceptId: {
        type: Number
      },
      conceptSourceId: {
        type: Number
      },
      propertyEditMode: {
        type: Boolean
      },
      canEditVocabulary: false,
      sourceIndex: null
    },
    mounted() {
      this.getConceptSource();
    },
    data() {
      return {
        citation: null,
        url: null,
        foundData: null,
        note: null,
        editMode: this.propertyEditMode,
        isVocabularyEditor: this.canEditVocabulary === true,
        index: this.sourceIndex,
        baseURL: process.env.MIX_APP_URL
      }
    },
    methods: {
      getConceptSource: function() {
        if(this.conceptSourceId != null) {
          fetch(`${this.baseURL}/api/concept_sources/` + this.conceptSourceId).then(data => data.json()).then(data => {
            this.citation = data.citation;
            this.url = data.url;
            this.foundData = data.found_data;
            this.note = data.note;
          });
        } // if concept source is new => conceptSourceId = nil
      },
      saveConceptSource: function() {
        console.log(`Saving ${this.conceptSourceId} ConceptId: ${this.conceptId}, Index: ${this.index}`);
        let vm = this;
        // Check this with Joseph
        let currentSource = {
            concept_id: this.conceptId,
            citation: this.citation,
            url: this.url,
            found_data: this.foundData,
            note: this.note
          };
        if (this.conceptSourceId) {
          axios.patch(`${this.baseURL}/api/concept_sources/${this.conceptSourceId}`,
            currentSource
          )
            .then(function(response) {
              vm.editMode = false;
              vm.$emit('saved-source', response.data, vm.index);
              console.log(response);
            }).catch(function(error) {
              console.log(error);
            });
        } else {
          axios.post(`${this.baseURL}/api/concept_sources`,
            currentSource
          )
            .then(function(response) {
              vm.editMode = false;
              vm.$emit('saved-source', response.data, vm.index);
              console.log(response);
            }).catch(function(error) {
              console.log(error);
            });
        }
      },
      toggleEditMode: function() {
          this.editMode = !this.editMode
      },
      deleteSource: function() {
        console.log(`Deleting Source with id ${this.conceptSourceId}`);
        var vm = this;

        if(this.conceptSourceId == null) {
          vm.$emit('delete-source');
          return;
        }

        axios.delete(`${this.baseURL}/api/concept_sources/${this.conceptSourceId}`)
          .then(function(response) {
            console.log("Deleted! ", response);
            vm.$emit('delete-source');
          }).catch(function(error) {
            console.log(error);
          })

      },
    }

  }
</script>

<style scoped>

</style>
