<template>
    <div id="concept-table" v-show="!editMode">
        <div class="form-group">
            <div class="col-xs-8">
                <h2>{{ preferredTerm.text }}<span v-if="deprecated">(deprecated)</span></h2>
                <h4>Preferred Term</h4>
                <p>{{ preferredTerm.text }}</p>

                <h4 v-if="alternateTerms.length" class="mt-3">Alternate Terms</h4>
                <div v-bind:key="term.id" v-for="term in alternateTerms">
                    <!-- Extract into Term Component? -->
                    <p>{{ term.text }}</p>
                    <!-- Extract into Term Component? -->
                </div>

                <div class="mt-3">
                    <b-button variant="primary" @click="toggleEditMode()" v-if="isVocabularyEditor"><i class="fa fa-edit"></i> Edit</b-button>
                </div>

                <div class="mt-3">
                    <h4 v-if="sources.length">Concept Sources</h4>
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
            </div>
        </div>
        <div class="mt-3">
            <b-button v-if="isVocabularyEditor" v-b-modal.concept-relations-search variant="info"><i class="fa fa-plus"></i> Add Relationship</b-button>
        </div>
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
            cats: this.conceptProps.concept_categories,
            selectedCategory: this.conceptProps.concept_categories[0].id,
            isVocabularyEditor: this.canEditVocabulary !== "false",
            baseURL: process.env.MIX_APP_URL,
            devFeatures: process.env.MIX_INCLUDE_DEVELOPMENT_FEATURES == "true"
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

            const oldPreferred = this.preferredTerm;
            oldPreferred.preferred = false;
            term.preferred = true;

            this.saveTerm(oldPreferred);
            this.saveTerm(term);


        },
        deleteTerm: function(term) {
            console.log(`Deleting ${term.text} with id ${term.id}`);
            const vm = this;

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

            const conceptID = this.terms[0].concept_id
            const newTerm = {
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
            let query = this.$refs.searchQuery.value  // Is there a better way to do this?
            if (this.allTermsSearch) {
                query += "&all_terms"
            }

            const promise = axios.get(`search?term=${query}`)
            promise.then(response => {
                const terms = response.data;
                const terms_result = terms.map(term => {
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
            const concept_id = this.terms[0].concept_id
            const relation_type = this.relationType

            if(!this.selected_concept || relation_type === undefined) {
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
            const promise = axios.get(`${this.baseURL}/search?term=teach`)
            promise.then(response => {
                const terms = response.data;
                const terms_result = terms.map(term => {
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
            const concept_id = this.terms[0].concept_id
            const vm = this;
            let url = `${this.baseURL}/api/concepts/${concept_id}/deprecate`;
            if (this.selected_concept) {
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
