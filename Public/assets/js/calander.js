document.addEventListener("DOMContentLoaded", () => {
  // --- STATE ---
  let currentDate = new Date();
  let events = []; // Example: { date: '2025-10-20', title: 'My Event', time: '10:30', description: '...' }

  // --- DOM ELEMENTS ---
  const componentWrapper = document.querySelector(".calendar-component"); // Get main container
  const currentMonthYear = document.getElementById("current-month-year");
  const calendarGrid = document.getElementById("calendar-grid");
  const prevBtn = document.getElementById("prev-month-btn");
  const nextBtn = document.getElementById("next-month-btn");
  const modal = document.getElementById("event-modal");
  const eventForm = document.getElementById("event-form");
  const eventDateInput = document.getElementById("event-date");
  const eventTitleInput = document.getElementById("event-title");
  const eventTimeInput = document.getElementById("event-time");
  const eventDescriptionInput = document.getElementById("event-description");
  const tooltip = document.getElementById("event-tooltip");
  const closeBtn = modal.querySelector(".close-btn");
  const cancelBtn = document.getElementById("cancel-btn");

  /** Renders the calendar grid for the current month */
  function renderCalendar() {
    calendarGrid.innerHTML = "";
    const month = currentDate.getMonth();
    const year = currentDate.getFullYear();
    currentMonthYear.textContent = new Intl.DateTimeFormat("en-US", {
      year: "numeric",
      month: "long",
    }).format(currentDate);

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
      const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(
        day
      ).padStart(2, "0")}`;

      const today = new Date();
      if (
        year === today.getFullYear() &&
        month === today.getMonth() &&
        day === today.getDate()
      ) {
        dayCell.classList.add("current-day");
      }

      events
        .filter((e) => e.date === dateStr)
        .forEach((event) => {
          const eventPill = document.createElement("div");
          eventPill.classList.add("event-pill");
          eventPill.textContent = event.title;
          eventPill.dataset.time = event.time;
          eventPill.dataset.description = event.description;
          dayCell.appendChild(eventPill);
        });

      dayCell.addEventListener("click", () => openModal(dateStr));
      calendarGrid.appendChild(dayCell);
    }
    addTooltipListeners();
  }

  /** Add hover listeners to all event pills */
  function addTooltipListeners() {
    const eventPills = document.querySelectorAll(".event-pill");
    // Get the position of the calendar component itself
    const componentRect = componentWrapper.getBoundingClientRect();

    eventPills.forEach((pill) => {
      pill.addEventListener("mousemove", (e) => {
        tooltip.style.display = "block";

        // *** THIS IS THE CORRECTED PART ***
        // Calculate the mouse position RELATIVE to the component
        const x = e.clientX - componentRect.left;
        const y = e.clientY - componentRect.top;

        // Position the tooltip relative to the component with a small offset
        tooltip.style.left = x + 10 + "px";
        tooltip.style.top = y + 10 + "px";

        const time = pill.dataset.time;
        const description = pill.dataset.description || "No description.";

        tooltip.innerHTML = `
                    <h4>${pill.textContent}</h4>
                    <p class="time">${time ? `Time: ${time}` : ""}</p>
                    <p>${description}</p>
                `;
      });
      pill.addEventListener("mouseleave", () => {
        tooltip.style.display = "none";
      });
    });
  }

  function openModal(date) {
    modal.style.display = "flex";
    eventForm.reset();
    eventDateInput.value = date;
    eventTitleInput.focus();
  }

  function closeModal() {
    modal.style.display = "none";
  }

  // --- EVENT LISTENERS ---
  prevBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
  });

  nextBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
  });

  eventForm.addEventListener("submit", (e) => {
    e.preventDefault();
    events.push({
      date: eventDateInput.value,
      title: eventTitleInput.value,
      time: eventTimeInput.value,
      description: eventDescriptionInput.value,
    });
    closeModal();
    renderCalendar();
  });

  closeBtn.addEventListener("click", closeModal);
  cancelBtn.addEventListener("click", closeModal);
  window.addEventListener("click", (e) => {
    if (e.target === modal) closeModal();
  });

  // --- INITIAL RENDER ---
  renderCalendar();
});
