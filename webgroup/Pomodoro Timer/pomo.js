let pomodoro = document.getElementById('pomodoro-timer');
let short = document.getElementById('short-timer');
let long = document.getElementById('long-timer');
let timers = document.querySelectorAll('.timer-display');
let session = document.getElementById('pomodoro-session');
let shortBrake = document.getElementById('short-brake');
let longBrake = document.getElementById('long-brake');
let startBtn = document.getElementById('start');
let stopBtn = document.getElementById('stop');
let timerMsg = document.getElementById('timer-msg');
let button = document.querySelector(".button");

let currentTimer = null;
let myInterval = null;

function showDefaultTimer(){
    pomodoro.style.display = "block";
    short.style.display = "none";
    long.style.display = "none";
}

showDefaultTimer()


function hideAll(){
    timers.forEach((timer) => {
        timer.style.display = "none";
    })
}

shortBrake.addEventListener("click", () => {
    hideAll();

    short.style.display = "block";

    session.classList.remove("active");
    shortBrake.classList.add("active");
    longBrake.classList.remove("active");

    
    currentTimer = short;

})

session.addEventListener("click", () => {
    hideAll();
    pomodoro.style.display = "block";
    session.classList.add("active");
    shortBrake.classList.remove("active");
    longBrake.classList.remove("active");

    currentTimer = pomodoro;
})

longBrake.addEventListener("click", () => {
    hideAll();

    long.style.display = "block";

    session.classList.remove("active");
    shortBrake.classList.remove("active");
    longBrake.classList.add("active");

    
    currentTimer = long;
})

//start demu
function startTimer(timerDisplay){
    if(myInterval){
        clearInterval(myInterval)
    }

    timerDuration = timerDisplay.getAttribute("data-duration").split(":")[0];

    let durationInMiliSec = timerDuration * 60 * 1000;
    let endTimeStamp = Date.now() + durationInMiliSec;

    myInterval = setInterval(() => {
        const timeRenaining = new Date(endTimeStamp - Date.now());

        if(timeRenaining < 0){
            clearInterval(myInterval)
            timerDisplay.textContent = "00:00";

            const alarm = new Audio("ding-101492.mp3");
            alarm.play();
        }else{
            const minutes = Math.floor(timeRenaining / 60000);
            const seconds = ((timeRenaining % 60000) / 1000).toFixed(0);
            const formattedTime = `${minutes}:${seconds.toString().padStart(2, "0")}`;
            timerDisplay.textContent = formattedTime

        }

    }, 1000)
}



startBtn.addEventListener('click', () => {
    if(currentTimer){
        startTimer(currentTimer)
        timerMsg.style.display = 'none'; 
    }else{
        timerMsg.style.display = 'block';
    }
})


//stop btn 

stopBtn.addEventListener('click' , () => {
    if(currentTimer){
        clearInterval(myInterval);
    }
})
