<template>
  <!--TODO: Add Example CPF records:
  Peratrovich, Elizabeth Jean (https://snaccooperative.org/view/28265874)
  Quander Family (https://snaccooperative.org/ark:/99166/w6f58cqk)
  Instituto Laboral de la Raza (https://snaccooperative.org/view/1584971)
  -->
  <div id="concept-table" classname="">
    <!-- TODO: replace header after entityTypeChanges -->
    <h1 id="page-title" ref="title">New Person, Family, or Corporate Body</h1>

    <button
      class="btn btn-primary form-group"
      @click.prevent="entityType = ''"
      v-show="entityType != ''"
    >
      ← Back
    </button>

    <div class="form-group" style="width: 50%" v-show="entityType == ''">
      <!-- <label for="description">Entity Type</label> -->
      <label for=""
        >Do you want to describe a Person, Family, or Corporate Body?</label
      >
      <select class="form-control" name="entityType" v-model="entityType">
        <option value="" selected></option>
        <option value="person">Person</option>
        <option value="family">Family</option>
        <option value="corporateBody">Corporate Body</option>
        --}}
      </select>
    </div>

    <div v-show="entityType == 'person'">
      <div class="form-group">
        <label for="title">Last Name</label>
        <i
          v-b-toggle.collapse-1
          class="fa fa-question-circle-o"
          aria-hidden="true"
          data-toggle="sample-text"
          data-placement="right"
          title="Full name, unabbreviated"
        ></i>
        <b-collapse id="collapse-1">
          <b-card style="background-color: #f5f5f5">
            <p>E.g.</p>
            <ul>
              <li>Jones</li>
              <li>Rodham-Clinton / Clinton</li>
              <li>De la Renta Fiallo</li>
            </ul>
          </b-card>
        </b-collapse>
        <input
          type="text"
          value=""
          class="form-control"
          id="taskTitle"
          name="name"
          placeholder=""
        />
      </div>

      <div class="form-group">
        <label for="title">First and middle name (or initial) </label>
        <i
          v-b-toggle.collapse-2
          class="fa fa-question-circle-o"
          aria-hidden="true"
          data-toggle="sample-text"
          data-placement="right"
          title=""
        ></i>
        <b-collapse id="collapse-2">
          <b-card style="background-color: #f5f5f5">
            <p>E.g.</p>
            <ul>
              <li>Mary S.</li>
              <li>Hilary Rodham</li>
              <li>Óscar Arístides</li>
            </ul>
          </b-card>
        </b-collapse>
        <input
          type="text"
          value=""
          class="form-control"
          id="taskTitle"
          name="name"
          placeholder=""
        />
      </div>

      <div class="form-group">
        <label for="">Other name components</label>
        <i
          v-b-toggle.collapse-3
          class="fa fa-question-circle-o"
          aria-hidden="true"
          data-toggle="sample-text"
          data-placement="right"
          title="Prefixes, suffixes, titles, or other identifying components (excluding dates)"
        ></i>
        <b-collapse id="collapse-3">
          <b-card style="background-color: #f5f5f5">
            <p>
              Prefixes, suffixes, titles, or other identifying components
              (excluding dates)
            </p>
            <p>Examples of suffix:</p>
            <ul>
              <li>Jr.</li>
              <li>III (the third)</li>
            </ul>
            <p>Examples of prefix:</p>
            <ul>
              <li>Mrs.</li>
              <li>Saint</li>
            </ul>
            <p>Identifying component:</p>
            <ul>
              <li>(Carpenter)</li>
              <li>
                Hercules (Chef) <i>[where "(Chef)" is the name addition]</i>
              </li>
            </ul>
          </b-card>
        </b-collapse>
        <input
          type="text"
          value=""
          class="form-control"
          id="taskTitle"
          name="name"
          placeholder="Prefixes, suffixes, titles, etc."
        />
      </div>

      <div class="form-group">
        <label for="title">Date of Birth (if known)</label>
        <i
          v-b-toggle.collapse-4
          class="fa fa-question-circle-o"
          aria-hidden="true"
          data-toggle="sample-text"
          data-placement="right"
          title="Write out date in the format of Month Day Year or MM-DD-YYYY."
        ></i>
        <b-collapse id="collapse-4">
          <b-card style="background-color: #f5f5f5">
            <p>Write out date in the format of Month Day Year or MM-DD-YYYY.</p>
            <p>E.g.</p>
            <ul>
              <li>Jun 5, 2020</li>
              <li>09-12-1982</li>
              <li>January 31, 1809</li>
              <li>Feb 1931</li>
              <li>1760?</li>
            </ul>
          </b-card>
        </b-collapse>
        <input
          type="text"
          value=""
          class="form-control"
          id=""
          name="name"
          placeholder="Month Day Year or MM-DD-YYYY"
          style="width: 50%"
        />
      </div>

      <div class="form-group">
        <label for="title">Date of Death (if known)</label>
        <i
          v-b-toggle.collapse-5
          class="fa fa-question-circle-o"
          aria-hidden="true"
          data-toggle="sample-text"
          data-placement="right"
          title="Write out date in the format of Month Day Year or MM-DD-YYYY."
        ></i>
        <b-collapse id="collapse-5">
          <b-card style="background-color: #f5f5f5">
            <p>Write out date in the format of Month Day Year or MM-DD-YYYY.</p>
            <p>E.g.</p>
            <ul>
              <li>Jun 5, 2020</li>
              <li>09-12-1982</li>
              <li>January 31, 1809</li>
              <li>Feb 1931</li>
              <li>1760?</li>
            </ul>
          </b-card>
        </b-collapse>
        <input
          type="text"
          value=""
          class="form-control"
          id=""
          name="name"
          placeholder="Month Day Year or MM-DD-YYYY"
          style="width: 50%"
        />
      </div>

      <!-- Additional Information -->
      <div class="form-group">
        <label> Any additional information? </label>
        <br />
        <label for="" class="radio-inline">
          <input
            type="radio"
            :value="true"
            name="additional-info"
            v-model="showAdditionalInfo"
          />
          Yes
        </label>
        <label for="" class="radio-inline">
          <input
            type="radio"
            :value="false"
            name="additional-info"
            v-model="showAdditionalInfo"
          />
          No
        </label>
      </div>

      <div v-show="showAdditionalInfo">
        <div class="form-group">
          <!-- TODO: make searchable -->
          <!-- TODO: make repeatable -->
          <label for="">Occupations</label>
          <div class="input-group">
            <input
              name=""
              id="occupations"
              class="form-control"
              type="text"
              placeholder="Search for Occupations"
              :disabled="!showAdditionalInfo"
            />
            <div class="input-group-append">
              <button type="button" class="btn btn-info">Search</button>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="" v-show="entityType == 'person'"
            >Biographical Note</label
          >
          <textarea
            name=""
            id=""
            type="text"
            class="form-control"
            :disabled="!showAdditionalInfo"
          ></textarea>
        </div>
      </div>
    </div>

    <!-- Family -->
    <div v-show="entityType == 'family'">
      <div class="form-group">
        <label for="title">Last Name</label>
        <i
          v-b-toggle.collapse-6
          class="fa fa-question-circle-o"
          aria-hidden="true"
          data-toggle="sample-text"
          data-placement="right"
          title="Full name, unabbreviated"
        ></i>
        <b-collapse id="collapse-6">
          <b-card style="background-color: #f5f5f5">
            <p>E.g.</p>
            <ul>
              <li>Jones</li>
              <li>Rodham-Clinton / Clinton</li>
              <li>De la Renta Fiallo</li>
            </ul>
          </b-card>
        </b-collapse>
        <input
          type="text"
          value=""
          class="form-control"
          id="taskTitle"
          name="name"
          placeholder=""
        />
      </div>

      <div class="form-group">
        <label for="">Family Type</label>
        <select name="" id="" class="form-control">
          <option value=""></option>
          <option value="Clan">Clan</option>
          <option value="Dynasty">Dynasty</option>
          <option value="Family">Family</option>
          <option value="Kindred group">Kindred group</option>
          <option value="Royal house">Royal house</option>
          <option value="Sept">Sept</option>
          <option value="Tribe">Tribe</option>
        </select>
      </div>

      <!-- <div class="form-group">
        <label for="">Places</label>
        <input name="" id="" class="form-control" type="text" placeholder="Search for Places">
      </div> -->

      <div class="form-group">
        <!-- TODO: switch based on computed value -->
        <i
          v-b-toggle.collapse-7
          class="fa fa-question-circle-o"
          aria-hidden="true"
          data-toggle="sample-text"
          data-placement="right"
          title="Full name, unabbreviated"
        ></i>
        <b-collapse id="collapse-7">
          <b-card style="background-color: #f5f5f5">
            <p>
              Describe history of family, including names of prominent members
              and when and where the family lived.
            </p>
          </b-card>
        </b-collapse>
        <label for="" v-show="entityType != 'person'">History Note</label>
        <textarea name="" id="" type="text" class="form-control"></textarea>
      </div>
    </div>

    <!-- CorporateBody -->
    <div v-show="entityType == 'corporateBody'">
      <div class="form-group">
        <label for="title">Organization Name</label>
        <i
          v-b-toggle.collapse-8
          class="fa fa-question-circle-o"
          aria-hidden="true"
          data-toggle="sample-text"
          data-placement="right"
          title="Full name of organization, including name of parent organization, if one exists."
        ></i>
        <b-collapse id="collapse-8">
          <b-card style="background-color: #f5f5f5">
            <p>
              Full name of organization, including name of parent organization,
              if one exists; conference; event; etc.
            </p>
            <p>E.g.</p>
            <ul>
              <li>University of Virginia. Libraries</li>
              <li>Houghton Library</li>
            </ul>

            <p>Conference/Event examples:</p>
            <ul>
              <li>Women’s March on Washington (2017)</li>
              <li>Occupy Wall Street (Movement)</li>
              <li>Lady Franklin Bay Expedition (1881-1884)</li>
              <li>San Diego Comic-Con</li>
            </ul>
          </b-card>
        </b-collapse>
        <input
          type="text"
          value=""
          class="form-control"
          id="taskTitle"
          name="name"
          placeholder=""
        />
      </div>

      <!-- TODO: arrange bioghist display -->
      <!-- BiogHist -->
      <div class="form-group">
        <!-- TODO: switch based on computed value -->

        <label for="" v-show="entityType != 'person'">History Note</label>
        <i
          v-b-toggle.collapse-9
          class="fa fa-question-circle-o"
          aria-hidden="true"
          data-toggle="sample-text"
          data-placement="right"
          title="Full name of organization, including name of parent organization, if one exists."
        ></i>
        <b-collapse id="collapse-9">
          <b-card style="background-color: #f5f5f5">
            <p>
              San Diego Comic-Con International is a comic book convention and
              nonprofit multi-genre entertainment event held annually in San
              Diego, California since 1970.
            </p>
          </b-card>
        </b-collapse>
        <textarea name="" id="" type="text" class="form-control"></textarea>
      </div>
    </div>

    <br />
    <br />

    <!-- Related CPFs -->
    <div class="related-CPFs" v-if="relatedCPFs.length">
      <h3>Related Persons, Families, and Corporate Bodies</h3>
      <table class="table table-hover mt-9">
        <thead>
          <tr>
            <!-- <th></th> -->
            <th>Relation</th>
            <th>Name</th>
          </tr>
        </thead>
        <tbody>
          <tr :key="cpf.id" v-for="cpf in relatedCPFs">
            <!-- <td> <input type="radio" :value="cpf.id" name="relation-select" v-model="selected_entity"></td> -->
            <td>{{ cpf.relationType }}</td>
            <td>
              <a :href="cpf.ark">{{ cpf.name }}</a>
            </td>
            <td>
              <button class="btn btn-danger" v-on:click="removeCPFRelation()">
                X
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <b-modal
      id="concept-relations-search"
      title="Concept Relations"
      size="xl"
      @ok="relateConcept()"
    >
      <!-- ok-title="Create Relationship" -->
      <!-- <form
        id="concept-relationship-form"
        @submit.stop.prevent="searchCPF()">
        <div class="form-group">
          <label for="relation-search">Related Concept</label>
          <div class="input-group mb-3">
            <input id="relation-search" ref="searchQuery" type="text" class="form-control" placeholder="Related Concept" aria-label="Related Concept">
            <div class="input-group-append">
              <button class="btn btn-info" type="button" @click="searchCPF()">Search</button>
            </div>
          </div>
        </div>
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="is-preferred"  title="Search only Preferred Terms">
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
        <div class="findme">
          <table class="table table-hover mt-3" v-if="cpfSearch.length">
            <thead>
              <tr>
                <th></th>
                <th>Entity</th>
                <th>ID</th>
              </tr>
            </thead>
            <tbody>
              <tr :key="cpf.id" v-for="(cpf) in cpfSearch">
                <td> <a :href="cpf.ark">{{ cpf.ark}}</a></td>
                <td>{{ cpf.name }}</td>
                <td>{{cpf.id}} </td>
              </tr>
            </tbody>
          </table>
        </div>

        <b-button @click="relateConcept()" class="btn btn-info" title="Make Preferred">Relate Concepts <i class="fa fa-floppy-o"></i></b-button>
      </form> -->
    </b-modal>

    <div class="mt-3">
      <b-button
        v-if="true"
        v-b-modal.concept-deprecation-to-search
        variant="primary"
        ><i class="fa fa-search"></i> Relate to another CPF
      </b-button>
    </div>

    <b-modal
      id="concept-deprecation-to-search"
      title="Search For Persons, Families, and Corporate Bodies"
      size="xl"
      @ok="relateCPF()"
      ref="search-CPF-modal"
    >
      <!-- ok-title="Create Relationship" -->
      <form id="concept-relationship-form" @submit.stop.prevent="searchCPF()">
        <div class="form-group">
          <!-- <label for="relation-search">Optional - Search and select the concept that replaces CPF</label> -->
          <div class="input-group mb-3">
            <select
              id="related-entity-search-type"
              ref="searchEntityType"
              class="form-control"
              style="width: 15%"
            >
              <option value="">All Types</option>
              <option value="person">Person</option>
              <option value="family">Family</option>
              <option value="corporateBody">Corporate Body</option>
            </select>
            <input
              id="relation-search"
              ref="searchQuery"
              type="text"
              class="form-control"
              placeholder="Name"
              aria-label="Name"
              style="width: 75%"
            />
            <div class="input-group-append">
              <button class="btn btn-info" type="button" @click="searchCPF()">
                Search
              </button>
            </div>
            <div id="otherOptions" class="text-right" style="margin-top: 15px">
              <span style="padding-right: 5px; font-weight: normal"
                >Return top</span
              >
              <select
                id="searchCount"
                ref="searchCount"
                name="count"
                style="width: 70px"
              >
                <option value="10" selected>10</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>
              <span style="padding-left: 5px; font-weight: normal"
                >matches</span
              >
            </div>
          </div>
        </div>
        <!-- <div class="form-check">
          <input type="checkbox" class="form-check-input" id="is-preferred" v-model="allTermsSearch" title="Search only Preferred Terms">
          <label class="form-check-label" for="is-preferred" >Search non-preferred names</label>
        </div> -->

        <div class="findme">
          <table class="table table-hover mt-9" v-if="cpfSearch.length">
            <thead>
              <tr>
                <th></th>
                <th>Type</th>
                <th>Name</th>
              </tr>
            </thead>
            <tbody>
              <tr :key="cpf.id" v-for="cpf in cpfSearch">
                <td>
                  <input
                    type="radio"
                    :value="cpf.id"
                    name="relation-select"
                    v-model="selected_entity"
                  />
                </td>
                <td>{{ cpf.entityType }}</td>
                <td>
                  <a :href="cpf.ark">{{ cpf.name }}</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="form-group">
          <label for="description">Relation Type</label>
          <select class="form-control" name="" v-model="relationType">
            <option value=""></option>
            <option>associatedWith</option>
            <option>correspondedWith</option>
          </select>
        </div>

        <b-button
          @click="relateCPF()"
          class="btn btn-info"
          title="Make Preferred"
          >Relate CPF <i class="fa fa-floppy-o"></i
        ></b-button>
      </form>
    </b-modal>
  </div>
</template>

<script>
import { categories } from '../config/categories';

export default {
  props: {
    conceptProps: {
      type: Object,
    },
    termProps: {
      type: Array,
    },

    canEditVocabulary: false,
  },
  mounted() {
    console.log('Component Up!');
  },
  data() {
    return {
      entityType: '',
      showAdditionalInfo: false,
      editMode: true,
      cpfSearch: [],
      relatedCPFs: [],
      allTermsSearch: true,
      selected_entity: '',
      relationType: '',
      propertyEditMode: true,
      categories,
      isVocabularyEditor: this.canEditVocabulary === 'true',
      baseURL: '',
    };
  },
  computed: {
    displayName() {
      // return
    },
    pageTitle() {
      return;
    },
  },
  methods: {
    searchCPF: function () {
      let vm = this;
      var query = this.$refs.searchQuery.value; // Is there a better way to do this?
      var entityType = this.$refs.searchEntityType.value;
      var searchCount = this.$refs.searchCount.value;
      // https://v3.vuejs.org/guide/component-template-refs.html

      this.cpfSearch = [];
      delete axios.defaults.headers.common['X-Requested-With']; //TODO: find consistent CORS solution
      const promise = axios.put(`http://localhost/~josephglass/snac/rest/`, {
        command: 'search',
        term: `${query}`,
        entity_type: `${entityType}`,
        start: '0',
        count: `${searchCount}`,
        facets: [],
      });
      // const promise = axios.get(`search?term=${query}`)
      // {"command":"search","term":"james","entity_type":"","start":"0","count":"10","facets":[]}

      promise.then((response) => {
        console.log(response.data);
        let cpfs = response.data.results;
        let cpf_result = cpfs.map((cpf) => {
          return {
            id: cpf.id,
            ark: cpf.ark,
            entityType: cpf.entityType.term,
            name: cpf.nameEntries[0].original,
          };
        });
        this.totalRows = response.data.total;
        this.cpfSearch = cpf_result || [];
      });
    },
    relateCPF: function () {
      console.log('related');
      let relation_type = this.relationType;
      // Why is result an observer here?
      let cpfOb = this.cpfSearch.find((cpf) => cpf.id == this.selected_entity);
      let cpf = {};
      cpf.id = cpfOb.id;
      cpf.ark = cpfOb.ark;
      cpf.name = cpfOb.name;
      cpf.relationType = relation_type;
      this.relatedCPFs.push(cpf);
    },
    removeCPFRelation: function () {
      console.log('Remove relation');
      var vm = this;
      vm.relatedCPFs.splice(vm.terms.indexOf(term), 1);
    },
    clearAdditionalInfo: function () {
      // Disable all inputs under showAdditionalInfo
    },
    // relateConcept: function() {
    //   let concept_id = this.terms[0].concept_id
    //   let relation_type = this.relationType

    //   if(this.selected_concept == '' || relation_type == undefined) {
    //     return;
    //   }

    //   axios.put(`${this.baseURL}/api/concepts/${concept_id}/relate_concept?related_id=${this.selected_concept}&relation_type=${relation_type}`)
    //     .then(function(response) {
    //       console.log("related!", response);
    //       location.reload();
    //     }).catch(function(error) {
    //       console.log(error);
    //     })
    //   this.selected_concept = '';
    // },

    //   deleteConceptSource: function(conceptSourceIndex) {
    //   this.$delete(this.sources,conceptSourceIndex);
    //   },
    //   addSource: function() {
    //   this.sources.push({"concept_id": this.conceptId, "editMode": true });
    //   },
    //   updateSource: function(source, index) {
    //   Vue.set(this.sources, index, source);
  },
  watch: {
    entityType: function () {
      this.$refs['title'].innerText =
        this.entityType[0].toUpperCase() + this.entityType.substring(1);
    },
  },
};
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
