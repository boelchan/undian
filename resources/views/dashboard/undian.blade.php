@extends('layouts/contentLayoutMaster')

@section('title', 'Pencarian Pemenang')

@section('content')

<div class="row">
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <a href="{{ route('dashboard-analytics') }}" title="kembali"><i
                            class="fas fa-arrow-left"></i>&nbsp;&nbsp;</a>
                    <h4 class="card-title">Undian</h4>
                </div>
            </div>
            <div class="card-body">

                <style>
                    h1#headerNames {
                        color: rgb(9, 219, 2);
                        font-family: Georgia, serif;
                        font-size: 50px;
                        text-align: center;
                        cursor: pointer;
                    }
                    #headerAdd {
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
                    <div class="col-12">
                        <h1 id="headerNames">?</h1>
                        <h3 id="headerAdd">&nbsp;</h3>
                    </div>
                    <div class="btn btn-danger btn-lg button" id="stopButton">stop</div>
                    <div class="btn btn-success btn-lg button" id="startButton">start</div>
                    <div class="btn btn-warning btn-lg button" id="ulangButton">Ulang</div>
                    <br>
                    <form action="{{ route('undian.simpan') }}" method="post" id='form_simpan'>
                        @csrf
                        {!! Form::hidden('partisipan_id', $pemenang->id) !!}
                        {!! Form::hidden('hadiah_id', $hadiah->id) !!}
                        <button  type="submit" class="btn btn-info btn-lg" id="simpanButton" >Simpan</button>
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
const namesList = ['SUHARTINI, Amd. Keb', 'HASIYATUN', 'RATNA AZIZAH, Amd. Keb', 'IMAM BUDI WAHYONO', 'SYAIFUL EFENDI, Amd. Kep', 'MOH. ABD. KADIR, Amd. Kep', 'HAYATI, Amd. Keb', 'EKO WAHYUNI, Amd. Keb', 'AGUS BUDIYONO, Amd. Kep', 'MAZIDATUN NAIMAH, Amd. Keb', 'R.A. SITI NURUL FARIDA, S. ST', 'ARIF HIDAYANTO, Amd. Kep', 'INDAH PRIHATIN, Amd. Kep', 'ESSY PURNAMA JAYANTI, Amd. Keb', 'ISFIYAH WIDIYANTINA, Amd. Keb', 'ACH. ADIB, Amd. Kep', 'MUHAMMAD ALI MUKHTAR, S.Kep, Ns', 'RUDI HARTONO, Amd. Kep', 'DWI MARIYATIN, Amd. AK', 'JONI RAMLI, Amd. Kep', 'LULUK FAUZIYAH, Amd. Keb', 'dr. Hj. ARIYANIS RASDYAHATI, M.Kes', 'SAID ANAS, S.Kep. Ns', 'EKO SUHARYANTO, Amd. Kep', 'SITI RIDIYAH, Amd. Kep', 'drg. Yudha Ari Winata', 'YATIK IRAWATI, Amd. Keb', 'SUYATI, Amd. Keb', 'TATIK WIDIANA MUSHAN, Amd. Kep', 'DIDIT AGUS SUSANTO, SE', 'SITI LINA AISYAH, Amd. Keb', 'FAUZI', 'SUFIYAHARUM KISMAWARNI, Amd. AK', 'EKA NURMANTO, Amd. Kep', 'LATIFATUL KAMALIA, Amd. Keb', 'HABIBI, Amd. Kep', 'MUHAMMAD LUKMANUR HAYADI, S.Kep, Ns', 'ZEKARIYA WEIS SUYUTHI, S.Kep, Ns', 'INDAH KUSUMA WARDANI, Amd. Gz', 'ZAINI', 'SUHARDIANA', 'ALIF NAINI, S.Tr. Keb', 'AHMAD YANI, S.Kep, Ns', 'EDY SANTOSO', 'SYAIFUL BAHRI, Amd. Kes. Gi', 'MAIMUNA', 'YENI RAHMAWATI, Amd. Kep', 'KADAR RUSMAN, Amd. Kep', 'MOCH ZUHRI', 'RIA HADIYANA, Amd.Keb', 'IFADHATUL INSANIYAH, S.Tr, Keb', 'DEVI PISCEYANTI, S.Farm, Apt', 'YAMA RIAMA, Amd. Kep', 'NISA OKTAVIANA, S.Kep, Ns', 'USWATUN HASANAH, Amd. Keb', 'MARPUAH, S.ST. Keb', 'AH. RASIHAN ANWAR, Amd. Kep', 'ATIYATUN NURANIYAH, AMd. Keb', 'ONY WAHYU JATMIKO, Amd. Kep', 'TITIN NUR SETYAWATI, S .Gz', 'HARIYANTO, Amd. Kep', 'MALTUFAH TIM ANAH BAHRI, Amd. Keb', 'MOHAMMAD KHAIRIL ANWAR, Amd. Kep', 'dr. DESI EKA INDRAYANI', 'EKO SULISTIONO, S.Kep, Ns', 'MOH. MAWARI', 'MOHAMMAD ASAD, S.Kep, Ns', 'IDA SOEMARLIN, Amd. Kep', 'FATMAWATI, S.Kep, Ns', 'FAUZI, S.Kep, Ns', 'FAJAR SIDIK, Amd. Kep', 'SYARIF HIDAYATULLAH, S.AN', 'WAHID HASYIM', 'SANTI DINIYAH, Amd. Kep', 'ACH. WIYONO SANUSI, Amd. Kep', 'LUK LUUL JANNATUL FITRIYAH, Amd. Kes', 'DIAN DWI SASTRAWATI, Amd. Keb', 'DINNA ERFIANA WATI, S.Kep, Ns', 'MOH. FACHRUR RASI, Amd. Kep', 'SUHARJO', 'Romzan Alfiriza Robby', 'DESI PUTRI HERMAWATI', 'ABDUL WARIS', 'SELLY WIDIYA RAHMAN, Amd. Keb', 'MOHAMMAD HASIN, S.Kep.Ns', 'dr. SITI FITRIA NINGSIH', 'YUSNIAWATI FITROH, S.ST. Keb', 'NURUL MUHSINAH, A.Md.Keb', 'EKA DEVI YULIATI, A.Md.Keb', 'Subaidi', 'dr. R.B.M. RAMDHAN AKBAR', 'ROBIATUL ANDAWIYAH, S.Ak', 'NUR HASANAH, A.Md.Kep ', 'TOTOK HERMAN SUGIARTO, A.Md.Kep', 'ZULAIDAH, A.Md.Keb', 'DEWI SRI WAHYUNINGSIH, A.Md.Keb', 'SITI NURAINI, A.Md.Keb', 'SITI SUBAIDAH USRI, A.Md.Keb', 'SITI AISYAH, A.Md.Keb', 'RATNA JUWITA SARI, Amd.Keb'];
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
	ulangButton.style.display = "block";
	simpanButton.style.display = "block";
	clearInterval(intervalHandle);
    headerOne.innerHTML = '{{ $pemenang->nama }}';
    headerAdd.innerHTML = '{{ $pemenang->nik }}';
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