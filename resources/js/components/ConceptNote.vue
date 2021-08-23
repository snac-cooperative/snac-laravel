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

      <b-button @click="deleteNote()" variant="danger"><i class="fa fa-trash"></i> Delete</b-button>
      <b-button variant="primary" @click="saveNote()" ><i class="fa fa-save"></i> Save</b-button>
      <b-button @click="toggleEditMode()" >Cancel</b-button>
    </div>
    <div v-show="!editMode">
      <p>{{note}}</p> <br/>
      <p>{{type}}</p> <br/>
      <p>{{noteId}}</p> <br/>
      <b-button variant="primary" @click="toggleEditMode()" v-if="isVocabularyEditor" v-show="!editMode"><i class="fa fa-edit"></i> Edit Note</b-button>
    </div>
  </div>
</template>

<script>
  export default{
    props: {
      conceptId: {
        type: Number
      },
      propNoteId: {
        type: Number
      },
      propNote: {
        type: String
      },
      propType: {
        type: Number
      },
      propDeleteEvent: {
        type: String
      },
      propSaveEvent: {
        type: String
      },
      propertyEditMode: {
        type: Boolean
      },
      canEditVocabulary: false,
      noteIndex: null
    },
    mounted() {
      this.getNote();
    },
    data() {
      return {
        noteId: this.propNoteId,
        note: this.propNote,
        type: this.propType,
        editMode: this.propertyEditMode,
        index: this.noteIndex,
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
        let currentNote = {
            concept_id: this.conceptId,
            note: this.note,
            type_id: this.type ,
          };
        if (this.noteId) {
          console.log("Coing to call patch");
          axios.patch(`${this.baseURL}/api/concept_notes/${this.noteId}`,
            currentNote
          )
            .then(function(response) {
              vm.editMode = false;
              vm.$emit(vm.propSaveEvent, response.data, vm.index);
              console.log(response);
            }).catch(function(error) {
              console.log(error);
            });
        } else {
          axios.post(`${this.baseURL}/api/concept_notes`,
            currentNote
          )
            .then(function(response) {
              vm.editMode = false;
              vm.$emit(vm.propSaveEvent, response.data, vm.index);
              console.log(response);
            }).catch(function(error) {
              console.log(error);
            });
        }
      },
      toggleEditMode: function() {
          this.editMode = !this.editMode
      },
      deleteNote: function() {
        console.log(`Deleting Note with id ${this.noteId}`);
        var vm = this;

        if(this.noteId == null) {
          vm.$emit(vm.propDeleteEvent, vm.index);
          return;
        }

        axios.delete(`${this.baseURL}/api/concept_notes/${this.noteId}`)
          .then(function(response) {
            console.log("Deleted! ", response);
            vm.$emit(vm.propDeleteEvent, vm.index);
          }).catch(function(error) {
            console.log(error);
          })
      },
    }

  }
</script>

<style scoped>

</style>
