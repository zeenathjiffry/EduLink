function renderCalendar() {
  calendarGrid.innerHTML = "";

  const month = currentDate.getMonth();
  const year = currentDate.getFullYear();

  currentMonthYear.textContent = new Intl.DateTimeFormat("en-US", {
    year: "numeric",
    month: "long",
  }).format(currentDate);

  // Weekday headers
  const weekdays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  weekdays.forEach((day) => {
    const weekdayCell = document.createElement("div");
    weekdayCell.classList.add("calendar-weekday");
    weekdayCell.textContent = day;
    calendarGrid.appendChild(weekdayCell);
  });

  const firstDayOfMonth = new Date(year, month, 1);
  const startDayOfWeek = firstDayOfMonth.getDay();

  for (let i = 0; i < startDayOfWeek; i++) {
    const emptyCell = document.createElement("div");
    emptyCell.classList.add("calendar-day", "empty");
    calendarGrid.appendChild(emptyCell);
  }

  const daysInMonth = new Date(year, month + 1, 0).getDate();
  for (let day = 1; day <= daysInMonth; day++) {
    const dayCell = document.createElement("div");
    dayCell.classList.add("calendar-day");
    dayCell.innerHTML = `<div class="day-number">${day}</div>`;

    const today = new Date();
    if (
      year === today.getFullYear() &&
      month === today.getMonth() &&
      day === today.getDate()
    ) {
      dayCell.classList.add("current-day");
    }

    const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(
      day
    ).padStart(2, "0")}`;

    // Add events
    studentEvents.forEach((event) => {
      if (event.date === dateStr) {
        const eventDiv = document.createElement("div");
        eventDiv.classList.add("event-pill");
        eventDiv.textContent = event.title;
        dayCell.appendChild(eventDiv);

        eventDiv.addEventListener("click", (e) => {
          e.stopPropagation();
          openModal(event.date);
          document.getElementById("event-title").value = event.title;
          document.getElementById("event-description").value =
            event.description;
          document.getElementById("event-time").value = event.time;
        });
      }
    });

    dayCell.addEventListener("click", () => openModal(dateStr));
    calendarGrid.appendChild(dayCell);
  }
}

// Initial setup
const calendarGrid = document.getElementById("calendar-grid");
const currentMonthYear = document.getElementById("current-month-year");
let currentDate = new Date();
renderCalendar();

// Month navigation
document.getElementById("prev-month-btn").addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar();
});
document.getElementById("next-month-btn").addEventListener("click", () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar();
});
