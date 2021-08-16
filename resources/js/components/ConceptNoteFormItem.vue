<template>
  <div>
    <div v-show="editMode" class="mt-3">
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
      <p>{{note}}</p> <br/>
      <p>{{type}}</p> <br/>
      <b-button variant="primary" @click="toggleEditMode()" v-if="isVocabularyEditor" v-show="!editMode"><i class="fa fa-edit"></i> Edit Note</b-button>
    </div>
  </div>
</template>

<script>
  export default{
    props: {
      noteId: {
        type: Number
      },
      propertyEditMode: {
        type: Boolean
      },
      canEditVocabulary: false,
    },
    mounted() {
      /*this.getNote();*/
    },
    data() {
      return {
        note: null,
        type: null,
        editMode: this.propertyEditMode,
        isVocabularyEditor: this.canEditVocabulary === true,
        baseURL: process.env.MIX_APP_URL
      }
    },
    methods: {
      getNote: function() {
        if(this.noteId != null) {
          fetch(`${this.baseURL}/api/concept_notes/` + this.noteId).then(data => data.json()).then(data => {
            this.note = data.note;
            this.type = data.type;
          });
        }
      },
      saveNote: function() {
        console.log(`Saving ${this.noteId} NoteId: ${this.noteId}, Index: ${this.index}`);
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
              vm.$emit('saved-note', response.data, vm.index);
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
              vm.$emit('saved-note', response.data, vm.index);
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
        console.log(`Deleting Note with id ${this.conceptSourceId}`);
        var vm = this;

        if(this.conceptSourceId == null) {
          vm.$emit('delete-note');
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
