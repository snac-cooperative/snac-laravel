<template>
    <div id="concept-table" classname="">
        <div class="form-group">
            <div class="col-xs-8">
                <h2>{{ preferredTerm.text }}<span v-if="deprecated">(deprecated)</span></h2>
                <h4>Preferred Term</h4>
                <p v-show="!editMode"> {{ preferredTerm.text }}</p>
                <b-input-group v-show="editMode" class="mt-3">
                    <!-- TODO: Do we want inputs to start as readonly? -->
                    <b-form-input type="text"
                        :class="{'alert-info' : preferredTerm.inEdit}"
                        :required="true"
                        @change=editTerm(preferredTerm)
                        v-model="preferredTerm.text"
                    >
                    </b-form-input>
                    <b-input-group-append>
                        <b-button @click="saveTerm(preferredTerm)" class="btn btn-info" title="Make Preferred"><i class="fa fa-floppy-o"></i></b-button>
                    </b-input-group-append>
                </b-input-group>
                <!-- DEBUG: {{preferredTerm.inEdit}} -->

                <h4 v-if="alternateTerms.length" class="mt-3">Alternate Terms</h4>
                <div v-bind:key="term.id" v-for="term in alternateTerms">
                    <!-- Extract into Term Component? -->
                    <p v-show="!editMode"> {{ term.text }}</p>
                    <b-input-group v-show="editMode" class="mt-2">
                        <b-form-input type="text"
                            :class="{'alert-info' : term.inEdit}"
                            :required="true"
                            @change=editTerm(term)
                            v-model="term.text"
                        >
                        </b-form-input>

                        <b-input-group-append>
                            <b-button @click="saveTerm(term)" class="btn btn-info" title="Make Preferred"><i class="fa fa-floppy-o"></i></b-button>
                            <b-button @click="makeTermPreferred(term)" class="btn btn-primary" title="Make Preferred"><i class="fa fa-check-square-o"></i></b-button>
                            <b-button @click="deleteTerm(term)" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></b-button>
                        </b-input-group-append>
                    </b-input-group>
                    <!--DEBUG: {{term.inEdit}} -->
                    <!-- Extract into Term Component? -->

                </div>

                <div v-show="editMode" class="mt-3">
                    <!-- // TODO: Category editing and backend calls  -->
                    <h4>Concept Categories</h4>

                    <b-col cols="4">
                        <div class="mt-1" v-bind:key="category.id" v-for="category in cats">
                            <b-form-select v-model="category.id" :options="categories"></b-form-select>
                        </div>
                    </b-col>
                </div>

                <div class="mt-3">
                    <!-- TODO: Backend calls -->
                    <b-button variant="success" @click="addTerm()" v-show="editMode"><i class="fa fa-plus"></i> Add Term</b-button>
                    <b-button variant="secondary" @click="fetchConcept();toggleEditMode()" v-show="editMode">Cancel</b-button>
                    <b-button variant="primary" @click="toggleEditMode()" v-if="isVocabularyEditor" v-show="!editMode"><i class="fa fa-edit"></i> Edit</b-button>
                </div>

                <div class="mt-3">
                    <h4>Concept Sources</h4>
                    <div class="mt-1" :key="source.id" v-for="(source, index) in sources">
                      <concept-source
                        :canEditVocabulary="isVocabularyEditor"
                        :concept-id="source.concept_id"
                        :concept-source-id="source.id"
                        :property-edit-mode="source.editMode"
                        v-on:delete-source="deleteConceptSource(index)"
                        v-on:saved-source="updateSource"
                        :source-index="index"
                      ></concept-source>
                    </div>
                    <div class="mt-3">
                      <b-button v-if="isVocabularyEditor" @click="addSource()" variant="info"><i class="fa fa-plus"></i> Add Source</b-button>
                    </div>
                </div>
                <div class="mt-3">
                    <h4>Scope Notes</h4>
                    <div class="mt-1" :key="note.id" v-for="(note, index) in archivalScopeNotes">
                      <concept-note
                        :canEditVocabulary="isVocabularyEditor"
                        :concept-id="note.concept_id"
                        :prop-note-id="note.id"
                        :prop-note="note.note"
                        :prop-type="note.type_id"
                        prop-delete-event='delete-archival-scope-note'
                        prop-save-event='save-archival-scope-note'
                        :property-edit-mode="note.editMode"
                        v-on:delete-archival-scope-note="deleteArchivalScopeNote(index)"
                        v-on:save-archival-scope-note="updateArchivalScopeNote"
                        :note-index="index"
                      ></concept-note>
                    </div>
                    <div class="mt-3">
                      <b-button v-if="isVocabularyEditor" @click="addArchivalScopeNote()" variant="info"><i class="fa fa-plus"></i> Add Scope Note</b-button>
                    </div>
                </div>
                <div class="mt-3">
                    <h4>Historical Notes</h4>
                    <div class="mt-1" :key="note.id" v-for="(note, index) in historicalNotes">
                      <concept-note
                        :canEditVocabulary="isVocabularyEditor"
                        :concept-id="note.concept_id"
                        :prop-note-id="note.id"
                        :prop-note="note.note"
                        :prop-type="note.type_id"
                        prop-delete-event='delete-historical-note'
                        prop-save-event='save-historical-note'
                        :property-edit-mode="note.editMode"
                        v-on:delete-historical-note="deleteHistoricalNote(index)"
                        v-on:save-historical-note="updateHistoricalNote"
                        :note-index="index"
                      ></concept-note>
                    </div>
                    <div class="mt-3">
                      <b-button v-if="isVocabularyEditor" @click="addHistoricalNote()" variant="info"><i class="fa fa-plus"></i> Add Historical Note</b-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <b-button v-if="isVocabularyEditor" v-b-modal.concept-relations-search variant="info"><i class="fa fa-plus"></i> Add Relationship</b-button>
        </div>

        <b-modal
            id="concept-relations-search"
            title="Concept Relations"
            size="xl"
            @ok="relateConcept()"
        >
        <!-- TODO: extract concept search form into ConceptSearch.vue-->
        <!-- ok-title="Create Relationship" -->
            <form
                id="concept-relationship-form"
                @submit.stop.prevent="searchConcept()">
                <div class="form-group">
                    <label for="relation-search">Related Concept</label>
                    <div class="input-group mb-3">
                        <input id="relation-search" ref="searchQuery" type="text" class="form-control" placeholder="Related Concept" aria-label="Related Concept">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="button" @click="searchConcept()">Search</button>
                        </div>
                    </div>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is-preferred" v-model="allTermsSearch" title="Search only Preferred Terms">
                    <label class="form-check-label" for="is-preferred" >Search non-preferred terms</label>
                </div>

                <h4 class="mt-4">Relation Type</h4>
                <div class="form-check">
                    <input class="form-check-input" v-model="relationType" type="radio" name="relation-type" value="broader">
                    <label class="form-check-label" for="broader-relation-check">
                        Broader
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" v-model="relationType" type="radio" name="relation-type" value="narrower">
                    <label class="form-check-label" for="narrower-relation-check">
                        Narrower
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" v-model="relationType" type="radio" name="relation-type" value="related">
                    <label class="form-check-label" for="broader-relation-check">
                        Related
                    </label>
                </div>
                <div class="">
                    <table class="table table-hover mt-3" v-if="termSearch.length">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Term</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :key="term.term_id" v-for="(term) in termSearch">
                                <td><input type="radio" name="relation-choice" :value="term.concept_id" v-model="selected_concept"></td>
                                <td> <a :href="term.concept_id">{{ term.term }}</a></td>
                                <td>{{ term.category }}</td>
                                <!-- <td>{{ term.preferred }}</td> -->
                                <!-- TODO: Handle multiple categories by conjoining.  -->
                                <!-- TODO: Display result count.  -->
                            </tr>
                        </tbody>
                    </table>
                </div>
                <b-button @click="relateConcept()" class="btn btn-info" title="Make Preferred">Relate Concepts <i class="fa fa-floppy-o"></i></b-button>
            </form>

        </b-modal>

        <div class="mt-3">
            <b-button v-if="isVocabularyEditor && !deprecated" v-b-modal.concept-deprecation-to-search variant="danger"><i class="fa fa-trash"></i> Deprecate Concept</b-button>
        </div>

        <b-modal
            id="concept-deprecation-to-search"
            title="Concept Deprecation"
            size="xl"
            @ok="deprecateConcept()"
            ref="deprecate-modal"
        >
        <!-- ok-title="Create Relationship" -->
        <!-- TODO: Rename this form to fix collision -->
            <form
                id="concept-relationship-form"
                @submit.stop.prevent="searchConcept()">
                <div class="form-group">
                    <label for="relation-search">Optional - Search and select the concept that replaces {{ preferredTerm.text }}</label>
                    <div class="input-group mb-3">
                        <input id="relation-search" ref="searchQuery" type="text" class="form-control" placeholder="Concept" aria-label="Concept">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="button" @click="searchConcept()">Search</button>
                        </div>
                    </div>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is-preferred" v-model="allTermsSearch" title="Search only Preferred Terms">
                    <label class="form-check-label" for="is-preferred" >Search non-preferred terms</label>
                </div>

                <div class="">
                    <table class="table table-hover mt-3" v-if="termSearch.length">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Term</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :key="term.term_id" v-for="(term) in termSearch">
                                <td><input type="radio" :id="term.concept_id"  name="relation-choice" :value="term.concept_id" v-model="selected_concept"></td>
                                <td> <label :for="term.concept_id">{{ term.term }}</label> <a target="_blank" :href="term.concept_id"><i class="fa fa-external-link"></i></a></td>
                                <td>{{ term.category }}</td>
                                <!-- <td>{{ term.preferred }}</td> -->
                                <!-- TODO: Handle multiple categories by conjoining.  -->
                                <!-- TODO: Display result count.  -->
                            </tr>
                        </tbody>
                    </table>
                </div>
                <b-button @click="deprecateConcept()" class="btn btn-info" title="Make Preferred">Deprecate Concept <i class="fa fa-floppy-o"></i></b-button>
            </form>

        </b-modal>
    </div>
</template>

<script>
// import TermItem from './TermItem.vue';
    export default {
        props: {
            conceptProps: {
                type: Object
            },
            termProps: {
                type: Array
            },
            sourcesProps: {
                type: Array
            },
            notesProps: {
                type: Array
            },
            archivalScopeNoteTypeIdProps: {
              type: Number
            },
            historicalNoteTypeIdProps: {
              type: Number
            },
            canEditVocabulary: false
        },
        data() {
            return {
                deprecated: this.conceptProps.deprecated,
                // Do we need to make a copy of termProps with slice() or [...this.termProps]?
                terms: this.termProps.map(
                    // populating terms with our custom temporary variables
                    (term) => {term.inEdit = false; return term}
                ),
                sources: this.sourcesProps.map(
                    // populating terms with our custom temporary variables
                    (source) => {source.inEdit = false; return source}
                ),
                notes: this.notesProps.map(
                    // populating terms with our custom temporary variables
                    (note) => {note.inEdit = false; return note}
                ),
                archivalScopeNotes: this.notesProps.map((note) => {
                  note.inEdit = false;
                  return note
                }).filter(note => note.type_id == this.archivalScopeNoteTypeIdProps).sort(),
                historicalNotes: this.notesProps.map((note) => {
                  note.inEdit = false;
                  return note
                }).filter(note => note.type_id == this.historicalNoteTypeIdProps).sort(),
                editMode: false,
                // concept: this.termProps.slice()
                conceptId: this.conceptProps.id,
                termSearch: [],
                allTermsSearch: false,
                selected_concept: '',
                relationType: '',
                propertyEditMode: false,
                // populating terms with our custom temporary variables
                // concept: this.termProps.slice()
                categories: [
                    { value:  process.env.MIX_ETHNICITY_ID, text: 'Ethnicity'},
                    { value:  process.env.MIX_OCCUPATION_ID, text: 'Occupation'},
                    { value:  process.env.MIX_ACTIVITY_ID, text: 'Function'},
                    { value:  process.env.MIX_SUBJECT_ID, text: 'Subject'},
                    { value:  process.env.MIX_RELIGION_ID, text: 'Religion'},
                    { value:  process.env.MIX_RELATION_ID, text: 'Relation'},
                ],
                cats: this.conceptProps.concept_categories,
                selectedCategory: this.conceptProps.concept_categories[0].id,
                isVocabularyEditor: this.canEditVocabulary === "false" ? false : true,
                baseURL: process.env.MIX_APP_URL
            }
        },
        computed: {
            alternateTerms() {
                return this.terms.map((term) => {
                    term.inEdit = false;
                    return term
                }).filter(term => !term.preferred).sort()
            },
            preferredTerm() {
                return this.terms.find(term => term.preferred)
            }
        },
        created() {
            console.log("Concept component loaded");
            console.log(this.terms);
            console.log("hello: ");
            console.log(this.conceptProps.concept_categories[0].value);

        },
        methods: {
            fetchConcept: function() {
                fetch(`${this.baseURL}/api/concepts/` + this.terms[0].concept_id).then(data => data.json()).then(data => {
                    console.log("here you are: ", data)
                    this.terms = data.terms.map(
                        // populating terms with our custom temporary variables
                        (term) => {term.inEdit = false; return term}
                    )
                })
            },
            makeTermPreferred: function(term) {
                console.log(`${term.text} is preferred!`, term);
                if (!confirm(`Are you sure you want to make '${term.text}' the preferred term for this concept?`)) {
                    return;
                }

                var oldPreferred = this.preferredTerm;
                oldPreferred.preferred = false;
                term.preferred = true;

                this.saveTerm(oldPreferred);
                this.saveTerm(term);


            },
            deleteTerm: function(term) {
                console.log(`Deleting ${term.text} with id ${term.id}`);
                var vm = this;

                // if term is not saved, simply drop
                if (!term.id) {
                    vm.terms.splice(vm.terms.indexOf(term), 1);
                    return;
                }

                axios.delete(`${this.baseURL}/api/terms/${term.id}`)
                    .then(function(response) {
                        vm.terms.splice(vm.terms.indexOf(term), 1);
                        console.log("Deleted! ", response);
                    }).catch(function(error) {
                        console.log(error);
                    })

            },
            editTerm: function(term) {
                console.log(`Editing ${term.text} with id ${term.id}`)

                term.inEdit = true
            },
            postTerm: function(term) {
                console.log(`Creating new term ${term.text}`)
                axios.post(`${this.baseURL}/concepts/${term.concept_id}/add_term`, term) // TODO: Move to an api call
                    .then(function(response) {
                        console.log("Created! ", response);
                        term.inEdit = false;
                        // this.fetchConcept();
                    }).catch(function(error) {
                        console.log(error);
                    })

            },
            saveTerm: function(term) {
                console.log(`Saving ${term.text} with id ${term.id}`);

                var vm = this;

                if (!term.id) {
                    this.postTerm(term);
                    // TODO: prevent a double-click from posting twice
                } else {
                    axios.patch(`${this.baseURL}/api/terms/${term.id}`, term)
                    .then(function(response) {
                        term.inEdit = false;
                        // vm.fetchConcept();    // Do we want to reload full concept after each save? Maybe not, if that would reset other unsaved fields...
                    }).catch(function(error) {
                        console.log(error);
                    })
                }
            },
            toggleEditMode: function() {
                this.editMode = !this.editMode
            },
            addTerm: function() {
                if (!this.terms[this.terms.length - 1].text) {
                    return;
                }

                var conceptID = this.terms[0].concept_id
                var newTerm = {
                    concept_id : conceptID,
                    id: null,
                    language_id: null,
                    preferred: false,
                    text: null,
                    // TODO: Find out how to add new terms without resetting the terms state.
                    inEdit: true
                };
                this.terms.push(newTerm);
            },
            searchConcept: function() {
                let vm = this;
                var query = this.$refs.searchQuery.value  // Is there a better way to do this?
                if (this.allTermsSearch) {
                    query += "&all_terms"
                }

                const promise = axios.get(`search?term=${query}`)
                    promise.then(response => {
                    let terms = response.data;
                    let terms_result = terms.map(term => {
                        return {
                            id: term.term_id,
                            concept_id: term.concept_id,
                            term: term.text,
                            category: term.category,
                            preferred: term.preferred
                        };
                    });
                    this.totalRows = response.data.total;
                    this.termSearch = terms_result || [];
                });
            },
            relateConcept: function() {
                let concept_id = this.terms[0].concept_id
                let relation_type = this.relationType

                if(this.selected_concept == '' || relation_type == undefined) {
                    return;
                }

                axios.put(`${this.baseURL}/api/concepts/${concept_id}/relate_concept?related_id=${this.selected_concept}&relation_type=${relation_type}`)
                    .then(function(response) {
                        console.log("related!", response);
                        location.reload();
                    }).catch(function(error) {
                        console.log(error);
                    })
              this.selected_concept = '';
            },
            getConcepts: function() {
                let vm = this;
                const promise = axios.get(`${this.baseURL}/search?term=teach`)
                promise.then(response => {
                    let terms = response.data;
                    let terms_result = terms.map(term => {
                        return {
                            id: term.concept_id,
                            link: "/concepts/"+term.concept_id,
                            term: term.text,
                            category: term.category,
                            preferred: term.preferred
                        };
                    });
                    this.totalRows = response.data.total;
                    this.termSearch = terms_result || [];
                });
            },
            deprecateConcept: function() {
              let concept_id = this.terms[0].concept_id
              let vm = this;
              let url = `${this.baseURL}/api/concepts/${concept_id}/deprecate`;
              if (this.selected_concept != '') {
                url += `?to=${this.selected_concept}`;
              }
              axios.put(url)
                .then(function(response) {
                  console.log("deprecated!", response);
                  vm.deprecated = response.data;
                  vm.$refs['deprecate-modal'].hide();
                }).catch(function(error) {
                  console.log(error);
                });
              this.selected_concept = '';
            },
          deleteConceptSource: function(conceptSourceIndex) {
            this.$delete(this.sources,conceptSourceIndex);
          },
          addSource: function() {
            this.sources.push({"concept_id": this.conceptId, "editMode": true });
          },
          updateSource: function(source, index) {
            Vue.set(this.sources, index, source);
          },
          deleteArchivalScopeNote: function(noteIndex) {
            this.$delete(this.archivalScopeNotes,noteIndex);
          },
          addArchivalScopeNote: function() {
            this.archivalScopeNotes.push({"concept_id": this.conceptId, "editMode": true, "type_id": this.archivalScopeNoteTypeIdProps });
          },
          updateArchivalScopeNote: function(note, index) {
            Vue.set(this.archivalScopeNotes, index, note);
          },
          deleteHistoricalNote: function(noteIndex) {
            this.$delete(this.historicalNotes,noteIndex);
          },
          addHistoricalNote: function() {
            this.historicalNotes.push({"concept_id": this.conceptId, "editMode": true, "type_id": this.historicalNoteTypeIdProps });
          },
          updateHistoricalNote: function(note, index) {
            Vue.set(this.historicalNotes, index, note);
          }
        }
    }
</script>

<style scoped>
    b-input-group {
        min-width: 500px;
        margin-bottom: 50px;
    }

    /* Find why input needs this, fix */
    .input-group-btn button {
        margin-top: -4px;
    }
</style>
