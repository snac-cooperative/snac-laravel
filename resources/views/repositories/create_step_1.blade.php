@extends ('layouts.snac_layout')


{{-- <script>
// window.addEventListener('load', function() {
//             $('[data-toggle="tooltip"]').tooltip()
// })
</script> --}}

@section ('title')
Create a Holding Repository
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


<h1>New Holding Repository</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{env('MIX_APP_URL')}}/repositories">Repository</a></li>
        <li class="breadcrumb-item">Address</li>
        <li class="breadcrumb-item">Contact</li>
    </ol>

    <hr>
    <form action="/repositories/create" method="post" style="max-width: 70%;">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title" >Repository Name</label>
            {{-- <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Full name, unabbreviated" ></i> --}}
            <i v-b-toggle.collapse-1 class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="Full name, unabbreviated" ></i>

            <!-- Element to collapse -->
            <b-collapse id="collapse-1">
                <b-card style="background-color: #f5f5f5">
                    <p>Full name, unabbreviated.</p>
                    <p>e.g. Military Women’s Memorial Foundation Collection</p>
                </b-card>
            </b-collapse>
            <input type="text" value="{{ $repository->repository_name_unauthorized or '' }}" class="form-control" id="taskTitle"  name="name" placeholder="e.g. Military Women’s Memorial Foundation Collection">
        </div>
        <div class="form-group">
            <label for="title">
                Description of Holdings (optional)
            </label>
            <i v-b-toggle.collapse-2 class="fa fa-question-circle-o" aria-hidden="false"></i>
            <b-collapse id="collapse-2">
                <b-card style="background-color: #f5f5f5">
                    <p>Brief description of holdings and scope of collections</p>
                    <p>e.g. The Military Women’s Memorial Collections department mission is to collect, preserve, document, analyze, and make available the history of women’s service in and with the US Armed Forces. The Military Women’s Memorial Foundation Collection houses more than 8,000 donations, including photographs, documents, textiles, artifacts, and audiovisual material representing all eras and services of American women’s military history. Resources also include more than 1,500 oral history narratives and a research library of more than 1,500 books by and about military women.</p>
                </b-card>
            </b-collapse>
            <textarea type="text" value="" class="form-control" id="taskTitle"  name="name" placeholder="Brief description of holdings and scope of collections"> </textarea>
        </div>

        <h4>Access Policy</h4>
        <div class="form-group" id="address-question">
            {{-- TODO: Reword question --}}
            <label>Is your Access Policy Online?</label><br/>
            <label class="radio-inline">
                <input type="radio" name="access-policy" onclick="$('#access-input').hide();$('#access-url').slideDown()">
                Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="access-policy" onclick="$('#access-url').hide();$('#access-input').slideDown()"> No
            </label>
        </div>

        <div id="access-url" class="form-group" style="display: none">
            <label for="description">Access Policy URL</label>
            <input type="text" value="{{ $repository->street_address_1 or '' }}" class="form-control" id="street_address_1"  name="street_address_1">
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

            <input type="text" value="{{ $repository->street_address_1 or '' }}" class="form-control" id="street_address_1"  placeholder=" ">
        </div>



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

        <div class="form-group">
            <label for="description">Repository Type</label>
            <i v-b-toggle.collapse-repo-type class="fa fa-question-circle-o" aria-hidden="false"></i>
            <b-collapse id="collapse-repo-type">
                <b-card style="background-color: #f5f5f5">
                    <p><b>College and university archives</b> are archives that preserve materials relating to a specific academic institution. Such archives may also contain a "special collections" division (see definition below).</p>
                    <p>Examples: Stanford University Archives, Mount Holyoke College Archives.</p>
                    <p><b>Community archives</b> are the archives of a group of people that share common interests, and/or social, cultural, or historical heritage, usually created by members of the group being documented and maintained outside of traditional archives.</p>
                    <p>Examples: Invisible Histories Project, Detroit Sound Conservancy</p>
                    <p><b>Corporate archives</b> are archival departments within a company, organization, or corporation that manage and preserve the records of that entity’s activities.</p>
                    <p>Examples: Ford Motor Company Archives, Kraft Foods Archives, Metropolitan Opera archives.</p>
                    <p><b>Digital archives</b> are repositories established solely around digitized and born-digital material, frequently without a physical space. </p>
                    <p>Examples: Jewish Women’s Archive, Theodore Roosevelt Center, Internet Archive</p>
                    <p><b>Genealogical societies</b> are repositories that collect material for family history research.</p>
                    <p>Examples: New England Historic Genealogical Society, Genealogical Society of Utah</p>
                    <p><b>Government archives</b> are repositories that collect materials relating to local, state, national, or international government entities.</p>
                    <p>Examples: The National Archives and Records Administration (NARA), the Franklin D. Roosevelt Presidential Library and Museum, the New York State Archives, City of Boston Archives.</p>
                    <p><b>Historical societies</b> are organizations that seek to preserve and promote interest in the history of a region, a historical period, non-government organizations, or a subject. </p>
                    <p>Examples: The Wisconsin Historical Society, the National Railway Historical Society, the San Fernando Valley Historical Society.</p>
                    <p><b>Museums</b> are places where works of art, scientific specimens, or other objects of permanent value are kept and displayed.</p>
                    <p>Examples: The Metropolitan Museum of Art, Smithsonian National Air and Space Museum.</p>
                    <p><b>Private collections</b> are archives under private ownership. The owner may also be the collector and/or creator.</p>
                    <p>Examples: Walker Library of the History of Human Imagination (Jay Walker, Connecticut); Harlan Crow Library (Harlan Crow, Texas)</p>
                    <p><b>Religious archives</b> are archives relating to the traditions or institutions of a religious group or individual place(s) of worship.</p>
                    <p>Examples: United Methodist Church Archives, American Jewish Archives.</p>
                    <p><b>Special collections</b> are repositories containing materials from individuals, families, and organizations deemed to have significant historical value.</p>
                    <p>Examples: Special Collections Research Center at the University of Chicago, American Philosophical Society Library, Boston Public Library. </p>
                </b-card>
            </b-collapse>

            <select class="form-control" name="company">
                <option></option>
                <option>College and university archives</option>
                <option>Community archives</option>
                <option>Corporate archives</option>
                <option>Digital archives</option>
                <option>Genealogical societies</option>
                <option>Government archives</option>
                <option>Historical societies</option>
                <option>Museums</option>
                <option>Private collections</option>
                <option>Religious archives</option>
                <option>Special collections</option>
            </select>
        </div>
        {{--   RepoData Repository Types:
            College/University
            Community Archives
            Corporation
            Government
            Historical Society/Museum
            K-12
            Museum, Historic Site
            Public Library
            Religious
            Religious Archives
            Tribal
            Tribal Archives
            Unknown
            Multiple (specify in Notes field)
        --}}




        <br>
        <br>
        <h4>Address and Contact</h4>

        <div class="form-group" id="address-question">
            <label for="description">Does this Repository have a physical address?</label><br/>
            {{-- TODO: don't  --}}
            <label class="radio-inline"> <input type='radio' name="address-exists" onclick="$('#address-fields').slideDown()">Yes</label>
            <label class="radio-inline"> <input type='radio' name="address-exists" onclick="$('#address-fields').slideUp()"> No</label>
            {{-- <label onclick="$('#address-question').hide();$('#address-fields').show()" class="radio-inline"><input type="radio" name="available" value="1" {{ (isset($repository->available) && $repository->available == '1') ? "checked" : "" }}> Yes</label> --}}
            {{-- <label onclick="$('#address-question').hide()" class="radio-inline"><input type="radio" name="available" value="0" {{ (isset($repository->available) && $repository->available == '0') ? "checked" : "" }}> No</label> --}}
        </div>


        <div id="address-fields" style="" class="collapse">
            <div class="form-group">
                {{-- TODO: Decide whether to include address placeholders --}}
                <label for="description">Street Address</label>
                <input type="text" value="{{ $repository->street_address_1 or '' }}" class="form-control" id="street_address_1"  name="street_address_1" placeholder="">
            </div>
            <div class="form-group">
                <label for="description">City</label>
                <input type="text" value="" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Postal Code</label>
                <input type="number" value="" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">State/Province</label>
                <input type="text" value="" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Country</label>
                <select class="form-control" name="country">
                    <option value="" selected="selected">Select Country</option>
                    <option value="United States">United States</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="Afghanistan">Afghanistan</option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antarctica">Antarctica</option>
                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Bouvet Island">Bouvet Island</option>
                    <option value="Brazil">Brazil</option>
                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Christmas Island">Christmas Island</option>
                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                    <option value="Cook Islands">Cook Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote D'ivoire">Cote D'ivoire</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                    <option value="Faroe Islands">Faroe Islands</option>
                    <option value="Fiji">Fiji</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="French Guiana">French Guiana</option>
                    <option value="French Polynesia">French Polynesia</option>
                    <option value="French Southern Territories">French Southern Territories</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Greece">Greece</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guinea">Guinea</option>
                    <option value="Guinea-bissau">Guinea-bissau</option>
                    <option value="Guyana">Guyana</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Hungary">Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                    <option value="Korea, Republic of">Korea, Republic of</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Macao">Macao</option>
                    <option value="North Macedonia">North Macedonia</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Namibia">Namibia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                    <option value="New Caledonia">New Caledonia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Norfolk Island">Norfolk Island</option>
                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau">Palau</option>
                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua New Guinea">Papua New Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Pitcairn">Pitcairn</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Reunion">Reunion</option>
                    <option value="Romania">Romania</option>
                    <option value="Russian Federation">Russian Federation</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="Saint Helena">Saint Helena</option>
                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                    <option value="Saint Lucia">Saint Lucia</option>
                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                    <option value="Samoa">Samoa</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="South Africa">South Africa</option>
                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                    <option value="Swaziland">Swaziland</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                    <option value="Taiwan">Taiwan</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Timor-leste">Timor-leste</option>
                    <option value="Togo">Togo</option>
                    <option value="Tokelau">Tokelau</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turkmenistan">Turkmenistan</option>
                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Viet Nam">Viet Nam</option>
                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                    <option value="Western Sahara">Western Sahara</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                </select>
            </div>
        </div>

        <div class="form-group" id="website-question">
            <label for="description">Does this Repository have a website?</label><br/>
            <label class="radio"> <input type='radio' name="website-exists" onclick="$('#ZZZwebsite-question').hide();$('#website-fields').slideDown()"> Yes </label>
            <label class="radio"> <input type='radio' name="website-exists" onclick="$('#ZZZwebsite-question').hide();$('#website-fields').slideUp()"> No </label>
        </div>


        <div id="website-fields" class="collapse">
            <div class="form-group">
                <label for="description">Website URL</label>
                <input type="text" value="" class="form-control" id=""  name="" placeholder="e.g. https://womensmemorial.org/">
            </div>

        </div>

        {{-- <div class="form-group"> --}}
            {{-- Tooltip and placeholder for  website, with HTTPS --}}
            {{-- <label for="description">General Contact Information</label> --}}
            {{-- <input type="text" value="" class="form-control" id="street_address_1"  placeholder="Phone, email, etc"> --}}
        {{-- </div> --}}
        <div class="form-group">
            {{-- Tooltip and placeholder for  website, with HTTPS --}}
            <label for="description">Phone</label>
            <input type="tel" value="" class="form-control" id="phone_number"
                placeholder="(555) 555-5555"
                pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
        </div>
        <div class="form-group">
            {{-- Tooltip and placeholder for  website, with HTTPS --}}
            <label for="description">Email</label>
            <input type="email" value="" class="form-control" id=""  placeholder="">
        </div>



        <br>
        <br>
        <!--  LANGUAGES -->
        {{-- TODO: reference vs archival info --}}
        <div class="form-group" id="language-question">
            <label for="description">What languages are reference services offered in?
                    <i v-b-toggle.collapse-4 class="fa fa-question-circle-o" aria-hidden="false"></i>
                </label><br/>


            <b-collapse id="collapse-4">
                <b-card style="background-color: #f5f5f5">
                    <p>List the languages primarily used in your institution.</p>
                    {{-- TODO: Add link to LoC ISO codes --}}
                    <p>e.g. English, French</p>
                </b-card>
            </b-collapse>
        </div>
        <language-select :multiple="true"></language-select>

        <br>
        <br>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-2">
                {{-- <button type="submit" class="btn btn-primary">Save Repository</button> --}}
                <button type="button" class="btn btn-primary">Save Repository</button>
            </div>
            <div class="col-md-2">
                <a type="button" class="btn btn-success" href="/resources_guided">Add Resources</a>
            </div>
        </div>
        <br>
        <br>
        <br>
    </form>
@endsection