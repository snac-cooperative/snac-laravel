/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import { BTable, BPagination, BCol, BFormGroup, BFormSelect } from 'bootstrap-vue';

// BootstrapVue
// TODO: Determine how much of bootstrap-vue we need to include
import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
// BootstrapVue

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('concept', require('./components/Concept.vue').default);
Vue.component('concept-list', require('./components/ConceptList.vue').default);
Vue.component('concept-form', require('./components/ConceptForm.vue').default);
Vue.component('concept-category', require('./components/ConceptCategory.vue').default);
Vue.component('concept-create', require('./components/ConceptCreate.vue').default);
Vue.component('concept-source', require('./components/ConceptSource.vue').default);
Vue.component('concept-search', require('./components/ConceptSearch.vue').default);
Vue.component('term-item', require('./components/TermItem.vue').default);
Vue.component('cpf-form', require('./components/CPFForm.vue').default);
Vue.component('b-table', BTable);
Vue.component('b-pagination', BPagination);
Vue.component('b-col', BCol);
Vue.component('b-form-group', BFormGroup);
Vue.component('b-form-select', BFormSelect);

// Repository Forms
Vue.component('language-select', require('./components/LanguageSelect.vue').default);
Vue.component('repository-form', require('./components/RepositoryForm.vue').default);
Vue.component('radio-question', require('./components/RadioQuestion.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
