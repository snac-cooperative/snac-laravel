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
    // function showPhysicalAddress() {

    // }
</script>

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
        <li class="breadcrumb-item active"><a href="{{env('SNAC_URL')}}/repositories">Repository</a></li>
        <li class="breadcrumb-item">Address</li>
        <li class="breadcrumb-item">Contact</li>
    </ol>


    <hr>
    <form action="/repositories/create" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title" >Repository Name</label>
            <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Full name, unabbreviated" ></i>
            {{-- <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="sample-text" data-placement="right" title="Full name, unabbreviated" ></i> --}}
            <input type="text" value="{{{ $repository->repository_name_unauthorized or '' }}}" class="form-control" id="taskTitle"  name="name" placeholder="e.g. Institutional Records and Archives, Getty Research Institute">
        </div>
        <div class="form-group">
            <label for="title">
                Repository Description (optional)
                <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Brief description of holding institution and scope of collections; may include access information"></i>
            </label>
            <textarea type="text" value="{{{ $repository->repository_name_unauthorized or '' }}}" class="form-control" id="taskTitle"  name="name"> </textarea>
        </div>

        <div>
            <!-- Using modifiers -->
            <b-button v-b-toggle.collapse-2 class="m-1">Toggle Collapse</b-button>

            <!-- Using value -->
            <b-button v-b-toggle="'collapse-2'" class="m-1">Toggle Collapse</b-button>

            <!-- Element to collapse -->
            <b-collapse id="collapse-2">
                <b-card>

                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat </p>
                </b-card>
            </b-collapse>
        </div>


        <div>
        <b-button v-b-toggle:my-collapse>
            <span class="when-open">Close</span><span class="when-closed">Open</span> My Collapse
        </b-button>
        <b-collapse id="my-collapse">
            <!-- Content here -->
            <h1>hasdfh;sdfhsfd</h1>
        </b-collapse>
        </div>



        <div class="form-group">
            <label for="description">Repository Type</label>
            <select class="form-control" name="company">
                <option {{{ (isset($repository->company) && $repository->company == 'Apple') ? "selected=\"selected\"" : "" }}}></option>
                <option {{{ (isset($repository->company) && $repository->company == 'Apple') ? "selected=\"selected\"" : "" }}}>Municipal archive</option>
                <option {{{ (isset($repository->company) && $repository->company == 'Google') ? "selected=\"selected\"" : "" }}}>National archive</option>
                <option {{{ (isset($repository->company) && $repository->company == 'Mi') ? "selected=\"selected\"" : "" }}}>Private archive</option>
                <option {{{ (isset($repository->company) && $repository->company == 'Samsung') ? "selected=\"selected\"" : "" }}}>D</option>
            </select>
        </div>
        {{-- <div class="form-group">
            <label for="description">Product Amount</label>
            <input type="text"  value="{{{ $repository->amount or '' }}}" class="form-control" id="productAmount" name="amount"/>
        </div> --}}
        {{-- <div class="form-group">
            <label for="description">Product Available</label><br/>
            <label class="radio-inline"><input type="radio" name="available" value="1" {{{ (isset($repository->available) && $repository->available == '1') ? "checked" : "" }}}> Yes</label>
            <label class="radio-inline"><input type="radio" name="available" value="0" {{{ (isset($repository->available) && $repository->available == '0') ? "checked" : "" }}}> No</label>
        </div> --}}

        <br>
        <br>
        <h4>Address and Contact</h4>

        <div class="form-group" id="address-question">
            <label for="description">Does this Repository have a physical address?</label><br/>
            {{-- TODO: don't  --}}
            <label class="radio-inline"> <input type='radio' name="address-exists" onclick="$('#address-fields').slideDown()">Yes</label>
            <label class="radio-inline"> <input type='radio' name="address-exists" onclick="$('#address-fields').slideUp()">No</label>
            {{-- <label onclick="$('#address-question').hide();$('#address-fields').show()" class="radio-inline"><input type="radio" name="available" value="1" {{{ (isset($repository->available) && $repository->available == '1') ? "checked" : "" }}}> Yes</label> --}}
            {{-- <label onclick="$('#address-question').hide()" class="radio-inline"><input type="radio" name="available" value="0" {{{ (isset($repository->available) && $repository->available == '0') ? "checked" : "" }}}> No</label> --}}
        </div>

        {{-- <div class="form-group" id="ZZZaddress-question">
            <label for="description">Does this Repository have a physical address?</label><br/>
            <button type='button' class="btn btn-primary" onclick="$('#address-question').hide();$('#address-fields').show()">Yes</button>
            <button type='button' class="btn btn-primary" onclick="$('#address-question').hide()">No</button>
        </div> --}}

        {{-- TODO: Add undo/redo  --}}

        <div id="address-fields" style="" class="collapse">
            <div class="form-group">
                <label for="description">Street Address</label>
                <input type="text" value="{{{ $repository->street_address_1 or '' }}}" class="form-control" id="street_address_1"  name="street_address_1">
            </div>
            <div class="form-group">
                <label for="description">City</label>
                <input type="text" value="{{{ $repository->street_address_1 or '' }}}" class="form-control" id="street_address_1"  name="street_address_1">
            </div>
            <div class="form-group">
                <label for="description">Postal Code</label>
                <input type="text" value="{{{ $repository->street_address_1 or '' }}}" class="form-control" id="street_address_1"  name="street_address_1">
            </div>
            <div class="form-group">
                <label for="description">State/Province</label>
                <input type="text" value="{{{ $repository->street_address_1 or '' }}}" class="form-control" id="street_address_1"  name="street_address_1">
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



        {{--  --}}

    {{-- TODO: UNDO/Redo on questions --}}


        <div class="form-group" id="website-question">
            <label for="description">Does this Repository have a Website?</label><br/>
            <label class="radio"> <input type='radio' name="website-exists" onclick="$('#ZZZwebsite-question').hide();$('#website-fields').slideDown()">Yes</label>
            <label class="radio"> <input type='radio' name="website-exists" onclick="$('#ZZZwebsite-question').hide();$('#website-fields').slideUp()">No</label>
        </div>


        <div id="website-fields" class="collapse">

            <div class="form-group">
                <label for="description">Website URL</label>
                <input type="text" value="{{{ $repository->street_address_1 or '' }}}" class="form-control" id="street_address_1"  name="street_address_1">
            </div>

        </div>

        {{-- <div class="form-group"> --}}
            {{-- Tooltip and placeholder for  website, with HTTPS --}}
            {{-- <label for="description">General Contact Information</label> --}}
            {{-- <input type="text" value="{{{ $repository->street_address_1 or '' }}}" class="form-control" id="street_address_1"  placeholder="Phone, email, etc"> --}}
        {{-- </div> --}}
        <div class="form-group">
            {{-- Tooltip and placeholder for  website, with HTTPS --}}
            <label for="description">Phone</label>
            <input type="text" value="{{{ $repository->street_address_1 or '' }}}" class="form-control" id="street_address_1"  placeholder="">
        </div>
        <div class="form-group">
            {{-- Tooltip and placeholder for  website, with HTTPS --}}
            <label for="description">Email</label>
            <input type="text" value="{{{ $repository->street_address_1 or '' }}}" class="form-control" id="street_address_1"  placeholder=" ">
        </div>

        <div class="form-group">
            {{-- Tooltip and placeholder for  website, with HTTPS --}}
            <label for="description">Access Conditions</label>
            <input type="text" value="{{{ $repository->street_address_1 or '' }}}" class="form-control" id="street_address_1"  placeholder=" ">
        </div>

        <br>
        <br>
        <!--  LANGUAGES -->
        <!--  LANGUAGES -->

        {{-- TODO: reference vs archival info --}}
        <div class="form-group" id="language-question">
            <label for="description">What languages are reference services offered in?
                <i class="fa fa-question-circle-o" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="List the languages dominantly used in your institution"></i>
                </label><br/>
        </div>
        <language-select :multiple="true"></language-select>


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
        <button type="submit" class="btn btn-primary">Continue</button>
    </form>
@endsection
