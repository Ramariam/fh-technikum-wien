console.log('test')


let Firstnumber
let Secondnumber
let step = 0
let operation
let result = 0

let numArray = []
let secondArray = []

let display = document.getElementById('display')
let history = document.getElementById('History')

function getNumber(num){
   if(step === 0 || step === 1){
       numArray.push(num)
       step = 1
       Firstnumber = Number(numArray.join('')) //merge into one string
       display.value = Firstnumber
   } else if (step === 2){
     secondArray.push(num)
     Secondnumber = Number(secondArray.join(''))
     display.value = Secondnumber
   }
}

function getOperator(op){
    step = 2
    operation = op 
}



function calculateResult() {
    console.log('first number', Firstnumber, 'second number', Secondnumber)

    if(operation === '+'){
           result =  Firstnumber + Secondnumber
           display.value = result
    } else if (operation === '-'){
           result = Firstnumber - Secondnumber
           display.value = result 
    } else if (operation === '*'){
           result = Firstnumber * Secondnumber
           display.value = result 
    } else if (operation === '/'){
           result = Firstnumber / Secondnumber
           display.value = result 
    }
    addToHistory(Firstnumber, operation, Secondnumber, result)
}

function addToHistory(Firstnumber, operation, Secondnumber, result){
    const historyEntry = document.createElement('div')
    historyEntry.textContent  = Firstnumber + ' ' + operation + ' ' + Secondnumber+ ' = ' + result;
    history.appendChild(historyEntry)
}

function clearDisplay(){
    display.value = 0
    Firstnumber = null
    Secondnumber = null
    step = 0
    operation = 0
    result = 0
    numArray = []
    secondArray = []
}


