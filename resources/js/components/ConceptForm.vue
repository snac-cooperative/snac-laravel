<template>
    <div id="concept-table" classname="">
        <div class="form-group">
            <div class="col-xs-8">
                <h2>{{ preferredTerm.text}}</h2>
                <h4>Preferred Term</h4>
                <p v-show="!editMode"> {{preferredTerm.text}}</p>
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
                    <p v-show="!editMode"> {{term.text}}</p>
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

                <div v-show="propertyEditMode" class="mt-3">
                    <h4>Concept Sources</h4>
                    <b-row class='my-1'>

                    <b-input-group class="mt-2">
                        <b-col sm="2">
                        <label for="input-medium">Citation:</label>
                        </b-col>
                        <b-col sm="10">
                        <b-form-input type="text" id="c-prop1"></b-form-input>
                    </b-col>
                    </b-input-group>
                    </b-row>

                    <b-row class='my-1'>

                    <b-input-group class="mt-2">
                        <b-col sm="2">
                        <label for="input-medium">URL:</label>
                        </b-col>
                        <b-col sm="10">
                        <b-form-input type="text" id="c-prop1"></b-form-input>
                    </b-col>
                    </b-input-group>
                    </b-row>

                    <b-row class='my-1'>

                    <b-input-group class="mt-2">
                        <b-col sm="2">
                        <label for="input-medium">Found Data:</label>
                        </b-col>
                        <b-col sm="10">
                        <b-form-input type="text" id="c-prop1"></b-form-input>
                    </b-col>
                    </b-input-group>
                    </b-row>

                    <b-row class='my-1'>

                    <b-input-group class="mt-2">
                        <b-col sm="2">
                        <label for="input-medium">Note:</label>
                        </b-col>
                        <b-col sm="10">
                        <b-form-input type="text" id="c-prop1"></b-form-input>
                    </b-col>
                    </b-input-group>
                    </b-row>

                </div>

                <div class="mt-3">
                    <!-- TODO: Backend calls -->
                    <b-button variant="success" @click="addTerm()" v-show="editMode"><i class="fa fa-plus"></i> Add Term</b-button>
                    <b-button variant="secondary" @click="fetchConcept();toggleEditMode()" v-show="editMode">Cancel</b-button>
                    <b-button variant="primary" @click="toggleEditMode()" v-show="!editMode"><i class="fa fa-edit"></i> Edit</b-button>
                    <b-button variant="primary" @click="togglePropertyEditMode()" v-show="!propertyEditMode"><i class="fa fa-edit"></i> Edit Source</b-button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <h2>Relations</h2>
            <div class="mt-3">
                <b-button v-b-modal.concept-relations-search variant="info"><i class="fa fa-plus"></i> Add Relationship</b-button>
            </div>

            <b-modal
                id="concept-relations-search"
                title="Concept Relations"
                size="xl"
                @ok="relateConcept()"
            >
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
                    <h4>Concept Sources</h4>
                    <div class="mt-1" :key="source.id" v-for="source in sources">
                      <concept-source :concept-id="source.concept_id" :concept-source-id="source.id"></concept-source>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="form-group">
            <h2>Relations</h2>
        </div> -->
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
            }
        },
        data() {
            return {
                // Do we need to make a copy of termProps with slice() or [...this.termProps]?
                terms: this.termProps.map(
                    // populating terms with our custom temporary variables
                    (term) => {term.inEdit = false; return term}
                ),
                sources: this.sourcesProps.map(
                    // populating terms with our custom temporary variables
                    (source) => {source.inEdit = false; return source}
                ),
                editMode: false,
                // concept: this.termProps.slice()
                termSearch: [],
                allTermsSearch: false,
                selected_concept: '',
                relationType: '',
                propertyEditMode: false,
                // populating terms with our custom temporary variables
                // concept: this.termProps.slice()

                categories: [
                    { value:  400833, text: 'Ethnicity'},
                    { value:  400831, text: 'Occupation'},
                    { value:  400830, text: 'Function'},
                    { value:  400829, text: 'Subject'},
                    { value:  400834, text: 'Religion'},
                    { value:  400832, text: 'Relation'},
                ],
                cats: this.conceptProps.concept_categories,
                selectedCategory: this.conceptProps.concept_categories[0].id
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
                fetch('/api/concepts/' + this.terms[0].concept_id).then(data => data.json()).then(data => {
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

                axios.delete(`/api/terms/${term.id}`)
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
                axios.post(`/concepts/${term.concept_id}/add_term`, term) // TODO: Move to an api call
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
                    axios.patch(`/api/terms/${term.id}`, term)
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
            togglePropertyEditMode: function() {
                this.propertyEditMode = !this.propertyEditMode
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

                axios.put(`/api/concepts/${concept_id}/relate_concept?related_id=${this.selected_concept}&relation_type=${relation_type}`)
                    .then(function(response) {
                        console.log("related!", response);
                        location.reload();
                    }).catch(function(error) {
                        console.log(error);
                    })
            },
            getConcepts: function() {
                let vm = this;
                const promise = axios.get(`/search?term=teach`)
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
