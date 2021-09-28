@extends ('layouts.snac_layout')


<script>


window.addEventListener('load', function() {
            $('[data-toggle="tooltip"]').tooltip()

})

    // $(document).ready(function() {
    //     $('[data-toggle="tooltip"]').tooltip()

    // });
    // $(function () {
    //     $('[data-toggle="tooltip"]').tooltip()
    // })

</script>

@section ('title')
Create an Entity
@endsection
@section ('content')

{{-- <ol class="breadcrumb">
    <li><a href="{{env('SNAC_URL')}}/vocab_administrator/dashboard">Vocabulary</a></li>
    <li>New</li>
</ol>
<div class="row">
    <div class="col-md-8" id="conceptForm">
        <concept-create
        id="conceptCreate"
        >
    </concept-create>
</div>
<br>
</div> --}}


		{{-- <form class="form-horizontal" id="search_form" method="GET" action="?">
			<div class="well well-lg text-center search-box">
                    <input type="hidden" id="count" name="count" value="10">
                    <input type="hidden" id="start" name="start" value="0">
					<div class="input-group select2-bootstrap-append">
                        <span class="search-entity-type">
                            <select id="entityType" name="entity_type" class="search-entity-type-select search-select">
                                <option value="" >All Types</option>
                                <option value="person">Person</option>
                                <option value="corporateBody">Corporate Body</option>
                            <option value="family">Family</option>
                            </select>
                        </span>
						<input type="text" class="form-control search-box-text"
							placeholder="Search for..." id="searchbox" name="term" value="">
                        <span class="input-group-btn search-box-button">
                             <button class="btn btn-default" type="submit" id="searchbutton" name="command" value="search">Search</button>
                        </span>
					</div>
			</div>
		</form> --}}






<h1>New Person, Family, or Corporate Body</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{env('MIX_APP_URL')}}/cpf">Entities</a></li>
        {{-- <li class="breadcrumb-item">Relations</li> --}}
    </ol>


    <hr>
    <form action="/repositories/create" method="post" style="max-width: 70%">
        {{-- TODO: csrf_field --}}


        {{-- EntityType --}}
        {{-- <div class="form-group">
            <label for="description">Entity Type</label>
            <select class="form-control" name="" v-model="entityType">
                <option>Person</option>
                <option>Family</option>
                <option>CorporateBody</option> --}}
                {{-- <option {{ (isset($repository->company) && $repository->company == 'Apple') ? "selected=\"selected\"" : "" }}></option> --}}
                {{-- <option >OralHistoryResource</option> --}}
            {{-- </select>
        </div> --}}





{{-- Person Names  --}}
        {{-- <div v-show="entityType = 'Person'">
            <div class="form-group">
                <label for="title" >Last Name</label>
                <i v-b-toggle.collapse-1 class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="Full name, unabbreviated" ></i>
                <b-collapse id="collapse-1">
                    <b-card style="background-color: #f5f5f5">

                    </b-card>
                </b-collapse>
                <input type="text" value="{{ $repository->repository_name_unauthorized or '' }}" class="form-control" id="taskTitle"  name="name" placeholder="">
            </div>

            <div class="form-group">
                <label for="title" >First Name </label>
                <i v-b-toggle.collapse-1 class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="Full name, unabbreviated" ></i>

                <b-collapse id="collapse-1">
                    <b-card style="background-color: #f5f5f5">
                        <p>The title of this resource.</p>
                    </b-card>
                </b-collapse>
                <input type="text" value="{{ $repository->repository_name_unauthorized or '' }}" class="form-control" id="taskTitle"  name="name" placeholder="">
            </div>
        </div> --}}

{{--  --}}


        {{-- <button type="submit" class="btn btn-primary">Create Relationship</button> --}}

        <cpf-form
            id="cpfShow"
            :cpfprops="true"

            :sources-props="true"
            can-edit-vocabulary="{{ true }}"
        >
        </cpf-form>



        {{-- <div class="form-group">
            <label for="title" ></label>
            <i v-b-toggle.collapse-1 class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="Full name, unabbreviated" ></i>

            <b-collapse id="collapse-1">
                <b-card style="background-color: #f5f5f5">
                    <p>The title of this resource.</p>
                </b-card>
            </b-collapse>
            <input type="text" value="{{ $repository->repository_name_unauthorized or '' }}" class="form-control" id="taskTitle"  name="name" placeholder="">
        </div> --}}


        {{-- <div class="form-group">
            <label for="title" >Date</label>
            <i v-b-toggle.collapse-2 class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="" ></i>

            <b-collapse id="collapse-2">
                <b-card style="background-color: #f5f5f5">
                    <p>The date of this resource</p>

                </b-card>
            </b-collapse>
            <input type="text" value="{{ $repository->repository_name_unauthorized or '' }}" class="form-control" id="taskTitle"  name="name" placeholder="YYYY or YYYY-YYYY">
        </div>

        <div class="form-group">
            <label for="title" >Link</label>
            <i v-b-toggle.collapse-link class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="The preferred permanent link to the finding aid or other descriptive resource." ></i>

            <b-collapse id="collapse-link">
                <b-card style="background-color: #f5f5f5">
                    <p>The preferred permanent link to the finding aid or other descriptive resource.</p>
                </b-card>
            </b-collapse>
            <input type="url" value="{{ $repository->repository_name_unauthorized or '' }}" class="form-control" id="taskTitle"  name="name" placeholder="https://full/URL/path">
        </div>

        <div class="form-group">
            <label for="title" >Extent</label>
            <i v-b-toggle.collapse-extent class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="The preferred permanent link to the finding aid or other descriptive resource." ></i>

            <b-collapse id="collapse-extent">
                <b-card style="background-color: #f5f5f5">
                    <p>The extent of this resource</p>
                </b-card>
            </b-collapse>
            <input type="text" value="{{ $repository->repository_name_unauthorized or '' }}" class="form-control" id="taskTitle"  name="name" placeholder="https://full/URL/path">
        </div>


        <div class="form-group">
            <label for="title">
                Abstract
            </label>
            <i v-b-toggle.collapse-4 class="fa fa-question-circle-o" aria-hidden="false"></i>
            <b-collapse id="collapse-4">
                <b-card style="background-color: #f5f5f5">
                    <p>The abstract of this resource.</p>
                </b-card>
            </b-collapse>
            <textarea type="text" value="{{ $repository->repository_name_unauthorized or '' }}" class="form-control" id="taskTitle"  name="name"> </textarea>
        </div> --}}


        {{-- EXAMPLE COLLAPSE --}}
        {{-- <div>
            <b-button v-b-toggle.collapse-2 class="m-1">Toggle Collapse with modifiers</b-button>
            <b-button v-b-toggle="'collapse-2'" class="m-1">Toggle Collapse with value</b-button>
        </div>
        <div>
            <b-button v-b-toggle:my-collapse>
                <span class="when-open">Close</span><span class="when-closed">Open</span> My Collapse
            </b-button>
            <b-collapse id="my-collapse">
                <h1>hasdfh;sdfhsfd</h1>
            </b-collapse>
        </div> --}}
        {{-- EXAMPLE COLLAPSE --}}



        {{--   RepoData Repository Types:
            College/University
            Community Archives
            Corporation
            Government
            Historical Society/Museum
            K-12
            Museum, Historic Site1
            Public Library
            Religious
            Religious Archives
            Tribal
            Tribal Archives
            Unknown
            Multiple (specify in Notes field)
        --}}



        {{-- <div class="form-group">
            <label for="description">Product Amount</label>
            <input type="text"  value="{{ $repository->amount or '' }}" class="form-control" id="productAmount" name="amount"/>
        </div> --}}
        {{-- <div class="form-group">
            <label for="description">Product Available</label><br/>
            <label class="radio-inline"><input type="radio" name="available" value="1" {{ (isset($repository->available) && $repository->available == '1') ? "checked" : "" }}> Yes</label>
            <label class="radio-inline"><input type="radio" name="available" value="0" {{ (isset($repository->available) && $repository->available == '0') ? "checked" : "" }}> No</label>
        </div> --}}


        {{-- <div class="form-group"> --}}
            {{-- Tooltip and placeholder for  website, with HTTPS --}}
            {{-- <label for="description">General Contact Information</label> --}}
            {{-- <input type="text" value="{{ $repository->street_address_1 or '' }}" class="form-control" id="street_address_1"  placeholder="Phone, email, etc"> --}}
        {{-- </div> --}}
        {{-- <div class="form-group">
            <label for="description">Phone</label>
            <input type="text" value="{{ $repository->street_address_1 or '' }}" class="form-control" id="street_address_1"  placeholder="">
        </div>
        <div class="form-group">
            <label for="description">Email</label>
            <input type="email" value="{{ $repository->street_address_1 or '' }}" class="form-control" id="street_address_1"  placeholder=" ">
        </div> --}}



        {{-- TODO: reference vs archival info --}}
        {{-- <div class="form-group" id="language-question">
            <label for="description">Languages
                <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" data-placement="right" title=""></i>
                </label><br/>
        </div>
        <language-select :multiple="true"></language-select> --}}


{{--
        <div class="form-group language-input">
            <label class="control-label col-xs-2" data-content="hello" data-toggle="popover"
                data-placement="top"> Language of Resources</label>
            <div class="col-xs-10">
                <select id="repolang-select" name="repolang" class="form-control" style="width: 100%;"
                    required>

            </select>
        </div> --}}

<div>
    {{-- <br>
    <button type='button' class="btn btn-success" onclick="$('#website-question').hide();$('#website-fields').show()">Add Language</button> --}}

</div>
<br>
<br>

</div>


{{-- TODO: Access policy  --}}

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- <button type="submit" class="btn btn-primary">Continue</button> --}}
    </form>
@endsection
