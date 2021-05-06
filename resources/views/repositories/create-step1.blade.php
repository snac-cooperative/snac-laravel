@extends ('layouts.snac_layout')

<script>
    function showPhysicalAddress() {

    }
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
            <label for="title">Repository Name</label>
            <input type="text" value="{{{ $repository->repository_name_unauthorized or '' }}}" class="form-control" id="taskTitle"  name="name" placeholder="e.g. Special Collections, University of Virginia">
        </div>
        <div class="form-group">
            <label for="title">Repository Description (optional)</label>
            <textarea type="text" value="{{{ $repository->repository_name_unauthorized or '' }}}" class="form-control" id="taskTitle"  name="name"> </textarea>
        </div>
        <div class="form-group">
            <label for="description">Repository Type</label>
            <select class="form-control" name="company">
                <option {{{ (isset($repository->company) && $repository->company == 'Apple') ? "selected=\"selected\"" : "" }}}></option>
                <option {{{ (isset($repository->company) && $repository->company == 'Apple') ? "selected=\"selected\"" : "" }}}>A</option>
                <option {{{ (isset($repository->company) && $repository->company == 'Google') ? "selected=\"selected\"" : "" }}}>B</option>
                <option {{{ (isset($repository->company) && $repository->company == 'Mi') ? "selected=\"selected\"" : "" }}}>C</option>
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
        <div class="form-group" id="address-question">
            <label for="description">Does this Repository have a physical address?</label><br/>
            <button type='button' class="btn btn-primary" onclick="$('#naddress-question').hide();$('#address-fields').show()">Yes</button>
            <button type='button' class="btn btn-primary" onclick="$('#naddress-question').hide()">No</button>
            {{-- <label onclick="$('#address-question').hide();$('#address-fields').show()" class="radio-inline"><input type="radio" name="available" value="1" {{{ (isset($repository->available) && $repository->available == '1') ? "checked" : "" }}}> Yes</label> --}}
            {{-- <label onclick="$('#address-question').hide()" class="radio-inline"><input type="radio" name="available" value="0" {{{ (isset($repository->available) && $repository->available == '0') ? "checked" : "" }}}> No</label> --}}
        </div>

        {{-- TODO: Add undo/redo  --}}

        <div id="address-fields" style="display:none">
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
            <button type='button' class="btn btn-primary" onclick="$('#website-question').hide();$('#website-fields').show()">Yes</button>
            <button type='button' class="btn btn-primary" onclick="$('#website-question').hide()">No</button>
        </div>

        <div id="website-fields" style="display:none">

            <div class="form-group">
                <label for="description">Website URL</label>
                <input type="text" value="{{{ $repository->street_address_1 or '' }}}" class="form-control" id="street_address_1"  name="street_address_1">
            </div>

        </div>

        <div class="form-group">
            <label for="description">General Contact Information</label>
            <input type="text" value="{{{ $repository->street_address_1 or '' }}}" class="form-control" id="street_address_1"  placeholder="Phone, email, etc">
        </div>

        <br>
        <br>
        <!--  LANGUAGES -->
        <!--  LANGUAGES -->

        {{-- TODO: reference vs archival info --}}
        <div class="form-group" id="language-question">
            <label for="description">What languages are the archival resources described in?</label><br/>
        </div>


        <div class="form-group language-input">
            <label class="control-label col-xs-2" data-content="hello" data-toggle="popover"
                data-placement="top"> Language of Resources</label>
            <div class="col-xs-10">
                <select id="repolang-select" name="repolang" class="form-control" style="width: 100%;"
                    required>
                       <option value=''></option>
                       <option value='eng'>English</option>
   <option value='abk'>Abkhazian</option>
   <option value='ace'>Achinese</option>
   <option value='ach'>Acoli</option>
   <option value='ada'>Adangme</option>
   <option value='ady'>Adyghe; Adygei</option>
   <option value='afa'>Afro-Asiatic languages</option>
   <option value='afh'>Afrihili</option>
   <option value='afr'>Afrikaans</option>
  <option value='ain'>Ainu</option>
  <option value='aka'>Akan</option>
  <option value='akk'>Akkadian</option>
  <option value='alb'>Albanian</option>
  <option value='sqi'>Albanian</option>
  <option value='ale'>Aleut</option>
  <option value='alg'>Algonquian languages</option>
  <option value='alt'>Southern Altai</option>
  <option value='amh'>Amharic</option>
  <option value='ang'>English, Old (ca.450</option>
  <option value='anp'>Angika</option>
  <option value='apa'>Apache languages</option>
  <option value='ara'>Arabic</option>
  <option value='arc'>Official Aramaic (700-300 BCE); Imperial Aramaic (700-300</option>
  <option value='arg'>Aragonese</option>
  <option value='arm'>Armenian</option>
  <option value='hye'>Armenian</option>
  <option value='arn'>Mapudungun; Mapuche</option>
  <option value='arp'>Arapaho</option>
  <option value='art'>Artificial languages</option>
  <option value='arw'>Arawak</option>
  <option value='asm'>Assamese</option>
  <option value='ast'>Asturian; Bable; Leonese; Asturleonese</option>
  <option value='ath'>Athapascan languages</option>
  <option value='aus'>Australian languages</option>
  <option value='ava'>Avaric</option>
  <option value='ave'>Avestan</option>
  <option value='awa'>Awadhi</option>
  <option value='aym'>Aymara</option>
  <option value='aze'>Azerbaijani</option>
  <option value='bad'>Banda languages</option>
  <option value='bai'>Bamileke languages</option>
  <option value='bak'>Bashkir</option>
  <option value='bal'>Baluchi</option>
  <option value='bam'>Bambara</option>
  <option value='ban'>Balinese</option>
  <option value='baq'>Basque</option>
  <option value='eus'>Basque</option>
  <option value='bas'>Basa</option>
  <option value='bat'>Baltic languages</option>
  <option value='bej'>Beja; Bedawiyet</option>
  <option value='bel'>Belarusian</option>
  <option value='bem'>Bemba</option>
  <option value='ben'>Bengali</option>
  <option value='ber'>Berber languages</option>
  <option value='bho'>Bhojpuri</option>
  <option value='bih'>Bihari languages</option>
  <option value='bik'>Bikol</option>
  <option value='bin'>Bini; Edo</option>
  <option value='bis'>Bislama</option>
  <option value='bla'>Siksika</option>
  <option value='bnt'>Bantu (Other</option>
  <option value='bos'>Bosnian</option>
  <option value='bra'>Braj</option>
  <option value='bre'>Breton</option>
  <option value='btk'>Batak languages</option>
  <option value='bua'>Buriat</option>
  <option value='bug'>Buginese</option>
  <option value='bul'>Bulgarian</option>
  <option value='bur'>Burmese</option>
  <option value='mya'>Burmese</option>
  <option value='byn'>Blin; Bilin</option>
  <option value='cad'>Caddo</option>
  <option value='cai'>Central American Indian languages</option>
  <option value='car'>Galibi Carib</option>
  <option value='cat'>Catalan; Valencian</option>
  <option value='cau'>Caucasian languages</option>
  <option value='ceb'>Cebuano</option>
  <option value='cel'>Celtic languages</option>
  <option value='cha'>Chamorro</option>
  <option value='chb'>Chibcha</option>
  <option value='che'>Chechen</option>
  <option value='chg'>Chagatai</option>
  <option value='chi'>Chinese</option>
  <option value='zho'>Chinese</option>
  <option value='chk'>Chuukese</option>
  <option value='chm'>Mari</option>
  <option value='chn'>Chinook jargon</option>
  <option value='cho'>Choctaw</option>
  <option value='chp'>Chipewyan; Dene Suline</option>
  <option value='chr'>Cherokee</option>
  <option value='chu'>Church Slavic; Old Slavonic; Church Slavonic; Old Bulgarian; Old Church Slavonic</option>
  <option value='chv'>Chuvash</option>
  <option value='chy'>Cheyenne</option>
  <option value='cmc'>Chamic languages</option>
  <option value='cop'>Coptic</option>
  <option value='cor'>Cornish</option>
  <option value='cos'>Corsican</option>
  <option value='cpe'>Creoles and pidgins, English based</option>
  <option value='cpf'>Creoles and pidgins, French-based</option>
 <option value='cpp'>Creoles and pidgins, Portuguese-based</option>
 <option value='cre'>Cree</option>
 <option value='crh'>Crimean Tatar; Crimean Turkish</option>
 <option value='crp'>Creoles and pidgins</option>
 <option value='csb'>Kashubian</option>
 <option value='cus'>Cushitic languages</option>
 <option value='cze'>Czech</option>
 <option value='ces'>Czech</option>
 <option value='dak'>Dakota</option>
 <option value='dan'>Danish</option>
 <option value='dar'>Dargwa</option>
 <option value='day'>Land Dayak languages</option>
 <option value='del'>Delaware</option>
 <option value='den'>Slave (Athapascan</option>
 <option value='dgr'>Dogrib</option>
 <option value='din'>Dinka</option>
 <option value='div'>Divehi; Dhivehi; Maldivian</option>
 <option value='doi'>Dogri</option>
 <option value='dra'>Dravidian languages</option>
 <option value='dsb'>Lower Sorbian</option>
 <option value='dua'>Duala</option>
 <option value='dum'>Dutch, Middle (ca.1050</option>
 <option value='dut'>Dutch; Flemish</option>
 <option value='nld'>Dutch; Flemish</option>
 <option value='dyu'>Dyula</option>
 <option value='dzo'>Dzongkha</option>
 <option value='efi'>Efik</option>
 <option value='egy'>Egyptian (Ancient</option>
 <option value='eka'>Ekajuk</option>
 <option value='elx'>Elamite</option>
 <option value='eng'>English</option>
 <option value='enm'>English, Middle (1100</option>
 <option value='epo'>Esperanto</option>
 <option value='est'>Estonian</option>
 <option value='ewe'>Ewe</option>
 <option value='ewo'>Ewondo</option>
 <option value='fan'>Fang</option>
 <option value='fao'>Faroese</option>
 <option value='fat'>Fanti</option>
 <option value='fij'>Fijian</option>
 <option value='fil'>Filipino; Pilipino</option>
 <option value='fin'>Finnish</option>
 <option value='fiu'>Finno-Ugrian languages</option>
 <option value='fon'>Fon</option>
 <option value='fre'>French</option>
 <option value='fra'>French</option>
 <option value='frm'>French, Middle (ca.1400</option>
 <option value='fro'>French, Old (842-ca</option>
 <option value='frr'>Northern Frisian</option>
 <option value='frs'>Eastern Frisian</option>
 <option value='fry'>Western Frisian</option>
 <option value='ful'>Fulah</option>
 <option value='fur'>Friulian</option>
 <option value='gaa'>Ga</option>
 <option value='gay'>Gayo</option>
 <option value='gba'>Gbaya</option>
 <option value='gem'>Germanic languages</option>
 <option value='geo'>Georgian</option>
 <option value='kat'>Georgian</option>
 <option value='ger'>German</option>
 <option value='deu'>German</option>
 <option value='gez'>Geez</option>
 <option value='gil'>Gilbertese</option>
 <option value='gla'>Gaelic; Scottish Gaelic</option>
 <option value='gle'>Irish</option>
 <option value='glg'>Galician</option>
 <option value='glv'>Manx</option>
 <option value='gmh'>German, Middle High (ca.1050</option>
 <option value='goh'>German, Old High (ca.750</option>
 <option value='gon'>Gondi</option>
 <option value='gor'>Gorontalo</option>
 <option value='got'>Gothic</option>
 <option value='grb'>Grebo</option>
 <option value='grc'>Greek, Ancient (to</option>
 <option value='gre'>Greek, Modern (1453-)</option>
 <option value='ell'>Greek, Modern (1453-)</option>
 <option value='grn'>Guarani</option>
 <option value='gsw'>Swiss German; Alemannic; Alsatian</option>
 <option value='guj'>Gujarati</option>
 <option value='gwi'>Gwich'in</option>
 <option value='hai'>Haida</option>
 <option value='hat'>Haitian; Haitian Creole</option>
 <option value='hau'>Hausa</option>
 <option value='haw'>Hawaiian</option>
 <option value='heb'>Hebrew</option>
 <option value='her'>Herero</option>
 <option value='hil'>Hiligaynon</option>
 <option value='him'>Himachali languages; Western Pahari languages</option>
 <option value='hin'>Hindi</option>
 <option value='hit'>Hittite</option>
 <option value='hmn'>Hmong; Mong</option>
 <option value='hmo'>Hiri Motu</option>
 <option value='hrv'>Croatian</option>
 <option value='hsb'>Upper Sorbian</option>
 <option value='hun'>Hungarian</option>
 <option value='hup'>Hupa</option>
 <option value='iba'>Iban</option>
 <option value='ibo'>Igbo</option>
 <option value='ice'>Icelandic</option>
 <option value='isl'>Icelandic</option>
 <option value='ido'>Ido</option>
 <option value='iii'>Sichuan Yi; Nuosu</option>
 <option value='ijo'>Ijo languages</option>
 <option value='iku'>Inuktitut</option>
 <option value='ile'>Interlingue; Occidental</option>
 <option value='ilo'>Iloko</option>
 <option value='ina'>Interlingua (International Auxiliary Language</option>
 <option value='inc'>Indic languages</option>
 <option value='ind'>Indonesian</option>
 <option value='ine'>Indo-European languages</option>
 <option value='inh'>Ingush</option>
 <option value='ipk'>Inupiaq</option>
 <option value='ira'>Iranian languages</option>
 <option value='iro'>Iroquoian languages</option>
 <option value='ita'>Italian</option>
 <option value='jav'>Javanese</option>
 <option value='jbo'>Lojban</option>
 <option value='jpn'>Japanese</option>


 <option value='jbo'>Lojban</option>
 <option value='jpn'>Japanese</option>
 <option value='jpr'>Judeo-Persian</option>
 <option value='jrb'>Judeo-Arabic</option>
 <option value='kaa'>Kara-Kalpak</option>
 <option value='kab'>Kabyle</option>
 <option value='kac'>Kachin; Jingpho</option>
 <option value='kal'>Kalaallisut; Greenlandic</option>
 <option value='kam'>Kamba</option>
 <option value='kan'>Kannada</option>
 <option value='kar'>Karen languages</option>
 <option value='kas'>Kashmiri</option>
 <option value='kau'>Kanuri</option>
 <option value='kaw'>Kawi</option>
 <option value='kaz'>Kazakh</option>
 <option value='kbd'>Kabardian</option>
 <option value='kha'>Khasi</option>
 <option value='khi'>Khoisan languages</option>
 <option value='khm'>Central Khmer</option>
 <option value='kho'>Khotanese; Sakan</option>
 <option value='kik'>Kikuyu; Gikuyu</option>
 <option value='kin'>Kinyarwanda</option>
 <option value='kir'>Kirghiz; Kyrgyz</option>
 <option value='kmb'>Kimbundu</option>
 <option value='kok'>Konkani</option>
 <option value='kom'>Komi</option>
 <option value='kon'>Kongo</option>
 <option value='kor'>Korean</option>
 <option value='kos'>Kosraean</option>
 <option value='kpe'>Kpelle</option>
 <option value='krc'>Karachay-Balkar</option>
 <option value='krl'>Karelian</option>
 <option value='kro'>Kru languages</option>
 <option value='kru'>Kurukh</option>
 <option value='kua'>Kuanyama; Kwanyama</option>
 <option value='kum'>Kumyk</option>
 <option value='kur'>Kurdish</option>
 <option value='kut'>Kutenai</option>
 <option value='lad'>Ladino</option>
 <option value='lah'>Lahnda</option>
 <option value='lam'>Lamba</option>
 <option value='lao'>Lao</option>
 <option value='lat'>Latin</option>
 <option value='lav'>Latvian</option>
 <option value='lez'>Lezghian</option>
 <option value='lim'>Limburgan; Limburger; Limburgish</option>
 <option value='lin'>Lingala</option>
 <option value='lit'>Lithuanian</option>
 <option value='lol'>Mongo</option>
 <option value='loz'>Lozi</option>
 <option value='ltz'>Luxembourgish; Letzeburgesch</option>
 <option value='lua'>Luba-Lulua</option>
 <option value='lub'>Luba-Katanga</option>
 <option value='lug'>Ganda</option>
 <option value='lui'>Luiseno</option>
 <option value='lun'>Lunda</option>
 <option value='luo'>Luo (Kenya and</option>
 <option value='lus'>Lushai</option>
 <option value='mac'>Macedonian</option>
 <option value='mkd'>Macedonian</option>
 <option value='mad'>Madurese</option>
 <option value='mag'>Magahi</option>
 <option value='mah'>Marshallese</option>
 <option value='mai'>Maithili</option>
 <option value='mak'>Makasar</option>
 <option value='mal'>Malayalam</option>
 <option value='man'>Mandingo</option>
 <option value='mao'>Maori</option>
 <option value='mri'>Maori</option>
 <option value='map'>Austronesian languages</option>
 <option value='mar'>Marathi</option>
 <option value='mas'>Masai</option>
 <option value='may'>Malay</option>
 <option value='msa'>Malay</option>
 <option value='mdf'>Moksha</option>
 <option value='mdr'>Mandar</option>
 <option value='men'>Mende</option>
 <option value='mga'>Irish, Middle (900</option>
 <option value='mic'>Mi'kmaq; Micmac</option>
 <option value='min'>Minangkabau</option>
 <option value='mis'>Uncoded languages</option>
 <option value='mkh'>Mon-Khmer languages</option>
 <option value='mlg'>Malagasy</option>
 <option value='mlt'>Maltese</option>
 <option value='mnc'>Manchu</option>
 <option value='mni'>Manipuri</option>
 <option value='mno'>Manobo languages</option>
 <option value='moh'>Mohawk</option>
 <option value='mon'>Mongolian</option>
 <option value='mos'>Mossi</option>
 <option value='mul'>Multiple languages</option>
 <option value='mun'>Munda languages</option>
 <option value='mus'>Creek</option>
 <option value='mwl'>Mirandese</option>
 <option value='mwr'>Marwari</option>
 <option value='myn'>Mayan languages</option>
 <option value='myv'>Erzya</option>
 <option value='nah'>Nahuatl languages</option>
 <option value='nai'>North American Indian languages</option>
 <option value='nap'>Neapolitan</option>
 <option value='nau'>Nauru</option>
 <option value='nav'>Navajo; Navaho</option>
 <option value='nbl'>Ndebele, South; South Ndebele</option>
 <option value='nde'>Ndebele, North; North Ndebele</option>
 <option value='ndo'>Ndonga</option>
 <option value='nds'>Low German; Low Saxon; German, Low; Saxon, Low</option>
 <option value='nep'>Nepali</option>
 <option value='new'>Nepal Bhasa; Newari</option>
 <option value='nia'>Nias</option>
 <option value='nic'>Niger-Kordofanian languages</option>
 <option value='niu'>Niuean</option>
 <option value='nno'>Norwegian Nynorsk; Nynorsk, Norwegian</option>
 <option value='nob'>Bokmål, Norwegian; Norwegian Bokmål</option>
 <option value='nog'>Nogai</option>
 <option value='non'>Norse, Old</option>
 <option value='nor'>Norwegian</option>
 <option value='nqo'>N'Ko</option>
 <option value='nso'>Pedi; Sepedi; Northern Sotho</option>
 <option value='nub'>Nubian languages</option>
 <option value='nwc'>Classical Newari; Old Newari; Classical Nepal Bhasa</option>
 <option value='nya'>Chichewa; Chewa; Nyanja</option>
 <option value='nym'>Nyamwezi</option>
 <option value='nyn'>Nyankole</option>
 <option value='nyo'>Nyoro</option>
 <option value='nzi'>Nzima</option>
 <option value='oci'>Occitan (post 1500); Provençal</option>
 <option value='oji'>Ojibwa</option>
 <option value='ori'>Oriya</option>
 <option value='orm'>Oromo</option>
 <option value='osa'>Osage</option>
 <option value='oss'>Ossetian; Ossetic</option>
 <option value='ota'>Turkish, Ottoman (1500</option>
 <option value='oto'>Otomian languages</option>
 <option value='paa'>Papuan languages</option>
 <option value='pag'>Pangasinan</option>
 <option value='pal'>Pahlavi</option>
 <option value='pam'>Pampanga; Kapampangan</option>
 <option value='pan'>Panjabi; Punjabi</option>
 <option value='pap'>Papiamento</option>
 <option value='pau'>Palauan</option>
 <option value='peo'>Persian, Old (ca.600-400 B.C.)</option>
 <option value='per'>Persian</option>
 <option value='fas'>Persian</option>
 <option value='phi'>Philippine languages</option>
 <option value='phn'>Phoenician</option>
 <option value='pli'>Pali</option>
 <option value='pol'>Polish</option>
 <option value='pon'>Pohnpeian</option>
 <option value='por'>Portuguese</option>
 <option value='pra'>Prakrit languages</option>
 <option value='pro'>Provençal, Old (to</option>
 <option value='pus'>Pushto; Pashto</option>
 <option value='qaa'>    | Reserved for local use</option>
 <option value='que'>Quechua</option>
 <option value='raj'>Rajasthani</option>
 <option value='rap'>Rapanui</option>
 <option value='rar'>Rarotongan; Cook Islands Maori</option>
 <option value='roa'>Romance languages</option>
 <option value='roh'>Romansh</option>
 <option value='rom'>Romany</option>
 <option value='rum'>Romanian; Moldavian; Moldovan</option>
 <option value='ron'>Romanian; Moldavian; Moldovan</option>
 <option value='run'>Rundi</option>
 <option value='rup'>Aromanian; Arumanian; Macedo-Romanian</option>
 <option value='rus'>Russian</option>
 <option value='sad'>Sandawe</option>
 <option value='sag'>Sango</option>
 <option value='sah'>Yakut</option>
 <option value='sai'>South American Indian (Other</option>
 <option value='sal'>Salishan languages</option>
 <option value='sam'>Samaritan Aramaic</option>
 <option value='san'>Sanskrit</option>
 <option value='sas'>Sasak</option>
 <option value='sat'>Santali</option>
 <option value='scn'>Sicilian</option>
 <option value='sco'>Scots</option>
 <option value='sel'>Selkup</option>
 <option value='sem'>Semitic languages</option>
 <option value='sga'>Irish, Old (to</option>
 <option value='sgn'>Sign Languages</option>
 <option value='shn'>Shan</option>
 <option value='sid'>Sidamo</option>
 <option value='sin'>Sinhala; Sinhalese</option>
 <option value='sio'>Siouan languages</option>
 <option value='sit'>Sino-Tibetan languages</option>
 <option value='sla'>Slavic languages</option>
 <option value='slo'>Slovak</option>
 <option value='slk'>Slovak</option>
 <option value='slv'>Slovenian</option>
 <option value='sma'>Southern Sami</option>
 <option value='sme'>Northern Sami</option>
 <option value='smi'>Sami languages</option>
 <option value='smj'>Lule Sami</option>
 <option value='smn'>Inari Sami</option>
 <option value='smo'>Samoan</option>
 <option value='sms'>Skolt Sami</option>
 <option value='sna'>Shona</option>
 <option value='snd'>Sindhi</option>
 <option value='snk'>Soninke</option>
 <option value='sog'>Sogdian</option>
 <option value='som'>Somali</option>
 <option value='son'>Songhai languages</option>
 <option value='sot'>Sotho, Southern</option>
 <option value='spa'>Spanish; Castilian</option>
 <option value='srd'>Sardinian</option>
 <option value='srn'>Sranan Tongo</option>
 <option value='srp'>Serbian</option>
 <option value='srr'>Serer</option>
 <option value='ssa'>Nilo-Saharan languages</option>
 <option value='ssw'>Swati</option>
 <option value='suk'>Sukuma</option>
 <option value='sun'>Sundanese</option>
 <option value='sus'>Susu</option>
 <option value='sux'>Sumerian</option>
 <option value='swa'>Swahili</option>
 <option value='swe'>Swedish</option>
 <option value='syc'>Classical Syriac</option>
 <option value='syr'>Syriac</option>
 <option value='tah'>Tahitian</option>
 <option value='tai'>Tai languages</option>
 <option value='tam'>Tamil</option>
 <option value='tat'>Tatar</option>
 <option value='tel'>Telugu</option>
 <option value='tem'>Timne</option>
 <option value='ter'>Tereno</option>
 <option value='tet'>Tetum</option>
 <option value='tgk'>Tajik</option>
 <option value='tgl'>Tagalog</option>
 <option value='tha'>Thai</option>
 <option value='tib'>Tibetan</option>
 <option value='bod'>Tibetan</option>


 <option value='tib'>Tibetan</option>
 <option value='bod'>Tibetan</option>
 <option value='tig'>Tigre</option>
 <option value='tir'>Tigrinya</option>
 <option value='tiv'>Tiv</option>
 <option value='tkl'>Tokelau</option>
 <option value='tlh'>Klingon; tlhIngan-Hol</option>
 <option value='tli'>Tlingit</option>
 <option value='tmh'>Tamashek</option>
 <option value='tog'>Tonga (Nyasa</option>
 <option value='ton'>Tonga (Tonga</option>
 <option value='tpi'>Tok Pisin</option>
 <option value='tsi'>Tsimshian</option>
 <option value='tsn'>Tswana</option>
 <option value='tso'>Tsonga</option>
 <option value='tuk'>Turkmen</option>
 <option value='tum'>Tumbuka</option>
 <option value='tup'>Tupi languages</option>
 <option value='tur'>Turkish</option>
 <option value='tut'>Altaic languages</option>
 <option value='tvl'>Tuvalu</option>
 <option value='twi'>Twi</option>
 <option value='tyv'>Tuvinian</option>
 <option value='udm'>Udmurt</option>
 <option value='uga'>Ugaritic</option>
 <option value='uig'>Uighur; Uyghur</option>
 <option value='ukr'>Ukrainian</option>
 <option value='umb'>Umbundu</option>
 <option value='und'>Undetermined</option>
 <option value='urd'>Urdu</option>
 <option value='uzb'>Uzbek</option>
 <option value='vai'>Vai</option>
 <option value='ven'>Venda</option>
 <option value='vie'>Vietnamese</option>
 <option value='vol'>Volapük</option>
 <option value='vot'>Votic</option>
 <option value='wak'>Wakashan languages</option>
 <option value='wal'>Walamo</option>
 <option value='war'>Waray</option>
 <option value='was'>Washo</option>
 <option value='wel'>Welsh</option>
 <option value='cym'>Welsh</option>
 <option value='wen'>Sorbian languages</option>
 <option value='wln'>Walloon</option>
 <option value='wol'>Wolof</option>
 <option value='xal'>Kalmyk; Oirat</option>
 <option value='xho'>Xhosa</option>
 <option value='yao'>Yao</option>
 <option value='yap'>Yapese</option>
 <option value='yid'>Yiddish</option>
 <option value='yor'>Yoruba</option>
 <option value='ypk'>Yupik languages</option>
 <option value='zap'>Zapotec</option>
 <option value='zbl'>Blissymbols; Blissymbolics; Bliss</option>
 <option value='zen'>Zenaga</option>
 <option value='zgh'>Standard Moroccan Tamazight</option>
 <option value='zha'>Zhuang; Chuang</option>
 <option value='znd'>Zande languages</option>
 <option value='zul'>Zulu</option>
 <option value='zun'>Zuni</option>
 <option value='zxx'>No linguistic content; Not applicable</option>
 <option value='zza'>Zaza; Dimili; Dimli; Kirdki; Kirmanjki; Zazaki</option>

</select>
</div>

<div>
    <br>
    <button type='button' class="btn btn-success" onclick="$('#website-question').hide();$('#website-fields').show()">Add Language</button>

</div>
<br>
<br>

</div>


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
