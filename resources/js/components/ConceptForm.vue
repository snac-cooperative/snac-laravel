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
                        :class="{'alert-info' : preferredTerm.inEdit, 'alert-danger' : preferredTerm.isDeleted}"
                        :required="true"
                        @change=editTerm(preferredTerm)
                        v-model="preferredTerm.text"
                    >
                    </b-form-input>
                    <b-input-group-append>
                        <!-- <button @click="editTerm(preferredTerm).prevent" class="btn btn-primary" title="Make Preferred"><i class="fa fa-edit"></i></button> -->
                        <button @click="deleteTerm(preferredTerm).prevent" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                    </b-input-group-append>
                    {{count}}
                </b-input-group>
                <!-- DEBUG: {{preferredTerm.inEdit}} -->

                <h4 v-if="alternateTerms.length" class="mt-3">Alternate Terms</h4>
                <div v-bind:key="term.id" v-for="term in alternateTerms">
                    <!-- Extract into Term Component? -->
                    <p v-show="!editMode"> {{term.text}}</p>
                    <b-input-group v-show="editMode" class="mt-2">
                        <b-form-input type="text"
                            :class="{'alert-info' : term.inEdit, 'alert-danger' : term.isDeleted}"
                            :required="true"
                            @change=editTerm(term)
                            v-model="term.text"
                        >
                        </b-form-input>

                        <b-input-group-append>
                            <!-- <button @click="editTerm(term).prevent" class="btn btn-primary" title="Make Preferred"><i :class="[term.inEdit ? 'fa fa-undo' : 'fa fa-edit']"></i></button> -->
                            <b-button @click="" class="btn btn-info" title="Make Preferred"><i class="fa fa-floppy-o"></i></b-button>
                            <b-button @click="makeTermPreferred(term).prevent" class="btn btn-primary" title="Make Preferred"><i class="fa fa-check-square-o"></i></b-button>
                            <b-button @click="deleteTerm(term).prevent" class="btn btn-danger" title="Delete"><i :class="[term.isDeleted ? 'fa fa-undo' : 'fa fa-trash']"></i></b-button>
                        </b-input-group-append>
                        {{count}}
                    </b-input-group>
                    <!--DEBUG: {{term.inEdit}} -->
                    <!-- Extract into Term Component? -->

                </div>
                <div class="mt-3">
                    <b-button variant="success" @click="addTerm()" v-show="editMode"><i class="fa fa-plus"></i> Add Term</b-button>
                    <b-button variant="secondary" @click="fetchConcept();toggleEditMode()" v-show="editMode">Cancel</b-button>
                    <b-button variant="primary" @click="saveConcept();fetchConcept()" v-show="editMode"><i class="glyphicon glyphicon-floppy-disk"></i> Save</b-button>
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
            conceptProps: {
                type: Object
            },
            termProps: {
                type: Array
            }
        },
        data() {
            return {
                terms: this.termProps.map(
                    // populating terms with our custom temporary variables
                    (term) => {term.inEdit = false; term.isDeleted = true; return term}
                ),
                count: 0,
                editMode: false,
                concept: this.termProps.slice()

            }
        },
        computed: {
            alternateTerms() {
                return this.terms.map((term) => {
                    term.inEdit = false;
                    term.isDeleted = false;
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
                // TODO: get concept_ID
                fetch('/api/concepts/' + this.terms[0].concept_id).then(data => data.json()).then(data => {
                    console.log("here you are: ", data)
                    this.terms = data.terms.map(
                        // populating terms with our custom temporary variables
                        (term) => {term.inEdit = false; term.isDeleted = true; return term}
                    )
                })
            },
            saveConcept: function() {
                console.log("Saved!")
            },
            makeTermPreferred: function(term) {
                console.log(`${term.text} is preferred!`, term);
                if (!confirm(`Are you sure you want to make '${term.text}' the preferred term for this concept?`)) {
                    return;
                }
                this.preferredTerm.preferred = false;
                term.preferred = true;
                this.count += 1
            },
            deleteTerm: function(term) {
                console.log(`Deleting ${term.text} with id ${term.id}`)
                term.isDeleted = !term.isDeleted
            },
            editTerm: function(term) {
                console.log(`Editing ${term.text} with id ${term.id}`)
                term.inEdit = true
            },
            toggleEditMode: function() {
                console.log(`Editing Mode toggled!`)
                this.editMode = !this.editMode
            },
            addTerm: function() {
                var newTerm = {
                    concept_id : 2,
                    id: null,
                    language_id: null,
                    preferred: false,
                    text: null,
                    // These new properties below aren't being set. TODO: Find out how to initialize new terms with our extra properties.
                    inEdit: true,
                    inDeleted: false
                }
                this.terms.push(newTerm)
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
