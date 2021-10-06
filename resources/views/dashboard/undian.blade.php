@extends('layouts/contentLayoutMaster')

@section('title', 'Undian')

@section('content')


<style>
    h1#headerNames {
        color: rgb(9, 219, 2);
        font-family: Georgia, serif;
        font-size: 100px;
        text-align: center;
        cursor: pointer;
    }

    #headerAdd, #headerNik {
        color: rgb(9, 219, 2);
        font-family: Georgia, serif;
        font-size: 50px;
        text-align: center;
        cursor: pointer;
    }

    .button {
        margin: auto;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    #stopButton {
        display: none;
    }

    #timerWrapper {
        margin: 50px 0;
        color: #fff;
        font-family: Arial, sans-serif;
        font-size: 50px;
        text-align: center;
        opacity: 0;
        transition: opacity 1s;
    }

    #timerWrapper.visible {
        opacity: 1;
    }

    #timesUp {
        padding-top: 20%;
        background-color: red;
        color: rgb(255, 255, 255);
        font-family: Arial, sans-serif;
        font-size: 100px;
        font-weight: bold;
        text-transform: uppercase;
        text-align: center;
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        display: none;

        a {
            margin: 100px auto;
            font-size: 15px;
            position: absolute;
            bottom: 50px;
            left: 0;
            right: 0;
            display: none;
        }
    }

    #timesUp.backgroundRed {
        background-color: #333;
    }

    @media only screen and (max-width: 600px) {
        h1 {
            font-size: 50px;
        }
    }
</style>

<div class="row">
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <a href="{{ route('dashboard-analytics') }}" title="kembali"><i
                            class="fas fa-arrow-left"></i>&nbsp;&nbsp;</a>
                    <h4 class="card-title">{{ $hadiah->hadiah }}</h4>
                </div>
            </div>
            <div class="card-body">

                <div class="row" style="height: 400px">
                    <div class="col-12">
                        <h1 id="headerNames">?</h1>
                        <h3 id="headerNik">&nbsp;</h3>
                        <h3 id="headerAdd">&nbsp;</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="btn btn-danger btn-lg button" id="stopButton">stop</div>
                    <div class="btn btn-success btn-lg button" id="startButton">start</div>
                    <div class="btn btn-warning btn-lg button" id="ulangButton">Ulang</div>
                    <form action="{{ route('undian.simpan') }}" method="post" id='form_simpan' class="button">
                        @csrf
                        {!! Form::hidden('partisipan_id', $pemenang->id) !!}
                        {!! Form::hidden('hadiah_id', $hadiah->id) !!}
                        <button type="submit" class="btn btn-info btn-lg" id="simpanButton">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-script')

<script>
    "use strict";

// Change to false if you don't want a timer
const showTimer = true;

// Set timer countdown time here in minutes : seconds format
const time = 0 + ":" + 19;

// Add list of names here
const namesList = ['SUYANTO', 'MOH. FADHLAK JAMMAL GHAFIRI', 'MOH. GIBRAN IMAMI', 'SAMSU RIJAL', 'PUTRI HANDAYANI', 'SAYFUL ARIF', 'ANNISA AISYAH ISTIQFA', 'SUMIYATI', 'NAWAFIL', 'AMA AGUS WINDARI', 'FITRIATUL UMAMA', 'JAZILATUR ROHMAH', 'YUHANIDZ RISHA TRIAS', 'MISNA', 'FARIDA', 'DANA IKWANTO', 'JUMA\'IE', 'NY. ITRIYAH', 'MUSAHWI', 'MISNATUN', 'AULIA RAMADANI', 'OOK PERMATA SARI', 'ANISATUL HASANAH', 'MUTALLIP', 'NISA NOVITSARI', 'UBAIDILLAH AZIZ RAMADHAN', 'RISMA INDARTI', 'SUHARTINI', 'HASNAIN NISA', 'FERI IRAWAN', 'SUGIANTO', 'NUR ILA SOVIANTI', 'HASANI', 'FAJRI HOSNIL HATIMAH', 'DULKAMAR', 'HAYAT', 'AHMAD TOYYIB SYAFIUDDIN', 'DAFIR', 'NUR HIDAYAT', 'MOH. NAFRI REHANATA', 'GHALI JASIR HUWAIDI', 'AGUNG WAHYUDI', 'AYNYA DWI LAELYA RAMADHAN', 'ALPIN ANDIKA PUTRA', 'SANIYAH', 'AHMAD HARIADI', 'NANIK ROHIMAH', 'SUYATNO', 'NURSIYA', 'NIHBU', 'AHMAD MAULANA NOVA', 'MUHAMMAD ALI', 'MISLAN', 'SINDI FEBRIANI', 'POPPY RIFANDA PUTRI', 'ENCUNG HARIYADI', 'DEDEK ARIYANTO', 'AGUS SALAM', 'SARKABI', 'MOH.FAUZAL RIFQI AFFANDI', 'SUFIYANI', 'ABD.RAHMAN', 'ASMUNI', 'SAODA', 'ADDUS', 'HALIMATUS SA\'DIYAH', 'GILANG RAMADHAN', 'MISWATI', 'Nur Aisyah, AMd.Keb.', 'HENDRA WARDANI', 'HABIBULLAH', 'RIRIN KUSTIAWATI', 'SISKA WIDIANA PUTRI', 'MILAWATI', 'MOH. LUTFI', 'NUR LAILI', 'AMAL JUSRI', 'ALI DAYYAN RAMADHAN', 'MARIAH NABILA', 'SUMARNO', 'MARIA ULFA', 'HARIYANTO', 'YULI ASTUTIK', 'SAMSUL ARIFIN', 'SOFYAN FIRDAUS', 'AMINA', 'JAKFAR SHADIQ', 'MOHAMMAD DARSO', 'SIDASIYAH', 'IRIYANTI ISTIQOMAH', 'SUGIONO', 'ROY KUSMA', 'SAFIYAH', 'MOH. MAHTUM', 'SADIQ', 'ZHAFRAN IZZAN ACHMAD ZAIN', 'erfandi', 'SUPRIONO', 'NURUL KHOFIFAH', 'FITRIYAH', 'SITI AMINAH', 'YULIANTO', 'HALIMA', 'MOH.RIFKI DARMAWAN', 'RASIDA ARIANI', 'MOH. CHALFIYN ARRADYTYA', 'LIKMAN HARIYANTO', 'AKH.KHATIBUL UMAM', 'ABDUL GANI', 'ALI WAFA S', 'ALI RAHMAT', 'MOH. JAMALUDDIN ZEN', 'FAISAL', 'ERVIN RESTIKA UTAMI', 'HORRAHMAN', 'AHMAD SULAIMAN', 'DEWI RAHMADANI', 'HABIYA', 'MOHAMMAD AZIZUL MUKHTAR', 'NURHAYATI', 'RIZA UMAMI', 'JUNAIDI PUTRA', 'NUR IMAMI', 'HANINA', 'ATMOYU', 'AMALIA NUR JANINAH ', 'HOSMAINI', 'MOH. GANI', 'SUTINA', 'SRI HOSNAINI', 'KOMARIYAH', 'HERLIYANI', 'Rolly Sadaekum', 'SALMA', 'Akhmad Jailani', 'SUSNIA', 'MOH. RUDIL', 'HATIJA', 'KARTINI', 'SATTA', 'AGUS HASIN', 'P. SUNARWI', 'FATHMI MARINDA', 'INAYATUR ROHMAH', 'MOH. MOKSIN', 'RUDIYANTO', 'ATMAWATI', 'DULSAPI', 'SYAZWANI WULIDATULLAYU', 'MEI SINTA EKA PRATIWI', 'SAINABUN', 'ACH. FARHAN EFENDI', 'NUR FAIDI', 'MASRAWI', 'MARNI', 'QONITATIN', 'MELIYANA IFTIA', 'MAIMONA', 'SARIYATUN', 'ROBI PRAYITNO', 'LISANDA WIDIYANTI', 'ABD. RASYID', 'AYU SYAFAATILLA WARDA ALIFIYAH', 'BUDIANTO', 'ASNARI', 'NOVIYANTO', 'Jadilah', 'ASMARIYA', 'LULUK NURUL BACHTIAR', 'ALIF VICTOR ANDIANSYAH', 'IMAMA', 'ANDRIYANI', 'HOLGI', 'ROMLAH', 'NAFIAH', 'SAADAH', 'IWAN EFENDI', 'NORMA', 'BENNY HALIM', 'ANNAINI', 'YANTI EKA PRASASTI', 'SUMARIYA', 'MASANI', 'AKH RAMADHANI', 'MAININGSIH', 'MUHAMMAD', 'SUMIATI', 'NAFISAH', 'HALIMATUS SADIYAH', 'BUHADI', 'ADNAN HARIADI', 'SUSI TRISNA NIANTI', 'RUSMAWATI', 'SARPIYA', 'MUHAMMAD JAILANI', 'SRI WAHYU NINGSIH', 'ACH. FAUZI', 'EVI WAHYUNINGSIH', 'MASRURAH', 'HOTIA', 'FATMAWATI', 'LATIFAH', 'ABU YASID', 'FAIZAH MUFIDAH', 'FAINI ZAHRAH', 'RUSMIYATI', 'SUJA', 'PASYAH KURNIA DWIANTORO', 'SUGENG WIDODO', 'AHMAWIYA', 'HALIMA', 'RUKMAWATI', 'IVAN FATURAHMAN', 'FARIDATUN', 'HOSNIYAH', 'MOMAMMAD MALI', 'SASMITO', 'ERNANDA ASTRIANA F', 'SRI ASIH WINARSIH', 'SUDIYONO', 'YUSNAINI', 'RAFI\'ATUN', 'SU\'UDI', 'NUR FATIKHA', 'WAKHID HIDAYAT', 'MIFTAHOL ARIFIN', 'MASIDAH PUSPITA D.', 'NURASMI', 'ISMAIL', 'HASURI', 'TEGUH FEBY DARYONO', 'INAYATUR ROHMAH', 'WINDA NURFIANA', 'SAMSIYA', 'ARSYIA', 'UUNG SUHERMAN', 'patmawati', 'KUNTUM KHAIRU UMMAH', 'BULHASAN ', 'DIAN NOVITASARI', 'AMIR SYARIFUDDIN', 'SHAKILA RAHMA ADIS', 'RISKIYAH', 'HARTINA UTAMI', 'KUTSIYANI', 'MUFLIHATIN, A.Ma', 'ABD. RAHMAN ', 'muhammad rizky', 'NOR FADILA', 'BUSAIRI', 'ELLIDAWATI', 'LU\'LU\'UL MUKARROMAH', 'MOH. SAFRILLAH', 'DANIELA MAYLA SURAYA', 'ELINAYATI', 'HOSNIYA', 'Nuraini Septi Fijianti', 'RYATA MULIA ISYANA', 'Andi Suyono', 'MAERANI', 'MIKE APRILIYA', 'SAWAWI', 'ASSIYA', 'QURRATUL AYNI', 'HERMAN S. ARIFIN', 'HASIYATUR RIFAH', 'CICIK DENAWASILAH', 'CINTA YUDIA PUTRI', 'IMELDA DWI PRATIWI', 'SETTI TRI WARDANI', 'NOR HAYATI', 'MOH. MASSER', 'SEINOL HASAN', 'LILIS SHAFIR MUNAWWAROH', 'WAHDA ZAFIRA ', 'ZAHNAN', 'M. ZAINUL ARIF ', 'AHMAD SAKDI', 'AHMAD HARIYANTO', 'ANGGA NOVIA FAJRI', 'HOLIFAH', 'AHMAD RASYID', 'RUMSIA ', 'HENNY DESYAWATI', 'ARGUS', 'SUWARNI', 'NAUVAL RIZKY DIMYATI ', 'ANIS MAHIRA', 'DWI AYU MUTIARA', 'TAUFIQ HIDAYAT, SKM.MM', 'SUPRIYADI ', 'DEVA SOLVIANA CANTIKA', 'SUHARTINI', 'MATSALAN', 'FITRIYAH', 'MOH. MISNO', 'SUSANTIN FAJARIYAH', 'NANANG KOSIM', 'AINUR RIDWAN', 'SUSYATI'];
// Default variables
let i = 0;
let x = 0;
let intervalHandle = null;
const startButton = document.getElementById('startButton');
const stopButton = document.getElementById('stopButton');
const ulangButton = document.getElementById('ulangButton');
const simpanButton = document.getElementById('form_simpan');
const headerOne = document.getElementById('headerNames');
const headerAdd = document.getElementById('headerAdd');
const headerNik = document.getElementById('headerNik');
const timesUp = document.getElementById('timesUp');
const timerWrapper = document.getElementById('timerWrapper');
const timer = document.getElementById('timer');

// Optional countdown timer
// Add zero in front of numbers < 10
function checkSecond(sec) {
  if (sec < 10 && sec >= 0) {
		sec = "0" + sec;
	} 
  if (sec < 0) {
		sec = "59";
	}
  return sec;
}

const startTimer = function() {
  const presentTime = timer.innerHTML;
  const timeArray = presentTime.split(/[:]+/);
  let m = timeArray[0];
  let s = checkSecond((timeArray[1] - 1));
	
  if (s==59) {
		m = m-1;
	}
  if (m < 0) {
		timesUp.style.display = "block";
	}
  
  timer.innerHTML = m + ":" + s;
	
	setTimeout(startTimer, 1000);
}

ulangButton.style.display = "none";
	simpanButton.style.display = "none";

// Start or stop the name shuffle on button click
startButton.addEventListener('click', function() {
	this.style.display = "none";
    headerAdd.innerHTML = '&nbsp;';
    headerNik.innerHTML = '&nbsp;';
	stopButton.style.display = "block";
	intervalHandle = setInterval(function () {
		headerNames.textContent = namesList[i++ % namesList.length];
	}, 50);
	if (showTimer===true) {
		timerWrapper.classList.remove('visible');
	}
});
stopButton.addEventListener('click', function() {
	this.style.display = "none";
	ulangButton.style.display = "none";
	simpanButton.style.display = "block";
	clearInterval(intervalHandle);
    headerOne.innerHTML = '{{ $pemenang->nama }}';
    headerAdd.innerHTML = '{{ $pemenang->alamat }}';
    headerNik.innerHTML = '{{ $pemenang->nik }}';
	timer.innerHTML = time;
	if (showTimer===true) {
		timerWrapper.classList.add('visible');
	}
	startTimer();

});

$('#ulangButton').click(function (e) { 
    e.preventDefault();
    location.reload(); 
});


</script>

@endsection