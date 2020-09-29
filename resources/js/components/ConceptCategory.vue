<template>
    <div id="concept-table" classname="">
        <div class="form-group">
            <div class="mt-3">
                <h4>Concept Category</h4>
                <b-col cols="4">
                    <b-form-select v-model="selectedCategory" :options="categories"></b-form-select>
                </b-col>
            </div>
        </div>
    </div>
</template>

<script>
// import TermItem from './TermItem.vue';
    export default {
        props: {
            categoriesProps: {
                type: Array
            }

        },
        data() {
            return {
                categories: [
                    { value:  400833, text: 'Ethnicity'},
                    { value:  400831, text: 'Occupation'},
                    { value:  400830, text: 'Function'},
                    { value:  400829, text: 'Subject'},
                    { value:  400834, text: 'Religion'},
                    { value:  400832, text: 'Relation'},
                ],
            }
        }
    }
</script>

<style scoped>
</style>
