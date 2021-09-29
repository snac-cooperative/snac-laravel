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
Create a Resource
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



<h1>New Resource</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{env('MIX_APP_URL')}}/resources_guided">Resources</a></li>
        <li class="breadcrumb-item">Relations</li>
    </ol>


    <hr>
    <form action="/repositories/create" method="post" style="max-width: 70%">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="description">Repository</label>
            <select class="form-control" name="company">
                <option selected>University of Virginia. Library</option>
                {{-- <option >ArchivalResource</option> --}}
                {{-- <option >BibliographicResource</option> --}}
                {{-- <option >DigitalArchivalResource</option> --}}
                {{-- <option >OralHistoryResource</option> --}}
            </select>
        </div>

        <div class="form-group">
            <label for="description">Resource Type</label>
            <select class="form-control" name="company">
                <option value=""></option>
                <option value="696">ArchivalResource</option>
                <option value="697">BibliographicResource</option>
                <option value="400479">DigitalArchivalResource</option>
                <option value="400623">OralHistoryResource</option>
            </select>
        </div>


        <div class="form-group">
            <label for="title" >Resource Title</label>
            <i v-b-toggle.collapse-1 class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="Full name, unabbreviated" ></i>

            <b-collapse id="collapse-1">
                <b-card style="background-color: #f5f5f5">



                    <p>The title should contain the name of the creator(s) or collector(s) of the collection and the kinds of materials the collection contains (e.g., papers, photographs, correspondence, etc.)</p>
                    <p>e.g. <a href="https://snaccooperative.org/vocab_administrator/resources/7754921">Edgar A. Mearns correspondence</a></p>
                    <p>e.g. Libbie Henrietta Hyman taxonomic records</p>
                    <p>e.g. Harold S. Spencer papers</p>
                    <p>e.g. William E. Speier account book</p>

                    {{-- <p>The <a href="https://www2.archivists.org/groups/technical-subcommittee-on-describing-archives-a-content-standard-dacs/describing-archives-a-content-standard-dacs-second-#:~:text=Describing%20Archives%3A%20A%20Content%20Standard%20(DACS)%20is%20an%20output,applied%20to%20all%20material%20types.&text=The%20current%20edition%20consists%20of,Materials%20and%20Archival%20Authority%20Records.">DACS</a> title of this resource.</p> --}}
                    {{-- <p>Title: The resource title consists of the name of the creator(s) or collector(s) of the collection, along with the nature of materials and the date span, with a bulk date if necessary. Example: Frida Kahlo papers, 1930-1950. Or Frida Kahlo collection of posters, approximately 1940s.</p> --}}
                </b-card>
            </b-collapse>
            <input type="text" value="" class="form-control" id="taskTitle"  name="name" placeholder="e.g. Edgar A. Mearns correspondence">
        </div>


        <div class="form-group">
            <label for="title" >Date</label>
            <i v-b-toggle.collapse-2 class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="" ></i>

            <b-collapse id="collapse-2">
                <b-card style="background-color: #f5f5f5">
                    <p>Earliest and latest The dates of material in this resource. YYYY, YYYY-MM, YYYY-MM-DD formats. For a range, separate with a slash.</p>
                    <p>e.g. 1883-1915</p>
                    <p>e.g. 1785-1960, bulk 1916-1958</p>
                    <p>e.g. approximately 1940s</p>
                    <p>e.g. circa 1935 April</p>
                    <p>e.g. 1956 March 3</p>
                </b-card>
            </b-collapse>
            <input type="text" value="" class="form-control" id="taskTitle"  name="name" placeholder="e.g. 1883-1915">
        </div>

        <div class="form-group" id="link-question">
            <label>Is there a description of the resource available online?</label>
            <br/>
            <label class="radio-inline">
                <input type="radio" name="available-online" onclick="$('#resource-link').slideDown()" >
                Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="available-online" onclick="$('#resource-link').hide();"> No
            </label>
        </div>


        <div class="form-group" id="resource-link" style="display:none">
            <label for="title">Link</label>
            <i v-b-toggle.collapse-link class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="The preferred permanent link to the finding aid or other descriptive resource." ></i>

            <b-collapse id="collapse-link">
                <b-card style="background-color: #f5f5f5">
                    <p>The preferred permanent link to the finding aid, catalog record, or other descriptive resource.</p>
                    {{-- TODO: "Is there a description of the resource available online?"  If Yes, then "What's the link?" or "Please provide a URL" --}}
                </b-card>
            </b-collapse>
            <input type="url" value="" class="form-control" id="taskTitle"  name="name" placeholder="https://full/URL/path">
        </div>

        <div id="access-url" class="form-group" style="display: none">
            <label for="description">Access Policy URL</label>
            <input type="text" value="" class="form-control" id="street_address_1"  name="street_address_1">
        </div>
        <div id="access-input" class="form-group" style="display:none">
            <label for="description">Access Policy</label>
            <i v-b-toggle.collapse-3 class="fa fa-question-circle-o" aria-hidden="false"></i>
            <b-collapse id="collapse-3">
                <b-card style="background-color: #f5f5f5">
                    Consider answering the following questions:
                    <ul>
                        <li>Open to the general public?</li>
                        <li>Not open to public?</li>
                        <li>Researchers must make an appointment?</li>
                        <li>Is an appointment required?</li>
                    </ul>
                    <p>Example: The collection and library are accessible to researchers upon appointment, and material is available for loan to museums and other qualified organizations.</p>
                    <p>Example: The collection is open only to members of the Society and their guests.</p>
                </b-card>
            </b-collapse>

            <input type="text" value="" class="form-control" id="street_address_1"  placeholder=" ">
        </div>



        <div class="form-group">
            <label for="title" >Extent</label>
            <i v-b-toggle.collapse-extent class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="The preferred permanent link to the finding aid or other descriptive resource." ></i>

            <b-collapse id="collapse-extent">
                <b-card style="background-color: #f5f5f5">
                    <p>How big is the collection? What are the containers that hold your material? List the number of containers or estimate how much space they take up.</p>
                    <p>e.g. 6 boxes</p>
                    <p>e.g. 5 linear feet (5 boxes)</p>
                    <p>e.g. 8 cubic feet (9 boxes)</p>
                    <p>e.g. 2 scrapbooks</p>
                    <p>e.g. 5 binders of photographs</p>
                    <p>e.g. 1 case containing 25 optical disks</p>
                    <p>e.g. 1 camera in case</p>

                </b-card>
            </b-collapse>
            <input type="text" value="" class="form-control" id="taskTitle"  name="name" placeholder="">
        </div>

        <div class="form-group" id="access-question">
            <label>Are there any access restrictions on this material?</label>
            <br/>
            <label class="radio-inline">
                <input type="radio" name="access-policy" onclick="$('#access-info').slideDown()" >
                Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="access-policy" onclick="$('#access-info').hide();"> No
            </label>
        </div>

        <div class="form-group" id="access-info" style="display:none">
            <label for="title" >Conditions Governing Access</label>
            <i v-b-toggle.collapse-access class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="The preferred permanent link to the finding aid or other descriptive resource." ></i>
            <b-collapse id="collapse-access">
                <b-card style="background-color: #f5f5f5">
                    <p>Information about access restrictions due to the nature of the information in the materials being described.</p>
                    <p>e.g. Access to glass plate negatives restricted due to fragility.</p>
                    <p>e.g. Personnel records (Boxes 33-36) closed until 2050 due to personal information.</p>
                </b-card>
            </b-collapse>
            <input type="text" value="" class="form-control" id="taskTitle"  name="name" placeholder="">
        </div>


        <div class="form-group">
            <label for="title" >Reference Code</label>
            <i v-b-toggle.collapse-code class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="The preferred permanent link to the finding aid or other descriptive resource." ></i>

            <b-collapse id="collapse-code">
                <b-card style="background-color: #f5f5f5">
                    <p>A unique identifier for the unit being described. The identifier may consist of three subelements: a local identifier, a code for the repository, and a code for the country.</p>
                    {{-- TODO: Questions and inputs for the following:--}}
                    {{-- <p>Are you describing an entire (whole) collection, or a subset (part) of a collection?</p> --}}
                    {{-- <p>If whole, display one text field with the instructions “Please enter the unique identifier of this collection.”</p> --}}
                    {{-- <p>If part, display one text field with the instructions “Please enter the unique identifier of the parent collection” and a second, “If the subset you are describing has a unique identifier, please enter that identifier.”</p> --}}
                </b-card>
            </b-collapse>
            <input type="text" value="" class="form-control" id="taskTitle"  name="name" placeholder="">
        </div>


        <div class="form-group">
            <label for="title">
                Abstract
            </label>
            {{-- <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Brief description of holding institution and scope of collections; may include access information"></i> --}}
            <i v-b-toggle.collapse-4 class="fa fa-question-circle-o" aria-hidden="false"></i>
            <b-collapse id="collapse-4">
                <b-card style="background-color: #f5f5f5">
                    <p>One or two sentences describing what is in the collection.</p>
                </b-card>
            </b-collapse>
            <textarea type="text" value="" class="form-control" id="taskTitle"  name="name"> </textarea>
        </div>

        <br>
        <br>
        <!--  LANGUAGES -->


        {{-- TODO: reference vs archival info --}}

        <div class="form-group" id="link-question">
            <label>Is this resource or collection entirely in English?</label>
            <br/>
            <label class="radio-inline">
                <input type="radio" name="language-question" onclick="$('#language-input').hide()" >
                Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="language-question" onclick="$('#language-input').slideDown();"> No
            </label>
        </div>


        <div class="form-group" id="language-input" style="display:none">
            <i v-b-toggle.collapse-5 class="fa fa-question-circle-o" aria-hidden="false"></i>
            <b-collapse id="collapse-5">
                <b-card style="background-color: #f5f5f5">
                    <p>Language used in the collection.</p>
                </b-card>
            </b-collapse>

            <label for="description">Languages
            </label>
            <br/>
            <language-select :multiple="true"></language-select>
        </div>


        <br>
        <br>

        <button type="button" class="btn btn-primary" onclick="$(this).hide();$('#relations').slideDown()">Save and Continue</button>
        <div id="relations" style="display:none">
            <br>
            <br>
            <h2>Relations</h2>


        <div class="" id="">
                <label>Search for creator</label>
                <br/>
            <div class="row">
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary">Search for Creator</button>
                </div>
                <div class="col-md-4">
                    <a type="button" class="btn btn-success" href="{{env('SNAC_URL')}}/resources_guided">Add Creator to SNAC</a>
                </div>
            </div>

            </div>

        </div>






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
            {{-- <label for="description">General Contact Information</label> --}}
            {{-- <input type="text" value="" class="form-control" id="street_address_1"  placeholder="Phone, email, etc"> --}}
        {{-- </div> --}}
        {{-- <div class="form-group">
            <label for="description">Phone</label>
            <input type="text" value="" class="form-control" id="street_address_1"  placeholder="">
        </div>
        <div class="form-group">
            <label for="description">Email</label>
            <input type="email" value="" class="form-control" id="street_address_1"  placeholder=" ">
        </div> --}}

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
