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

      <b-button variant="primary" @click="saveConceptSource()" ><i class="fa fa-save"></i>Save</b-button>
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
      }
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
        editMode: this.propertyEditMode
      }
    },
    methods: {
      getConceptSource: function() {
        if(this.conceptSourceId != null) {
          fetch('/api/concept_sources/' + this.conceptSourceId).then(data => data.json()).then(data => {
            this.citation = data.citation;
            this.url = data.url;
            this.foundData = data.found_data;
            this.note = data.note;
          });
        } // if concept source is new => conceptSourceId = nil
      },
      saveConceptSource: function() {
        console.log(`Saving ${this.conceptSourceId}`);
        let vm = this;
        // Check this with Joseph
        let currentSource = {
            conceptId: this.conceptId,
            citation: this.citation,
            url: this.url,
            found_data: this.foundData,
            note: this.note
          };
        if (this.conceptSourceId) {
          axios.patch(`/api/concept_sources/${this.conceptSourceId}`, 
            currentSource
          )
            .then(function(response) {
              vm.editMode = false;
              console.log(response);
            }).catch(function(error) {
              console.log(error);
            });
        } else {
          axios.post(`/api/concept_sources`, 
            currentSource
          )
            .then(function(response) {
              vm.editMode = false;
              console.log(response);
            }).catch(function(error) {
              console.log(error);
            });
        }
      },
      toggleEditMode: function() {
          this.editMode = !this.editMode
      },
    }
    
  }
</script>

<style scoped>

</style>
