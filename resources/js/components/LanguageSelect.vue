<!-- Vue component -->
<template>
  <!-- <div>
    <multiselect v-model="value" :multiple="true" :options="options"></multiselect>
  </div> -->
  <div>
  <!-- <label class="typo__label">Simple select / dropdown</label> -->
  <multiselect v-model="value" :options="options" :multiple="true" :close-on-select="true" :clear-on-select="false" :preserve-search="false" placeholder="Language" label="name" track-by="name" :preselect-first="true">
    <template slot="selection" slot-scope="{ values, search, isOpen }">
      <!-- Replace selected values with another message-->
      <!-- <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen"> -->
        <!-- {{ values.length }} options selected -->
        <!-- </span> -->
      </template>
  </multiselect>
  <!-- Show debugging -->
  <!-- <pre class="language-json"><code>{{ value  }}</code></pre> -->
</div>
</template>

<script>
  import Multiselect from 'vue-multiselect'

  // register globally
  import Vue from 'vue'
  window.Vue = require('vue');
  Vue.component('multiselect', Multiselect)

  export default {
    // OR register locally
    components: { Multiselect },
    data () {
      return {
        value: '',
        options: [
        // { name: 'Vue.js', language: 'JavaScript' },
        // { name: 'Adonis', language: 'JavaScript' },
        // { name: 'Rails', language: 'Ruby' },
        // { name: 'Sinatra', language: 'Ruby' },
        // { name: 'Laravel', language: 'PHP' },
        // { name: 'Phoenix', language: 'Elixir' }
          {language:'eng', name:  "English" },
          {language:'abk', name:  "Abkhazian" },
          {language:'ace', name:  "Achinese" },
          {language:'ach', name:  "Acoli" },
          {language:'ada', name:  "Adangme" },
          {language:'ady', name:  "Adyghe; Adygei" },
          {language:'afa', name:  "Afro-Asiatic languages" },
          {language:'afh', name:  "Afrihili" },
          {language:'afr', name:  "Afrikaans" },
          {language:'ain', name:  "Ainu" },
          {language:'aka', name:  "Akan" },
          {language:'akk', name:  "Akkadian" },
          {language:'alb', name:  "Albanian" },
          {language:'sqi', name:  "Albanian" },
          {language:'ale', name:  "Aleut" },
          {language:'alg', name:  "Algonquian languages" },
          {language:'alt', name:  "Southern Altai" },
          {language:'amh', name:  "Amharic" },
          {language:'ang', name:  "English, Old (ca.450" },
          {language:'anp', name:  "Angika" },
          {language:'apa', name:  "Apache languages" },
          {language:'ara', name:  "Arabic" },
          {language:'arc', name:  "Official Aramaic (700-300 BCE); Imperial Aramaic (700-300)" },
          {language:'arg', name:  "Aragonese" },
          {language:'arm', name:  "Armenian" },
          {language:'hye', name:  "Armenian" },
          {language:'arn', name:  "Mapudungun; Mapuche" },
          {language:'arp', name:  "Arapaho" },
          {language:'art', name:  "Artificial languages" },
          {language:'arw', name:  "Arawak" },
          {language:'asm', name:  "Assamese" },
          {language:'ast', name:  "Asturian; Bable; Leonese; Asturleonese" },
          {language:'ath', name:  "Athapascan languages" },
          {language:'aus', name:  "Australian languages" },
          {language:'ava', name:  "Avaric" },
          {language:'ave', name:  "Avestan" },
          {language:'awa', name:  "Awadhi" },
          {language:'aym', name:  "Aymara" },
          {language:'aze', name:  "Azerbaijani" },
          {language:'bad', name:  "Banda languages" },
          {language:'bai', name:  "Bamileke languages" },
          {language:'bak', name:  "Bashkir" },
          {language:'bal', name:  "Baluchi" },
          {language:'bam', name:  "Bambara" },
          {language:'ban', name:  "Balinese" },
          {language:'baq', name:  "Basque" },
          {language:'eus', name:  "Basque" },
          {language:'bas', name:  "Basa" },
          {language:'bat', name:  "Baltic languages" },
          {language:'bej', name:  "Beja; Bedawiyet" },
          {language:'bel', name:  "Belarusian" },
          {language:'bem', name:  "Bemba" },
          {language:'ben', name:  "Bengali" },
          {language:'ber', name:  "Berber languages" },
          {language:'bho', name:  "Bhojpuri" },
          {language:'bih', name:  "Bihari languages" },
          {language:'bik', name:  "Bikol" },
          {language:'bin', name:  "Bini; Edo" },
          {language:'bis', name:  "Bislama" },
          {language:'bla', name:  "Siksika" },
          {language:'bnt', name:  "Bantu (Other" },
          {language:'bos', name:  "Bosnian" },
          {language:'bra', name:  "Braj" },
          {language:'bre', name:  "Breton" },
          {language:'btk', name:  "Batak languages" },
          {language:'bua', name:  "Buriat" },
          {language:'bug', name:  "Buginese" },
          {language:'bul', name:  "Bulgarian" },
          {language:'bur', name:  "Burmese" },
          {language:'mya', name:  "Burmese" },
          {language:'byn', name:  "Blin; Bilin" },
          {language:'cad', name:  "Caddo" },
          {language:'cai', name:  "Central American Indian languages" },
          {language:'car', name:  "Galibi Carib" },
          {language:'cat', name:  "Catalan; Valencian" },
          {language:'cau', name:  "Caucasian languages" },
          {language:'ceb', name:  "Cebuano" },
          {language:'cel', name:  "Celtic languages" },
          {language:'cha', name:  "Chamorro" },
          {language:'chb', name:  "Chibcha" },
          {language:'che', name:  "Chechen" },
          {language:'chg', name:  "Chagatai" },
          {language:'chi', name:  "Chinese" },
          {language:'zho', name:  "Chinese" },
          {language:'chk', name:  "Chuukese" },
          {language:'chm', name:  "Mari" },
          {language:'chn', name:  "Chinook jargon" },
          {language:'cho', name:  "Choctaw" },
          {language:'chp', name:  "Chipewyan; Dene Suline" },
          {language:'chr', name:  "Cherokee" },
          {language:'chu', name:  "Church Slavic; Old Slavonic; Church Slavonic; Old Bulgarian; Old Church Slavonic" },
          {language:'chv', name:  "Chuvash" },
          {language:'chy', name:  "Cheyenne" },
          {language:'cmc', name:  "Chamic languages" },
          {language:'cop', name:  "Coptic" },
          {language:'cor', name:  "Cornish" },
          {language:'cos', name:  "Corsican" },
          {language:'cpe', name:  "Creoles and pidgins, English based" },
          {language:'cpf', name:  "Creoles and pidgins, French-based" },
          {language:'cpp', name:  "Creoles and pidgins, Portuguese-based" },
          {language:'cre', name:  "Cree" },
          {language:'crh', name:  "Crimean Tatar; Crimean Turkish" },
          {language:'crp', name:  "Creoles and pidgins" },
          {language:'csb', name:  "Kashubian" },
          {language:'cus', name:  "Cushitic languages" },
          {language:'cze', name:  "Czech" },
          {language:'ces', name:  "Czech" },
          {language:'dak', name:  "Dakota" },
          {language:'dan', name:  "Danish" },
          {language:'dar', name:  "Dargwa" },
          {language:'day', name:  "Land Dayak languages" },
          {language:'del', name:  "Delaware" },
          {language:'den', name:  "Slave (Athapascan" },
          {language:'dgr', name:  "Dogrib" },
          {language:'din', name:  "Dinka" },
          {language:'div', name:  "Divehi; Dhivehi; Maldivian" },
          {language:'doi', name:  "Dogri" },
          {language:'dra', name:  "Dravidian languages" },
          {language:'dsb', name:  "Lower Sorbian" },
          {language:'dua', name:  "Duala" },
          {language:'dum', name:  "Dutch, Middle (ca.1050" },
          {language:'dut', name:  "Dutch; Flemish" },
          {language:'nld', name:  "Dutch; Flemish" },
          {language:'dyu', name:  "Dyula" },
          {language:'dzo', name:  "Dzongkha" },
          {language:'efi', name:  "Efik" },
          {language:'egy', name:  "Egyptian (Ancient" },
          {language:'eka', name:  "Ekajuk" },
          {language:'elx', name:  "Elamite" },
          {language:'eng', name:  "English" },
          {language:'enm', name:  "English, Middle (1100" },
          {language:'epo', name:  "Esperanto" },
          {language:'est', name:  "Estonian" },
          {language:'ewe', name:  "Ewe" },
          {language:'ewo', name:  "Ewondo" },
          {language:'fan', name:  "Fang" },
          {language:'fao', name:  "Faroese" },
          {language:'fat', name:  "Fanti" },
          {language:'fij', name:  "Fijian" },
          {language:'fil', name:  "Filipino; Pilipino" },
          {language:'fin', name:  "Finnish" },
          {language:'fiu', name:  "Finno-Ugrian languages" },
          {language:'fon', name:  "Fon" },
          {language:'fre', name:  "French" },
          {language:'fra', name:  "French" },
          {language:'frm', name:  "French, Middle (ca.1400" },
          {language:'fro', name:  "French, Old (842-ca" },
          {language:'frr', name:  "Northern Frisian" },
          {language:'frs', name:  "Eastern Frisian" },
          {language:'fry', name:  "Western Frisian" },
          {language:'ful', name:  "Fulah" },
          {language:'fur', name:  "Friulian" },
          {language:'gaa', name:  "Ga" },
          {language:'gay', name:  "Gayo" },
          {language:'gba', name:  "Gbaya" },
          {language:'gem', name:  "Germanic languages" },
          {language:'geo', name:  "Georgian" },
          {language:'kat', name:  "Georgian" },
          {language:'ger', name:  "German" },
          {language:'deu', name:  "German" },
          {language:'gez', name:  "Geez" },
          {language:'gil', name:  "Gilbertese" },
          {language:'gla', name:  "Gaelic; Scottish Gaelic" },
          {language:'gle', name:  "Irish" },
          {language:'glg', name:  "Galician" },
          {language:'glv', name:  "Manx" },
          {language:'gmh', name:  "German, Middle High (ca.1050" },
          {language:'goh', name:  "German, Old High (ca.750" },
          {language:'gon', name:  "Gondi" },
          {language:'gor', name:  "Gorontalo" },
          {language:'got', name:  "Gothic" },
          {language:'grb', name:  "Grebo" },
          {language:'grc', name:  "Greek, Ancient (to" },
          {language:'gre', name:  "Greek, Modern (1453-)" },
          {language:'ell', name:  "Greek, Modern (1453-)" },
          {language:'grn', name:  "Guarani" },
          {language:'gsw', name:  "Swiss German; Alemannic; Alsatian" },
          {language:'guj', name:  "Gujarati" },
          {language:'gwi', name:  "Gwich'in" },
          {language:'hai', name:  "Haida" },
          {language:'hat', name:  "Haitian; Haitian Creole" },
          {language:'hau', name:  "Hausa" },
          {language:'haw', name:  "Hawaiian" },
          {language:'heb', name:  "Hebrew" },
          {language:'her', name:  "Herero" },
          {language:'hil', name:  "Hiligaynon" },
          {language:'him', name:  "Himachali languages; Western Pahari languages" },
          {language:'hin', name:  "Hindi" },
          {language:'hit', name:  "Hittite" },
          {language:'hmn', name:  "Hmong; Mong" },
          {language:'hmo', name:  "Hiri Motu" },
          {language:'hrv', name:  "Croatian" },
          {language:'hsb', name:  "Upper Sorbian" },
          {language:'hun', name:  "Hungarian" },
          {language:'hup', name:  "Hupa" },
          {language:'iba', name:  "Iban" },
          {language:'ibo', name:  "Igbo" },
          {language:'ice', name:  "Icelandic" },
          {language:'isl', name:  "Icelandic" },
          {language:'ido', name:  "Ido" },
          {language:'iii', name:  "Sichuan Yi; Nuosu" },
          {language:'ijo', name:  "Ijo languages" },
          {language:'iku', name:  "Inuktitut" },
          {language:'ile', name:  "Interlingue; Occidental" },
          {language:'ilo', name:  "Iloko" },
          {language:'ina', name:  "Interlingua (International Auxiliary Language" },
          {language:'inc', name:  "Indic languages" },
          {language:'ind', name:  "Indonesian" },
          {language:'ine', name:  "Indo-European languages" },
          {language:'inh', name:  "Ingush" },
          {language:'ipk', name:  "Inupiaq" },
          {language:'ira', name:  "Iranian languages" },
          {language:'iro', name:  "Iroquoian languages" },
          {language:'ita', name:  "Italian" },
          {language:'jav', name:  "Javanese" },
          {language:'jbo', name:  "Lojban" },
          {language:'jpn', name:  "Japanese" },
          {language:'jbo', name:  "Lojban" },
          {language:'jpn', name:  "Japanese" },
          {language:'jpr', name:  "Judeo-Persian" },
          {language:'jrb', name:  "Judeo-Arabic" },
          {language:'kaa', name:  "Kara-Kalpak" },
          {language:'kab', name:  "Kabyle" },
          {language:'kac', name:  "Kachin; Jingpho" },
          {language:'kal', name:  "Kalaallisut; Greenlandic" },
          {language:'kam', name:  "Kamba" },
          {language:'kan', name:  "Kannada" },
          {language:'kar', name:  "Karen languages" },
          {language:'kas', name:  "Kashmiri" },
          {language:'kau', name:  "Kanuri" },
          {language:'kaw', name:  "Kawi" },
          {language:'kaz', name:  "Kazakh" },
          {language:'kbd', name:  "Kabardian" },
          {language:'kha', name:  "Khasi" },
          {language:'khi', name:  "Khoisan languages" },
          {language:'khm', name:  "Central Khmer" },
          {language:'kho', name:  "Khotanese; Sakan" },
          {language:'kik', name:  "Kikuyu; Gikuyu" },
          {language:'kin', name:  "Kinyarwanda" },
          {language:'kir', name:  "Kirghiz; Kyrgyz" },
          {language:'kmb', name:  "Kimbundu" },
          {language:'kok', name:  "Konkani" },
          {language:'kom', name:  "Komi" },
          {language:'kon', name:  "Kongo" },
          {language:'kor', name:  "Korean" },
          {language:'kos', name:  "Kosraean" },
          {language:'kpe', name:  "Kpelle" },
          {language:'krc', name:  "Karachay-Balkar" },
          {language:'krl', name:  "Karelian" },
          {language:'kro', name:  "Kru languages" },
          {language:'kru', name:  "Kurukh" },
          {language:'kua', name:  "Kuanyama; Kwanyama" },
          {language:'kum', name:  "Kumyk" },
          {language:'kur', name:  "Kurdish" },
          {language:'kut', name:  "Kutenai" },
          {language:'lad', name:  "Ladino" },
          {language:'lah', name:  "Lahnda" },
          {language:'lam', name:  "Lamba" },
          {language:'lao', name:  "Lao" },
          {language:'lat', name:  "Latin" },
          {language:'lav', name:  "Latvian" },
          {language:'lez', name:  "Lezghian" },
          {language:'lim', name:  "Limburgan; Limburger; Limburgish" },
          {language:'lin', name:  "Lingala" },
          {language:'lit', name:  "Lithuanian" },
          {language:'lol', name:  "Mongo" },
          {language:'loz', name:  "Lozi" },
          {language:'ltz', name:  "Luxembourgish; Letzeburgesch" },
          {language:'lua', name:  "Luba-Lulua" },
          {language:'lub', name:  "Luba-Katanga" },
          {language:'lug', name:  "Ganda" },
          {language:'lui', name:  "Luiseno" },
          {language:'lun', name:  "Lunda" },
          {language:'luo', name:  "Luo (Kenya and" },
          {language:'lus', name:  "Lushai" },
          {language:'mac', name:  "Macedonian" },
          {language:'mkd', name:  "Macedonian" },
          {language:'mad', name:  "Madurese" },
          {language:'mag', name:  "Magahi" },
          {language:'mah', name:  "Marshallese" },
          {language:'mai', name:  "Maithili" },
          {language:'mak', name:  "Makasar" },
          {language:'mal', name:  "Malayalam" },
          {language:'man', name:  "Mandingo" },
          {language:'mao', name:  "Maori" },
          {language:'mri', name:  "Maori" },
          {language:'map', name:  "Austronesian languages" },
          {language:'mar', name:  "Marathi" },
          {language:'mas', name:  "Masai" },
          {language:'may', name:  "Malay" },
          {language:'msa', name:  "Malay" },
          {language:'mdf', name:  "Moksha" },
          {language:'mdr', name:  "Mandar" },
          {language:'men', name:  "Mende" },
          {language:'mga', name:  "Irish, Middle (900" },
          {language:'mic', name:  "Mi'kmaq; Micmac" },
          {language:'min', name:  "Minangkabau" },
          {language:'mis', name:  "Uncoded languages" },
          {language:'mkh', name:  "Mon-Khmer languages" },
          {language:'mlg', name:  "Malagasy" },
          {language:'mlt', name:  "Maltese" },
          {language:'mnc', name:  "Manchu" },
          {language:'mni', name:  "Manipuri" },
          {language:'mno', name:  "Manobo languages" },
          {language:'moh', name:  "Mohawk" },
          {language:'mon', name:  "Mongolian" },
          {language:'mos', name:  "Mossi" },
          {language:'mul', name:  "Multiple languages" },
          {language:'mun', name:  "Munda languages" },
          {language:'mus', name:  "Creek" },
          {language:'mwl', name:  "Mirandese" },
          {language:'mwr', name:  "Marwari" },
          {language:'myn', name:  "Mayan languages" },
          {language:'myv', name:  "Erzya" },
          {language:'nah', name:  "Nahuatl languages" },
          {language:'nai', name:  "North American Indian languages" },
          {language:'nap', name:  "Neapolitan" },
          {language:'nau', name:  "Nauru" },
          {language:'nav', name:  "Navajo; Navaho" },
          {language:'nbl', name:  "Ndebele, South; South Ndebele" },
          {language:'nde', name:  "Ndebele, North; North Ndebele" },
          {language:'ndo', name:  "Ndonga" },
          {language:'nds', name:  "Low German; Low Saxon; German, Low; Saxon, Low" },
          {language:'nep', name:  "Nepali" },
          {language:'new', name:  "Nepal Bhasa; Newari" },
          {language:'nia', name:  "Nias" },
          {language:'nic', name:  "Niger-Kordofanian languages" },
          {language:'niu', name:  "Niuean" },
          {language:'nno', name:  "Norwegian Nynorsk; Nynorsk, Norwegian" },
          {language:'nob', name:  "Bokmål, Norwegian; Norwegian Bokmål" },
          {language:'nog', name:  "Nogai" },
          {language:'non', name:  "Norse, Old" },
          {language:'nor', name:  "Norwegian" },
          {language:'nqo', name:  "N'Ko" },
          {language:'nso', name:  "Pedi; Sepedi; Northern Sotho" },
          {language:'nub', name:  "Nubian languages" },
          {language:'nwc', name:  "Classical Newari; Old Newari; Classical Nepal Bhasa" },
          {language:'nya', name:  "Chichewa; Chewa; Nyanja" },
          {language:'nym', name:  "Nyamwezi" },
          {language:'nyn', name:  "Nyankole" },
          {language:'nyo', name:  "Nyoro" },
          {language:'nzi', name:  "Nzima" },
          {language:'oci', name:  "Occitan (post 1500); Provençal" },
          {language:'oji', name:  "Ojibwa" },
          {language:'ori', name:  "Oriya" },
          {language:'orm', name:  "Oromo" },
          {language:'osa', name:  "Osage" },
          {language:'oss', name:  "Ossetian; Ossetic" },
          {language:'ota', name:  "Turkish, Ottoman (1500" },
          {language:'oto', name:  "Otomian languages" },
          {language:'paa', name:  "Papuan languages" },
          {language:'pag', name:  "Pangasinan" },
          {language:'pal', name:  "Pahlavi" },
          {language:'pam', name:  "Pampanga; Kapampangan" },
          {language:'pan', name:  "Panjabi; Punjabi" },
          {language:'pap', name:  "Papiamento" },
          {language:'pau', name:  "Palauan" },
          {language:'peo', name:  "Persian, Old (ca.600-400 B.C.)" },
          {language:'per', name:  "Persian" },
          {language:'fas', name:  "Persian" },
          {language:'phi', name:  "Philippine languages" },
          {language:'phn', name:  "Phoenician" },
          {language:'pli', name:  "Pali" },
          {language:'pol', name:  "Polish" },
          {language:'pon', name:  "Pohnpeian" },
          {language:'por', name:  "Portuguese" },
          {language:'pra', name:  "Prakrit languages" },
          {language:'pro', name:  "Provençal, Old (to" },
          {language:'pus', name:  "Pushto; Pashto" },
          {language:'qaa', name:  "    | Reserved for local use" },
          {language:'que', name:  "Quechua" },
          {language:'raj', name:  "Rajasthani" },
          {language:'rap', name:  "Rapanui" },
          {language:'rar', name:  "Rarotongan; Cook Islands Maori" },
          {language:'roa', name:  "Romance languages" },
          {language:'roh', name:  "Romansh" },
          {language:'rom', name:  "Romany" },
          {language:'rum', name:  "Romanian; Moldavian; Moldovan" },
          {language:'ron', name:  "Romanian; Moldavian; Moldovan" },
          {language:'run', name:  "Rundi" },
          {language:'rup', name:  "Aromanian; Arumanian; Macedo-Romanian" },
          {language:'rus', name:  "Russian" },
          {language:'sad', name:  "Sandawe" },
          {language:'sag', name:  "Sango" },
          {language:'sah', name:  "Yakut" },
          {language:'sai', name:  "South American Indian (Other" },
          {language:'sal', name:  "Salishan languages" },
          {language:'sam', name:  "Samaritan Aramaic" },
          {language:'san', name:  "Sanskrit" },
          {language:'sas', name:  "Sasak" },
          {language:'sat', name:  "Santali" },
          {language:'scn', name:  "Sicilian" },
          {language:'sco', name:  "Scots" },
          {language:'sel', name:  "Selkup" },
          {language:'sem', name:  "Semitic languages" },
          {language:'sga', name:  "Irish, Old (to" },
          {language:'sgn', name:  "Sign Languages" },
          {language:'shn', name:  "Shan" },
          {language:'sid', name:  "Sidamo" },
          {language:'sin', name:  "Sinhala; Sinhalese" },
          {language:'sio', name:  "Siouan languages" },
          {language:'sit', name:  "Sino-Tibetan languages" },
          {language:'sla', name:  "Slavic languages" },
          {language:'slo', name:  "Slovak" },
          {language:'slk', name:  "Slovak" },
          {language:'slv', name:  "Slovenian" },
          {language:'sma', name:  "Southern Sami" },
          {language:'sme', name:  "Northern Sami" },
          {language:'smi', name:  "Sami languages" },
          {language:'smj', name:  "Lule Sami" },
          {language:'smn', name:  "Inari Sami" },
          {language:'smo', name:  "Samoan" },
          {language:'sms', name:  "Skolt Sami" },
          {language:'sna', name:  "Shona" },
          {language:'snd', name:  "Sindhi" },
          {language:'snk', name:  "Soninke" },
          {language:'sog', name:  "Sogdian" },
          {language:'som', name:  "Somali" },
          {language:'son', name:  "Songhai languages" },
          {language:'sot', name:  "Sotho, Southern" },
          {language:'spa', name:  "Spanish; Castilian" },
          {language:'srd', name:  "Sardinian" },
          {language:'srn', name:  "Sranan Tongo" },
          {language:'srp', name:  "Serbian" },
          {language:'srr', name:  "Serer" },
          {language:'ssa', name:  "Nilo-Saharan languages" },
          {language:'ssw', name:  "Swati" },
          {language:'suk', name:  "Sukuma" },
          {language:'sun', name:  "Sundanese" },
          {language:'sus', name:  "Susu" },
          {language:'sux', name:  "Sumerian" },
          {language:'swa', name:  "Swahili" },
          {language:'swe', name:  "Swedish" },
          {language:'syc', name:  "Classical Syriac" },
          {language:'syr', name:  "Syriac" },
          {language:'tah', name:  "Tahitian" },
          {language:'tai', name:  "Tai languages" },
          {language:'tam', name:  "Tamil" },
          {language:'tat', name:  "Tatar" },
          {language:'tel', name:  "Telugu" },
          {language:'tem', name:  "Timne" },
          {language:'ter', name:  "Tereno" },
          {language:'tet', name:  "Tetum" },
          {language:'tgk', name:  "Tajik" },
          {language:'tgl', name:  "Tagalog" },
          {language:'tha', name:  "Thai" },
          {language:'tib', name:  "Tibetan" },
          {language:'bod', name:  "Tibetan" },


          {language:'tib', name:  "Tibetan" },
          {language:'bod', name:  "Tibetan" },
          {language:'tig', name:  "Tigre" },
          {language:'tir', name:  "Tigrinya" },
          {language:'tiv', name:  "Tiv" },
          {language:'tkl', name:  "Tokelau" },
          {language:'tlh', name:  "Klingon; tlhIngan-Hol" },
          {language:'tli', name:  "Tlingit" },
          {language:'tmh', name:  "Tamashek" },
          {language:'tog', name:  "Tonga (Nyasa" },
          {language:'ton', name:  "Tonga (Tonga" },
          {language:'tpi', name:  "Tok Pisin" },
          {language:'tsi', name:  "Tsimshian" },
          {language:'tsn', name:  "Tswana" },
          {language:'tso', name:  "Tsonga" },
          {language:'tuk', name:  "Turkmen" },
          {language:'tum', name:  "Tumbuka" },
          {language:'tup', name:  "Tupi languages" },
          {language:'tur', name:  "Turkish" },
          {language:'tut', name:  "Altaic languages" },
          {language:'tvl', name:  "Tuvalu" },
          {language:'twi', name:  "Twi" },
          {language:'tyv', name:  "Tuvinian" },
          {language:'udm', name:  "Udmurt" },
          {language:'uga', name:  "Ugaritic" },
          {language:'uig', name:  "Uighur; Uyghur" },
          {language:'ukr', name:  "Ukrainian" },
          {language:'umb', name:  "Umbundu" },
          {language:'und', name:  "Undetermined" },
          {language:'urd', name:  "Urdu" },
          {language:'uzb', name:  "Uzbek" },
          {language:'vai', name:  "Vai" },
          {language:'ven', name:  "Venda" },
          {language:'vie', name:  "Vietnamese" },
          {language:'vol', name:  "Volapük" },
          {language:'vot', name:  "Votic" },
          {language:'wak', name:  "Wakashan languages" },
          {language:'wal', name:  "Walamo" },
          {language:'war', name:  "Waray" },
          {language:'was', name:  "Washo" },
          {language:'wel', name:  "Welsh" },
          {language:'cym', name:  "Welsh" },
          {language:'wen', name:  "Sorbian languages" },
          {language:'wln', name:  "Walloon" },
          {language:'wol', name:  "Wolof" },
          {language:'xal', name:  "Kalmyk; Oirat" },
          {language:'xho', name:  "Xhosa" },
          {language:'yao', name:  "Yao" },
          {language:'yap', name:  "Yapese" },
          {language:'yid', name:  "Yiddish" },
          {language:'yor', name:  "Yoruba" },
          {language:'ypk', name:  "Yupik languages" },
          {language:'zap', name:  "Zapotec" },
          {language:'zbl', name:  "Blissymbols; Blissymbolics; Bliss" },
          {language:'zen', name:  "Zenaga" },
          {language:'zgh', name:  "Standard Moroccan Tamazight" },
          {language:'zha', name:  "Zhuang; Chuang" },
          {language:'znd', name:  "Zande languages" },
          {language:'zul', name:  "Zulu" },
          {language:'zun', name:  "Zuni" },
          {language:'zxx', name:  "No linguistic content; Not applicable" },
          {language:'zza', name:  "Zaza; Dimili; Dimli; Kirdki; Kirmanjki; Zazaki" },

        ]
      }
    }
  }
</script>

<!-- New step!
     Add Multiselect CSS. Can be added as a static asset or inside a component. -->
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
  /* your styles */
</style>
