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
                        <b-button @click="saveTerm(preferredTerm).prevent" class="btn btn-info" title="Make Preferred"><i class="fa fa-floppy-o"></i></b-button>
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
                            <b-button @click="saveTerm(term).prevent" class="btn btn-info" title="Make Preferred"><i class="fa fa-floppy-o"></i></b-button>
                            <b-button @click="makeTermPreferred(term).prevent" class="btn btn-primary" title="Make Preferred"><i class="fa fa-check-square-o"></i></b-button>
                            <b-button @click="deleteTerm(term).prevent" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></b-button>
                        </b-input-group-append>
                    </b-input-group>
                    <!--DEBUG: {{term.inEdit}} -->
                    <!-- Extract into Term Component? -->

                </div>
                <div class="mt-3">
                    <b-button variant="success" @click="addTerm()" v-show="editMode"><i class="fa fa-plus"></i> Add Term</b-button>
                    <b-button variant="secondary" @click="fetchConcept();toggleEditMode()" v-show="editMode">Cancel</b-button>
                    <b-button variant="primary" @click="toggleEditMode()" v-show="!editMode"><i class="fa fa-edit"></i> Edit</b-button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <h2>Relations</h2>


        </div>
    </div>
</template>

<script>
import TermItem from './TermItem.vue';
    export default {
        props: {
            // conceptProps: {
            //     type: Object
            // },
            termProps: {
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
                editMode: false, // populating terms with our custom temporary variables
                // concept: this.termProps.slice()
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
                axios.post(`/concepts/${term.concept_id}/add_term`, term)
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
                        console.log(response);
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
                console.log(conceptID)
                var newTerm = {
                    concept_id : conceptID,
                    id: null,
                    language_id: null,
                    preferred: false,
                    text: null,
                    // Is the property below being set? TODO: Find out how to add new terms without resetting the terms state.
                    inEdit: true
                };
                this.terms.push(newTerm);
            }
        }
    }
</script>

<style scoped="scoped">
    b-input-group {
        min-width: 500px;
        margin-bottom: 50px;
    }

    /* Find why input needs this, fix */
    .input-group-btn button {
        margin-top: -4px;
    }
</style>
