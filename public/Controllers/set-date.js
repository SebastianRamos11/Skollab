const initialDateField = document.getElementById('date');
// Set current date

let currentDate = new Date();
currentDate = `${currentDate.getFullYear()}-${currentDate.getMonth()}-${currentDate.getDate()}`;

const padDate = str => {
  const arr = str.split('-');
  for (let i = 0; i < arr.length; i++) {
    if (arr[i].length === 1) arr[i] = arr[i].padStart(2, '0');
  }
  return arr.join('-');
};

initialDateField.value = padDate(currentDate);
