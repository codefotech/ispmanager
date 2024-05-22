<?php
session_start();
include("conn/connection.php") ;
extract($_POST);

$per101 = (isset($_POST['module101'])) ? 1 : 0;
$per102 = (isset($_POST['module102'])) ? 1 : 0;
$per103 = (isset($_POST['module103'])) ? 1 : 0;
$per104 = (isset($_POST['module104'])) ? 1 : 0;
$per105 = (isset($_POST['module105'])) ? 1 : 0;
$per106 = (isset($_POST['module106'])) ? 1 : 0;
$per107 = (isset($_POST['module107'])) ? 1 : 0;
$per108 = (isset($_POST['module108'])) ? 1 : 0;
$per109 = (isset($_POST['module109'])) ? 1 : 0;
$per110 = (isset($_POST['module110'])) ? 1 : 0;
$per111 = (isset($_POST['module111'])) ? 1 : 0;
$per112 = (isset($_POST['module112'])) ? 1 : 0;
$per113 = (isset($_POST['module113'])) ? 1 : 0;
$per114 = (isset($_POST['module114'])) ? 1 : 0;
$per115 = (isset($_POST['module115'])) ? 1 : 0;
$per116 = (isset($_POST['module116'])) ? 1 : 0;
$per117 = (isset($_POST['module117'])) ? 1 : 0;
$per118 = (isset($_POST['module118'])) ? 1 : 0;
$per119 = (isset($_POST['module119'])) ? 1 : 0;
$per120 = (isset($_POST['module120'])) ? 1 : 0;
$per121 = (isset($_POST['module121'])) ? 1 : 0;
$per122 = (isset($_POST['module122'])) ? 1 : 0;
$per123 = (isset($_POST['module123'])) ? 1 : 0;
$per124 = (isset($_POST['module124'])) ? 1 : 0;
$per125 = (isset($_POST['module125'])) ? 1 : 0;
$per126 = (isset($_POST['module126'])) ? 1 : 0;
$per127 = (isset($_POST['module127'])) ? 1 : 0;
$per128 = (isset($_POST['module128'])) ? 1 : 0;
$per129 = (isset($_POST['module129'])) ? 1 : 0;
$per130 = (isset($_POST['module130'])) ? 1 : 0;
$per131 = (isset($_POST['module131'])) ? 1 : 0;
$per132 = (isset($_POST['module132'])) ? 1 : 0;
$per133 = (isset($_POST['module133'])) ? 1 : 0;
$per134 = (isset($_POST['module134'])) ? 1 : 0;
$per135 = (isset($_POST['module135'])) ? 1 : 0;
$per136 = (isset($_POST['module136'])) ? 1 : 0;
$per137 = (isset($_POST['module137'])) ? 1 : 0;
$per138 = (isset($_POST['module138'])) ? 1 : 0;
$per139 = (isset($_POST['module139'])) ? 1 : 0;
$per140 = (isset($_POST['module140'])) ? 1 : 0;
$per141 = (isset($_POST['module141'])) ? 1 : 0;
$per142 = (isset($_POST['module142'])) ? 1 : 0;
$per143 = (isset($_POST['module143'])) ? 1 : 0;
$per144 = (isset($_POST['module144'])) ? 1 : 0;
$per145 = (isset($_POST['module145'])) ? 1 : 0;
$per146 = (isset($_POST['module146'])) ? 1 : 0;
$per147 = (isset($_POST['module147'])) ? 1 : 0;
$per148 = (isset($_POST['module148'])) ? 1 : 0;
$per149 = (isset($_POST['module149'])) ? 1 : 0;
$per150 = (isset($_POST['module150'])) ? 1 : 0;
$per151 = (isset($_POST['module151'])) ? 1 : 0;
$per152 = (isset($_POST['module152'])) ? 1 : 0;
$per153 = (isset($_POST['module153'])) ? 1 : 0;
$per154 = (isset($_POST['module154'])) ? 1 : 0;
$per155 = (isset($_POST['module155'])) ? 1 : 0;
$per156 = (isset($_POST['module156'])) ? 1 : 0;
$per157 = (isset($_POST['module157'])) ? 1 : 0;
$per158 = (isset($_POST['module158'])) ? 1 : 0;
$per159 = (isset($_POST['module159'])) ? 1 : 0;
$per160 = (isset($_POST['module160'])) ? 1 : 0;
$per161 = (isset($_POST['module161'])) ? 1 : 0;
$per162 = (isset($_POST['module162'])) ? 1 : 0;
$per163 = (isset($_POST['module163'])) ? 1 : 0;
$per164 = (isset($_POST['module164'])) ? 1 : 0;
$per165 = (isset($_POST['module165'])) ? 1 : 0;
$per166 = (isset($_POST['module166'])) ? 1 : 0;
$per167 = (isset($_POST['module167'])) ? 1 : 0;
$per168 = (isset($_POST['module168'])) ? 1 : 0;
$per169 = (isset($_POST['module169'])) ? 1 : 0;
$per170 = (isset($_POST['module170'])) ? 1 : 0;
$per171 = (isset($_POST['module171'])) ? 1 : 0;
$per172 = (isset($_POST['module172'])) ? 1 : 0;
$per173 = (isset($_POST['module173'])) ? 1 : 0;
$per174 = (isset($_POST['module174'])) ? 1 : 0;
$per175 = (isset($_POST['module175'])) ? 1 : 0;
$per176 = (isset($_POST['module176'])) ? 1 : 0;
$per177 = (isset($_POST['module177'])) ? 1 : 0;
$per178 = (isset($_POST['module178'])) ? 1 : 0;
$per179 = (isset($_POST['module179'])) ? 1 : 0;
$per180 = (isset($_POST['module180'])) ? 1 : 0;
$per181 = (isset($_POST['module181'])) ? 1 : 0;
$per182 = (isset($_POST['module182'])) ? 1 : 0;
$per183 = (isset($_POST['module183'])) ? 1 : 0;
$per184 = (isset($_POST['module184'])) ? 1 : 0;
$per185 = (isset($_POST['module185'])) ? 1 : 0;
$per186 = (isset($_POST['module186'])) ? 1 : 0;
$per187 = (isset($_POST['module187'])) ? 1 : 0;
$per188 = (isset($_POST['module188'])) ? 1 : 0;
$per189 = (isset($_POST['module189'])) ? 1 : 0;
$per190 = (isset($_POST['module190'])) ? 1 : 0;
$per191 = (isset($_POST['module191'])) ? 1 : 0;
$per192 = (isset($_POST['module192'])) ? 1 : 0;
$per193 = (isset($_POST['module193'])) ? 1 : 0;
$per194 = (isset($_POST['module194'])) ? 1 : 0;
$per195 = (isset($_POST['module195'])) ? 1 : 0;
$per196 = (isset($_POST['module196'])) ? 1 : 0;
$per197 = (isset($_POST['module197'])) ? 1 : 0;
$per198 = (isset($_POST['module198'])) ? 1 : 0;
$per199 = (isset($_POST['module199'])) ? 1 : 0;
$per200 = (isset($_POST['module200'])) ? 1 : 0;
$per201 = (isset($_POST['module201'])) ? 1 : 0;
$per202 = (isset($_POST['module202'])) ? 1 : 0;
$per203 = (isset($_POST['module203'])) ? 1 : 0;
$per204 = (isset($_POST['module204'])) ? 1 : 0;
$per205 = (isset($_POST['module205'])) ? 1 : 0;
$per206 = (isset($_POST['module206'])) ? 1 : 0;
$per207 = (isset($_POST['module207'])) ? 1 : 0;
$per208 = (isset($_POST['module208'])) ? 1 : 0;
$per209 = (isset($_POST['module209'])) ? 1 : 0;
$per210 = (isset($_POST['module210'])) ? 1 : 0;
$per211 = (isset($_POST['module211'])) ? 1 : 0;
$per212 = (isset($_POST['module212'])) ? 1 : 0;
$per213 = (isset($_POST['module213'])) ? 1 : 0;
$per214 = (isset($_POST['module214'])) ? 1 : 0;
$per215 = (isset($_POST['module215'])) ? 1 : 0;
$per216 = (isset($_POST['module216'])) ? 1 : 0;
$per217 = (isset($_POST['module217'])) ? 1 : 0;
$per218 = (isset($_POST['module218'])) ? 1 : 0;
$per219 = (isset($_POST['module219'])) ? 1 : 0;
$per220 = (isset($_POST['module220'])) ? 1 : 0;
$per221 = (isset($_POST['module221'])) ? 1 : 0;
$per222 = (isset($_POST['module222'])) ? 1 : 0;
$per223 = (isset($_POST['module223'])) ? 1 : 0;
$per224 = (isset($_POST['module224'])) ? 1 : 0;
$per225 = (isset($_POST['module225'])) ? 1 : 0;
$per226 = (isset($_POST['module226'])) ? 1 : 0;
$per227 = (isset($_POST['module227'])) ? 1 : 0;
$per228 = (isset($_POST['module228'])) ? 1 : 0;
$per229 = (isset($_POST['module229'])) ? 1 : 0;
$per230 = (isset($_POST['module230'])) ? 1 : 0;
$per231 = (isset($_POST['module231'])) ? 1 : 0;
$per232 = (isset($_POST['module232'])) ? 1 : 0;
$per233 = (isset($_POST['module233'])) ? 1 : 0;
$per234 = (isset($_POST['module234'])) ? 1 : 0;
$per235 = (isset($_POST['module235'])) ? 1 : 0;
$per236 = (isset($_POST['module236'])) ? 1 : 0;
$per237 = (isset($_POST['module237'])) ? 1 : 0;
$per238 = (isset($_POST['module238'])) ? 1 : 0;
$per239 = (isset($_POST['module239'])) ? 1 : 0;
$per240 = (isset($_POST['module240'])) ? 1 : 0;
$per241 = (isset($_POST['module241'])) ? 1 : 0;
$per242 = (isset($_POST['module242'])) ? 1 : 0;
$per243 = (isset($_POST['module243'])) ? 1 : 0;
$per244 = (isset($_POST['module244'])) ? 1 : 0;
$per245 = (isset($_POST['module245'])) ? 1 : 0;
$per246 = (isset($_POST['module246'])) ? 1 : 0;
$per247 = (isset($_POST['module247'])) ? 1 : 0;
$per248 = (isset($_POST['module248'])) ? 1 : 0;
$per249 = (isset($_POST['module249'])) ? 1 : 0;
$per250 = (isset($_POST['module250'])) ? 1 : 0;
$per251 = (isset($_POST['module251'])) ? 1 : 0;
$per252 = (isset($_POST['module252'])) ? 1 : 0;
$per253 = (isset($_POST['module253'])) ? 1 : 0;
$per254 = (isset($_POST['module254'])) ? 1 : 0;
$per255 = (isset($_POST['module255'])) ? 1 : 0;
$per256 = (isset($_POST['module256'])) ? 1 : 0;
$per257 = (isset($_POST['module257'])) ? 1 : 0;


if('-1' < (isset($_POST['oldper101']) ? $_POST['oldper101'] : '') && (isset($_POST['oldper101']) ? $_POST['oldper101'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per101' WHERE id = '$per_id101'");}
if('-1' < (isset($_POST['oldper102']) ? $_POST['oldper102'] : '') && (isset($_POST['oldper102']) ? $_POST['oldper102'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per102' WHERE id = '$per_id102'");}
if('-1' < (isset($_POST['oldper103']) ? $_POST['oldper103'] : '') && (isset($_POST['oldper103']) ? $_POST['oldper103'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per103' WHERE id = '$per_id103'");}
if('-1' < (isset($_POST['oldper104']) ? $_POST['oldper104'] : '') && (isset($_POST['oldper104']) ? $_POST['oldper104'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per104' WHERE id = '$per_id104'");}
if('-1' < (isset($_POST['oldper105']) ? $_POST['oldper105'] : '') && (isset($_POST['oldper105']) ? $_POST['oldper105'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per105' WHERE id = '$per_id105'");}
if('-1' < (isset($_POST['oldper106']) ? $_POST['oldper106'] : '') && (isset($_POST['oldper106']) ? $_POST['oldper106'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per106' WHERE id = '$per_id106'");}
if('-1' < (isset($_POST['oldper107']) ? $_POST['oldper107'] : '') && (isset($_POST['oldper107']) ? $_POST['oldper107'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per107' WHERE id = '$per_id107'");}
if('-1' < (isset($_POST['oldper108']) ? $_POST['oldper108'] : '') && (isset($_POST['oldper108']) ? $_POST['oldper108'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per108' WHERE id = '$per_id108'");}
if('-1' < (isset($_POST['oldper109']) ? $_POST['oldper109'] : '') && (isset($_POST['oldper109']) ? $_POST['oldper109'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per109' WHERE id = '$per_id109'");}
if('-1' < (isset($_POST['oldper110']) ? $_POST['oldper110'] : '') && (isset($_POST['oldper110']) ? $_POST['oldper110'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per110' WHERE id = '$per_id110'");}
if('-1' < (isset($_POST['oldper111']) ? $_POST['oldper111'] : '') && (isset($_POST['oldper111']) ? $_POST['oldper111'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per111' WHERE id = '$per_id111'");}
if('-1' < (isset($_POST['oldper112']) ? $_POST['oldper112'] : '') && (isset($_POST['oldper112']) ? $_POST['oldper112'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per112' WHERE id = '$per_id112'");}
if('-1' < (isset($_POST['oldper113']) ? $_POST['oldper113'] : '') && (isset($_POST['oldper113']) ? $_POST['oldper113'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per113' WHERE id = '$per_id113'");}
if('-1' < (isset($_POST['oldper114']) ? $_POST['oldper114'] : '') && (isset($_POST['oldper114']) ? $_POST['oldper114'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per114' WHERE id = '$per_id114'");}
if('-1' < (isset($_POST['oldper115']) ? $_POST['oldper115'] : '') && (isset($_POST['oldper115']) ? $_POST['oldper115'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per115' WHERE id = '$per_id115'");}
if('-1' < (isset($_POST['oldper116']) ? $_POST['oldper116'] : '') && (isset($_POST['oldper116']) ? $_POST['oldper116'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per116' WHERE id = '$per_id116'");}
if('-1' < (isset($_POST['oldper117']) ? $_POST['oldper117'] : '') && (isset($_POST['oldper117']) ? $_POST['oldper117'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per117' WHERE id = '$per_id117'");}
if('-1' < (isset($_POST['oldper118']) ? $_POST['oldper118'] : '') && (isset($_POST['oldper118']) ? $_POST['oldper118'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per118' WHERE id = '$per_id118'");}
if('-1' < (isset($_POST['oldper119']) ? $_POST['oldper119'] : '') && (isset($_POST['oldper119']) ? $_POST['oldper119'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per119' WHERE id = '$per_id119'");}
if('-1' < (isset($_POST['oldper120']) ? $_POST['oldper120'] : '') && (isset($_POST['oldper120']) ? $_POST['oldper120'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per120' WHERE id = '$per_id120'");}
if('-1' < (isset($_POST['oldper121']) ? $_POST['oldper121'] : '') && (isset($_POST['oldper121']) ? $_POST['oldper121'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per121' WHERE id = '$per_id121'");}
if('-1' < (isset($_POST['oldper122']) ? $_POST['oldper122'] : '') && (isset($_POST['oldper122']) ? $_POST['oldper122'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per122' WHERE id = '$per_id122'");}
if('-1' < (isset($_POST['oldper123']) ? $_POST['oldper123'] : '') && (isset($_POST['oldper123']) ? $_POST['oldper123'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per123' WHERE id = '$per_id123'");}
if('-1' < (isset($_POST['oldper124']) ? $_POST['oldper124'] : '') && (isset($_POST['oldper124']) ? $_POST['oldper124'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per124' WHERE id = '$per_id124'");}
if('-1' < (isset($_POST['oldper125']) ? $_POST['oldper125'] : '') && (isset($_POST['oldper125']) ? $_POST['oldper125'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per125' WHERE id = '$per_id125'");}
if('-1' < (isset($_POST['oldper126']) ? $_POST['oldper126'] : '') && (isset($_POST['oldper126']) ? $_POST['oldper126'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per126' WHERE id = '$per_id126'");}
if('-1' < (isset($_POST['oldper127']) ? $_POST['oldper127'] : '') && (isset($_POST['oldper127']) ? $_POST['oldper127'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per127' WHERE id = '$per_id127'");}
if('-1' < (isset($_POST['oldper128']) ? $_POST['oldper128'] : '') && (isset($_POST['oldper128']) ? $_POST['oldper128'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per128' WHERE id = '$per_id128'");}
if('-1' < (isset($_POST['oldper129']) ? $_POST['oldper129'] : '') && (isset($_POST['oldper129']) ? $_POST['oldper129'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per129' WHERE id = '$per_id129'");}
if('-1' < (isset($_POST['oldper130']) ? $_POST['oldper130'] : '') && (isset($_POST['oldper130']) ? $_POST['oldper130'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per130' WHERE id = '$per_id130'");}
if('-1' < (isset($_POST['oldper131']) ? $_POST['oldper131'] : '') && (isset($_POST['oldper131']) ? $_POST['oldper131'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per131' WHERE id = '$per_id131'");}
if('-1' < (isset($_POST['oldper132']) ? $_POST['oldper132'] : '') && (isset($_POST['oldper132']) ? $_POST['oldper132'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per132' WHERE id = '$per_id132'");}
if('-1' < (isset($_POST['oldper133']) ? $_POST['oldper133'] : '') && (isset($_POST['oldper133']) ? $_POST['oldper133'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per133' WHERE id = '$per_id133'");}
if('-1' < (isset($_POST['oldper134']) ? $_POST['oldper134'] : '') && (isset($_POST['oldper134']) ? $_POST['oldper134'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per134' WHERE id = '$per_id134'");}
if('-1' < (isset($_POST['oldper135']) ? $_POST['oldper135'] : '') && (isset($_POST['oldper135']) ? $_POST['oldper135'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per135' WHERE id = '$per_id135'");}
if('-1' < (isset($_POST['oldper136']) ? $_POST['oldper136'] : '') && (isset($_POST['oldper136']) ? $_POST['oldper136'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per136' WHERE id = '$per_id136'");}
if('-1' < (isset($_POST['oldper137']) ? $_POST['oldper137'] : '') && (isset($_POST['oldper137']) ? $_POST['oldper137'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per137' WHERE id = '$per_id137'");}
if('-1' < (isset($_POST['oldper138']) ? $_POST['oldper138'] : '') && (isset($_POST['oldper138']) ? $_POST['oldper138'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per138' WHERE id = '$per_id138'");}
if('-1' < (isset($_POST['oldper139']) ? $_POST['oldper139'] : '') && (isset($_POST['oldper139']) ? $_POST['oldper139'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per139' WHERE id = '$per_id139'");}
if('-1' < (isset($_POST['oldper140']) ? $_POST['oldper140'] : '') && (isset($_POST['oldper140']) ? $_POST['oldper140'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per140' WHERE id = '$per_id140'");}
if('-1' < (isset($_POST['oldper141']) ? $_POST['oldper141'] : '') && (isset($_POST['oldper141']) ? $_POST['oldper141'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per141' WHERE id = '$per_id141'");}
if('-1' < (isset($_POST['oldper142']) ? $_POST['oldper142'] : '') && (isset($_POST['oldper142']) ? $_POST['oldper142'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per142' WHERE id = '$per_id142'");}
if('-1' < (isset($_POST['oldper143']) ? $_POST['oldper143'] : '') && (isset($_POST['oldper143']) ? $_POST['oldper143'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per143' WHERE id = '$per_id143'");}
if('-1' < (isset($_POST['oldper144']) ? $_POST['oldper144'] : '') && (isset($_POST['oldper144']) ? $_POST['oldper144'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per144' WHERE id = '$per_id144'");}
if('-1' < (isset($_POST['oldper145']) ? $_POST['oldper145'] : '') && (isset($_POST['oldper145']) ? $_POST['oldper145'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per145' WHERE id = '$per_id145'");}
if('-1' < (isset($_POST['oldper146']) ? $_POST['oldper146'] : '') && (isset($_POST['oldper146']) ? $_POST['oldper146'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per146' WHERE id = '$per_id146'");}
if('-1' < (isset($_POST['oldper147']) ? $_POST['oldper147'] : '') && (isset($_POST['oldper147']) ? $_POST['oldper147'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per147' WHERE id = '$per_id147'");}
if('-1' < (isset($_POST['oldper148']) ? $_POST['oldper148'] : '') && (isset($_POST['oldper148']) ? $_POST['oldper148'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per148' WHERE id = '$per_id148'");}
if('-1' < (isset($_POST['oldper149']) ? $_POST['oldper149'] : '') && (isset($_POST['oldper149']) ? $_POST['oldper149'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per149' WHERE id = '$per_id149'");}
if('-1' < (isset($_POST['oldper150']) ? $_POST['oldper150'] : '') && (isset($_POST['oldper150']) ? $_POST['oldper150'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per150' WHERE id = '$per_id150'");}
if('-1' < (isset($_POST['oldper151']) ? $_POST['oldper151'] : '') && (isset($_POST['oldper151']) ? $_POST['oldper151'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per151' WHERE id = '$per_id151'");}
if('-1' < (isset($_POST['oldper152']) ? $_POST['oldper152'] : '') && (isset($_POST['oldper152']) ? $_POST['oldper152'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per152' WHERE id = '$per_id152'");}
if('-1' < (isset($_POST['oldper153']) ? $_POST['oldper153'] : '') && (isset($_POST['oldper153']) ? $_POST['oldper153'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per153' WHERE id = '$per_id153'");}
if('-1' < (isset($_POST['oldper154']) ? $_POST['oldper154'] : '') && (isset($_POST['oldper154']) ? $_POST['oldper154'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per154' WHERE id = '$per_id154'");}
if('-1' < (isset($_POST['oldper155']) ? $_POST['oldper155'] : '') && (isset($_POST['oldper155']) ? $_POST['oldper155'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per155' WHERE id = '$per_id155'");}
if('-1' < (isset($_POST['oldper156']) ? $_POST['oldper156'] : '') && (isset($_POST['oldper156']) ? $_POST['oldper156'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per156' WHERE id = '$per_id156'");}
if('-1' < (isset($_POST['oldper157']) ? $_POST['oldper157'] : '') && (isset($_POST['oldper157']) ? $_POST['oldper157'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per157' WHERE id = '$per_id157'");}
if('-1' < (isset($_POST['oldper158']) ? $_POST['oldper158'] : '') && (isset($_POST['oldper158']) ? $_POST['oldper158'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per158' WHERE id = '$per_id158'");}
if('-1' < (isset($_POST['oldper159']) ? $_POST['oldper159'] : '') && (isset($_POST['oldper159']) ? $_POST['oldper159'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per159' WHERE id = '$per_id159'");}
if('-1' < (isset($_POST['oldper160']) ? $_POST['oldper160'] : '') && (isset($_POST['oldper160']) ? $_POST['oldper160'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per160' WHERE id = '$per_id160'");}
if('-1' < (isset($_POST['oldper161']) ? $_POST['oldper161'] : '') && (isset($_POST['oldper161']) ? $_POST['oldper161'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per161' WHERE id = '$per_id161'");}
if('-1' < (isset($_POST['oldper162']) ? $_POST['oldper162'] : '') && (isset($_POST['oldper162']) ? $_POST['oldper162'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per162' WHERE id = '$per_id162'");}
if('-1' < (isset($_POST['oldper163']) ? $_POST['oldper163'] : '') && (isset($_POST['oldper163']) ? $_POST['oldper163'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per163' WHERE id = '$per_id163'");}
if('-1' < (isset($_POST['oldper164']) ? $_POST['oldper164'] : '') && (isset($_POST['oldper164']) ? $_POST['oldper164'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per164' WHERE id = '$per_id164'");}
if('-1' < (isset($_POST['oldper165']) ? $_POST['oldper165'] : '') && (isset($_POST['oldper165']) ? $_POST['oldper165'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per165' WHERE id = '$per_id165'");}
if('-1' < (isset($_POST['oldper166']) ? $_POST['oldper166'] : '') && (isset($_POST['oldper166']) ? $_POST['oldper166'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per166' WHERE id = '$per_id166'");}
if('-1' < (isset($_POST['oldper167']) ? $_POST['oldper167'] : '') && (isset($_POST['oldper167']) ? $_POST['oldper167'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per167' WHERE id = '$per_id167'");}
if('-1' < (isset($_POST['oldper168']) ? $_POST['oldper168'] : '') && (isset($_POST['oldper168']) ? $_POST['oldper168'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per168' WHERE id = '$per_id168'");}
if('-1' < (isset($_POST['oldper169']) ? $_POST['oldper169'] : '') && (isset($_POST['oldper169']) ? $_POST['oldper169'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per169' WHERE id = '$per_id169'");}
if('-1' < (isset($_POST['oldper170']) ? $_POST['oldper170'] : '') && (isset($_POST['oldper170']) ? $_POST['oldper170'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per170' WHERE id = '$per_id170'");}
if('-1' < (isset($_POST['oldper171']) ? $_POST['oldper171'] : '') && (isset($_POST['oldper171']) ? $_POST['oldper171'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per171' WHERE id = '$per_id171'");}
if('-1' < (isset($_POST['oldper172']) ? $_POST['oldper172'] : '') && (isset($_POST['oldper172']) ? $_POST['oldper172'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per172' WHERE id = '$per_id172'");}
if('-1' < (isset($_POST['oldper173']) ? $_POST['oldper173'] : '') && (isset($_POST['oldper173']) ? $_POST['oldper173'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per173' WHERE id = '$per_id173'");}
if('-1' < (isset($_POST['oldper174']) ? $_POST['oldper174'] : '') && (isset($_POST['oldper174']) ? $_POST['oldper174'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per174' WHERE id = '$per_id174'");}
if('-1' < (isset($_POST['oldper175']) ? $_POST['oldper175'] : '') && (isset($_POST['oldper175']) ? $_POST['oldper175'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per175' WHERE id = '$per_id175'");}
if('-1' < (isset($_POST['oldper176']) ? $_POST['oldper176'] : '') && (isset($_POST['oldper176']) ? $_POST['oldper176'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per176' WHERE id = '$per_id176'");}
if('-1' < (isset($_POST['oldper177']) ? $_POST['oldper177'] : '') && (isset($_POST['oldper177']) ? $_POST['oldper177'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per177' WHERE id = '$per_id177'");}
if('-1' < (isset($_POST['oldper178']) ? $_POST['oldper178'] : '') && (isset($_POST['oldper178']) ? $_POST['oldper178'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per178' WHERE id = '$per_id178'");}
if('-1' < (isset($_POST['oldper179']) ? $_POST['oldper179'] : '') && (isset($_POST['oldper179']) ? $_POST['oldper179'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per179' WHERE id = '$per_id179'");}
if('-1' < (isset($_POST['oldper180']) ? $_POST['oldper180'] : '') && (isset($_POST['oldper180']) ? $_POST['oldper180'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per180' WHERE id = '$per_id180'");}
if('-1' < (isset($_POST['oldper181']) ? $_POST['oldper181'] : '') && (isset($_POST['oldper181']) ? $_POST['oldper181'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per181' WHERE id = '$per_id181'");}
if('-1' < (isset($_POST['oldper182']) ? $_POST['oldper182'] : '') && (isset($_POST['oldper182']) ? $_POST['oldper182'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per182' WHERE id = '$per_id182'");}
if('-1' < (isset($_POST['oldper183']) ? $_POST['oldper183'] : '') && (isset($_POST['oldper183']) ? $_POST['oldper183'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per183' WHERE id = '$per_id183'");}
if('-1' < (isset($_POST['oldper184']) ? $_POST['oldper184'] : '') && (isset($_POST['oldper184']) ? $_POST['oldper184'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per184' WHERE id = '$per_id184'");}
if('-1' < (isset($_POST['oldper185']) ? $_POST['oldper185'] : '') && (isset($_POST['oldper185']) ? $_POST['oldper185'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per185' WHERE id = '$per_id185'");}
if('-1' < (isset($_POST['oldper186']) ? $_POST['oldper186'] : '') && (isset($_POST['oldper186']) ? $_POST['oldper186'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per186' WHERE id = '$per_id186'");}
if('-1' < (isset($_POST['oldper187']) ? $_POST['oldper187'] : '') && (isset($_POST['oldper187']) ? $_POST['oldper187'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per187' WHERE id = '$per_id187'");}
if('-1' < (isset($_POST['oldper188']) ? $_POST['oldper188'] : '') && (isset($_POST['oldper188']) ? $_POST['oldper188'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per188' WHERE id = '$per_id188'");}
if('-1' < (isset($_POST['oldper189']) ? $_POST['oldper189'] : '') && (isset($_POST['oldper189']) ? $_POST['oldper189'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per189' WHERE id = '$per_id189'");}
if('-1' < (isset($_POST['oldper190']) ? $_POST['oldper190'] : '') && (isset($_POST['oldper190']) ? $_POST['oldper190'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per190' WHERE id = '$per_id190'");}
if('-1' < (isset($_POST['oldper191']) ? $_POST['oldper191'] : '') && (isset($_POST['oldper191']) ? $_POST['oldper191'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per191' WHERE id = '$per_id191'");}
if('-1' < (isset($_POST['oldper192']) ? $_POST['oldper192'] : '') && (isset($_POST['oldper192']) ? $_POST['oldper192'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per192' WHERE id = '$per_id192'");}
if('-1' < (isset($_POST['oldper193']) ? $_POST['oldper193'] : '') && (isset($_POST['oldper193']) ? $_POST['oldper193'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per193' WHERE id = '$per_id193'");}
if('-1' < (isset($_POST['oldper194']) ? $_POST['oldper194'] : '') && (isset($_POST['oldper194']) ? $_POST['oldper194'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per194' WHERE id = '$per_id194'");}
if('-1' < (isset($_POST['oldper195']) ? $_POST['oldper195'] : '') && (isset($_POST['oldper195']) ? $_POST['oldper195'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per195' WHERE id = '$per_id195'");}
if('-1' < (isset($_POST['oldper196']) ? $_POST['oldper196'] : '') && (isset($_POST['oldper196']) ? $_POST['oldper196'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per196' WHERE id = '$per_id196'");}
if('-1' < (isset($_POST['oldper197']) ? $_POST['oldper197'] : '') && (isset($_POST['oldper197']) ? $_POST['oldper197'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per197' WHERE id = '$per_id197'");}
if('-1' < (isset($_POST['oldper198']) ? $_POST['oldper198'] : '') && (isset($_POST['oldper198']) ? $_POST['oldper198'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per198' WHERE id = '$per_id198'");}
if('-1' < (isset($_POST['oldper199']) ? $_POST['oldper199'] : '') && (isset($_POST['oldper199']) ? $_POST['oldper199'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per199' WHERE id = '$per_id199'");}
if('-1' < (isset($_POST['oldper200']) ? $_POST['oldper200'] : '') && (isset($_POST['oldper200']) ? $_POST['oldper200'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per200' WHERE id = '$per_id200'");}
if('-1' < (isset($_POST['oldper201']) ? $_POST['oldper201'] : '') && (isset($_POST['oldper201']) ? $_POST['oldper201'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per201' WHERE id = '$per_id201'");}
if('-1' < (isset($_POST['oldper202']) ? $_POST['oldper202'] : '') && (isset($_POST['oldper202']) ? $_POST['oldper202'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per202' WHERE id = '$per_id202'");}
if('-1' < (isset($_POST['oldper203']) ? $_POST['oldper203'] : '') && (isset($_POST['oldper203']) ? $_POST['oldper203'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per203' WHERE id = '$per_id203'");}
if('-1' < (isset($_POST['oldper204']) ? $_POST['oldper204'] : '') && (isset($_POST['oldper204']) ? $_POST['oldper204'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per204' WHERE id = '$per_id204'");}
if('-1' < (isset($_POST['oldper205']) ? $_POST['oldper205'] : '') && (isset($_POST['oldper205']) ? $_POST['oldper205'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per205' WHERE id = '$per_id205'");}
if('-1' < (isset($_POST['oldper206']) ? $_POST['oldper206'] : '') && (isset($_POST['oldper206']) ? $_POST['oldper206'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per206' WHERE id = '$per_id206'");}
if('-1' < (isset($_POST['oldper207']) ? $_POST['oldper207'] : '') && (isset($_POST['oldper207']) ? $_POST['oldper207'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per207' WHERE id = '$per_id207'");}
if('-1' < (isset($_POST['oldper208']) ? $_POST['oldper208'] : '') && (isset($_POST['oldper208']) ? $_POST['oldper208'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per208' WHERE id = '$per_id208'");}
if('-1' < (isset($_POST['oldper209']) ? $_POST['oldper209'] : '') && (isset($_POST['oldper209']) ? $_POST['oldper209'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per209' WHERE id = '$per_id209'");}
if('-1' < (isset($_POST['oldper210']) ? $_POST['oldper210'] : '') && (isset($_POST['oldper210']) ? $_POST['oldper210'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per210' WHERE id = '$per_id210'");}
if('-1' < (isset($_POST['oldper211']) ? $_POST['oldper211'] : '') && (isset($_POST['oldper211']) ? $_POST['oldper211'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per211' WHERE id = '$per_id211'");}
if('-1' < (isset($_POST['oldper212']) ? $_POST['oldper212'] : '') && (isset($_POST['oldper212']) ? $_POST['oldper212'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per212' WHERE id = '$per_id212'");}
if('-1' < (isset($_POST['oldper213']) ? $_POST['oldper213'] : '') && (isset($_POST['oldper213']) ? $_POST['oldper213'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per213' WHERE id = '$per_id213'");}
if('-1' < (isset($_POST['oldper214']) ? $_POST['oldper214'] : '') && (isset($_POST['oldper214']) ? $_POST['oldper214'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per214' WHERE id = '$per_id214'");}
if('-1' < (isset($_POST['oldper215']) ? $_POST['oldper215'] : '') && (isset($_POST['oldper215']) ? $_POST['oldper215'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per215' WHERE id = '$per_id215'");}
if('-1' < (isset($_POST['oldper216']) ? $_POST['oldper216'] : '') && (isset($_POST['oldper216']) ? $_POST['oldper216'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per216' WHERE id = '$per_id216'");}
if('-1' < (isset($_POST['oldper217']) ? $_POST['oldper217'] : '') && (isset($_POST['oldper217']) ? $_POST['oldper217'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per217' WHERE id = '$per_id217'");}
if('-1' < (isset($_POST['oldper218']) ? $_POST['oldper218'] : '') && (isset($_POST['oldper218']) ? $_POST['oldper218'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per218' WHERE id = '$per_id218'");}
if('-1' < (isset($_POST['oldper219']) ? $_POST['oldper219'] : '') && (isset($_POST['oldper219']) ? $_POST['oldper219'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per219' WHERE id = '$per_id219'");}
if('-1' < (isset($_POST['oldper220']) ? $_POST['oldper220'] : '') && (isset($_POST['oldper220']) ? $_POST['oldper220'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per220' WHERE id = '$per_id220'");}
if('-1' < (isset($_POST['oldper221']) ? $_POST['oldper221'] : '') && (isset($_POST['oldper221']) ? $_POST['oldper221'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per221' WHERE id = '$per_id221'");}
if('-1' < (isset($_POST['oldper222']) ? $_POST['oldper222'] : '') && (isset($_POST['oldper222']) ? $_POST['oldper222'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per222' WHERE id = '$per_id222'");}
if('-1' < (isset($_POST['oldper223']) ? $_POST['oldper223'] : '') && (isset($_POST['oldper223']) ? $_POST['oldper223'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per223' WHERE id = '$per_id223'");}
if('-1' < (isset($_POST['oldper224']) ? $_POST['oldper224'] : '') && (isset($_POST['oldper224']) ? $_POST['oldper224'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per224' WHERE id = '$per_id224'");}
if('-1' < (isset($_POST['oldper225']) ? $_POST['oldper225'] : '') && (isset($_POST['oldper225']) ? $_POST['oldper225'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per225' WHERE id = '$per_id225'");}
if('-1' < (isset($_POST['oldper226']) ? $_POST['oldper226'] : '') && (isset($_POST['oldper226']) ? $_POST['oldper226'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per226' WHERE id = '$per_id226'");}
if('-1' < (isset($_POST['oldper227']) ? $_POST['oldper227'] : '') && (isset($_POST['oldper227']) ? $_POST['oldper227'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per227' WHERE id = '$per_id227'");}
if('-1' < (isset($_POST['oldper228']) ? $_POST['oldper228'] : '') && (isset($_POST['oldper228']) ? $_POST['oldper228'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per228' WHERE id = '$per_id228'");}
if('-1' < (isset($_POST['oldper229']) ? $_POST['oldper229'] : '') && (isset($_POST['oldper229']) ? $_POST['oldper229'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per229' WHERE id = '$per_id229'");}
if('-1' < (isset($_POST['oldper230']) ? $_POST['oldper230'] : '') && (isset($_POST['oldper230']) ? $_POST['oldper230'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per230' WHERE id = '$per_id230'");}
if('-1' < (isset($_POST['oldper231']) ? $_POST['oldper231'] : '') && (isset($_POST['oldper231']) ? $_POST['oldper231'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per231' WHERE id = '$per_id231'");}
if('-1' < (isset($_POST['oldper232']) ? $_POST['oldper232'] : '') && (isset($_POST['oldper232']) ? $_POST['oldper232'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per232' WHERE id = '$per_id232'");}
if('-1' < (isset($_POST['oldper233']) ? $_POST['oldper233'] : '') && (isset($_POST['oldper233']) ? $_POST['oldper233'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per233' WHERE id = '$per_id233'");}
if('-1' < (isset($_POST['oldper234']) ? $_POST['oldper234'] : '') && (isset($_POST['oldper234']) ? $_POST['oldper234'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per234' WHERE id = '$per_id234'");}
if('-1' < (isset($_POST['oldper235']) ? $_POST['oldper235'] : '') && (isset($_POST['oldper235']) ? $_POST['oldper235'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per235' WHERE id = '$per_id235'");}
if('-1' < (isset($_POST['oldper236']) ? $_POST['oldper236'] : '') && (isset($_POST['oldper236']) ? $_POST['oldper236'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per236' WHERE id = '$per_id236'");}
if('-1' < (isset($_POST['oldper237']) ? $_POST['oldper237'] : '') && (isset($_POST['oldper237']) ? $_POST['oldper237'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per237' WHERE id = '$per_id237'");}
if('-1' < (isset($_POST['oldper238']) ? $_POST['oldper238'] : '') && (isset($_POST['oldper238']) ? $_POST['oldper238'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per238' WHERE id = '$per_id238'");}
if('-1' < (isset($_POST['oldper239']) ? $_POST['oldper239'] : '') && (isset($_POST['oldper239']) ? $_POST['oldper239'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per239' WHERE id = '$per_id239'");}
if('-1' < (isset($_POST['oldper240']) ? $_POST['oldper240'] : '') && (isset($_POST['oldper240']) ? $_POST['oldper240'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per240' WHERE id = '$per_id240'");}
if('-1' < (isset($_POST['oldper241']) ? $_POST['oldper241'] : '') && (isset($_POST['oldper241']) ? $_POST['oldper241'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per241' WHERE id = '$per_id241'");}
if('-1' < (isset($_POST['oldper242']) ? $_POST['oldper242'] : '') && (isset($_POST['oldper242']) ? $_POST['oldper242'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per242' WHERE id = '$per_id242'");}
if('-1' < (isset($_POST['oldper243']) ? $_POST['oldper243'] : '') && (isset($_POST['oldper243']) ? $_POST['oldper243'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per243' WHERE id = '$per_id243'");}
if('-1' < (isset($_POST['oldper244']) ? $_POST['oldper244'] : '') && (isset($_POST['oldper244']) ? $_POST['oldper244'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per244' WHERE id = '$per_id244'");}
if('-1' < (isset($_POST['oldper245']) ? $_POST['oldper245'] : '') && (isset($_POST['oldper245']) ? $_POST['oldper245'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per245' WHERE id = '$per_id245'");}
if('-1' < (isset($_POST['oldper246']) ? $_POST['oldper246'] : '') && (isset($_POST['oldper246']) ? $_POST['oldper246'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per246' WHERE id = '$per_id246'");}
if('-1' < (isset($_POST['oldper247']) ? $_POST['oldper247'] : '') && (isset($_POST['oldper247']) ? $_POST['oldper247'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per247' WHERE id = '$per_id247'");}
if('-1' < (isset($_POST['oldper248']) ? $_POST['oldper248'] : '') && (isset($_POST['oldper248']) ? $_POST['oldper248'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per248' WHERE id = '$per_id248'");}
if('-1' < (isset($_POST['oldper249']) ? $_POST['oldper249'] : '') && (isset($_POST['oldper249']) ? $_POST['oldper249'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per249' WHERE id = '$per_id249'");}
if('-1' < (isset($_POST['oldper250']) ? $_POST['oldper250'] : '') && (isset($_POST['oldper250']) ? $_POST['oldper250'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per250' WHERE id = '$per_id250'");}
if('-1' < (isset($_POST['oldper251']) ? $_POST['oldper251'] : '') && (isset($_POST['oldper251']) ? $_POST['oldper251'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per251' WHERE id = '$per_id251'");}
if('-1' < (isset($_POST['oldper252']) ? $_POST['oldper252'] : '') && (isset($_POST['oldper252']) ? $_POST['oldper252'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per252' WHERE id = '$per_id252'");}
if('-1' < (isset($_POST['oldper253']) ? $_POST['oldper253'] : '') && (isset($_POST['oldper253']) ? $_POST['oldper253'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per253' WHERE id = '$per_id253'");}
if('-1' < (isset($_POST['oldper254']) ? $_POST['oldper254'] : '') && (isset($_POST['oldper254']) ? $_POST['oldper254'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per254' WHERE id = '$per_id254'");}
if('-1' < (isset($_POST['oldper255']) ? $_POST['oldper255'] : '') && (isset($_POST['oldper255']) ? $_POST['oldper255'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per255' WHERE id = '$per_id255'");}
if('-1' < (isset($_POST['oldper256']) ? $_POST['oldper256'] : '') && (isset($_POST['oldper256']) ? $_POST['oldper256'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per256' WHERE id = '$per_id256'");}
if('-1' < (isset($_POST['oldper257']) ? $_POST['oldper257'] : '') && (isset($_POST['oldper257']) ? $_POST['oldper257'] : '') < '2'){$mod1 = mysql_query("UPDATE module_page SET $type = '$per257' WHERE id = '$per_id257'");}

?>
<html>
<body>
     <form action="UserAccessPage" method="post" name="done">
       <input type="hidden" name="sts" value="update">
       <input type="hidden" name="type" value="<?php echo $type;?>">
     </form>
     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>
<?php

mysql_close($con);
?>