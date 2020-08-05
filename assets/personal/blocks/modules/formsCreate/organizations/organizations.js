let today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();

let months = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август",
  "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];

let monthAndYear = document.getElementById("monthAndYear");
const days = document.getElementById('days');
if (days != null) {
  const childDays = days.childNodes;
  childDays.forEach(child => {
    child.addEventListener('click', () => {
      child.classList.toggle('active');
    });
  });

}
if (monthAndYear != null) {
  showCalendar(currentMonth, currentYear);

  document.getElementById('next').addEventListener('click', () => {
    currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    showCalendar(currentMonth, currentYear);
  });

  document.getElementById('previous').addEventListener('click', () => {
    currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    showCalendar(currentMonth, currentYear);
  });

  function showCalendar(month, year) {

    let firstDay = (new Date(year, month)).getDay();
    let daysInMonth = 32 - new Date(year, month, 32).getDate();

    let tbl = document.getElementById("calendar-body"); // body of the calendar

    // clearing all previous cells
    tbl.innerHTML = "";

    // filing data about month and in the page via DOM.
    monthAndYear.innerHTML = months[month] + " " + year;

    // creating all cells
    let date = 1;
    for (let i = 0; i < 6; i++) {
      // creates a table row
      let row = document.createElement("tr");

      //creating individual cells, filing them up with data.
      for (let j = 0; j < 7; j++) {
        if (i === 0 && j < firstDay - 1) {
          let cell = document.createElement("td");
          let cellText = document.createTextNode("");
          cell.appendChild(cellText);
          row.appendChild(cell);
        }
        else if (date > daysInMonth) {
          break;
        }
        else {
          let cell = document.createElement("td");
          let cellText = document.createTextNode(date);
          if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
            cell.classList.add("current");
          }
          cell.addEventListener('click', () => {
            cell.classList.toggle('active');
          });
          cell.appendChild(cellText);
          row.appendChild(cell);
          date++;
        }


      }

      tbl.appendChild(row); // appending each row into calendar body.
    }

  }
}
