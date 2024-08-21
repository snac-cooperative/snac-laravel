<template>
    <div>
        <div v-if="!editMode">
            <p v-if="citation">{{citation}}</p>
            <a :href="url" v-if="url">{{url}}</a>
            <p v-if="foundData">{{foundData}}</p>
            <p v-if="note">{{note}}</p>
        </div>

        <concept-source-edit
            v-if="editMode"
            :canEditVocabulary="isVocabularyEditor"
            :concept-id="source.concept_id"
            :concept-source-id="source.id"
            :source-index="index"
            :property-toggle-edit-mode="toggleEditMode"
        ></concept-source-edit>

        <b-button variant="primary" @click="toggleEditMode()" v-if="isVocabularyEditor && parentEditMode"><i class="fa fa-edit"></i> Edit Source</b-button>
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
      parentEditMode: {
        type: Boolean
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
        editMode: false,
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
      toggleEditMode: function() {
        this.editMode = !this.editMode
      },
    }

  }
</script>

<style scoped>

</style>
