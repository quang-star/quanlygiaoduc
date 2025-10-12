const monthYear = document.getElementById("monthYear");
  const calendar = document.getElementById("calendar");
  const prevMonthBtn = document.getElementById("prevMonth");
  const nextMonthBtn = document.getElementById("nextMonth");

  const monthNames = ["Tháng 1","Tháng 2","Tháng 3","Tháng 4","Tháng 5","Tháng 6",
                      "Tháng 7","Tháng 8","Tháng 9","Tháng 10","Tháng 11","Tháng 12"];

  let current = new Date();

  function renderCalendar(date) {
    calendar.innerHTML = "";
    const year = date.getFullYear();
    const month = date.getMonth();
    monthYear.textContent = `${monthNames[month]} ${year}`;

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const prevDays = new Date(year, month, 0).getDate();

    const start = firstDay === 0 ? 6 : firstDay - 1;

    const dayNames = ["T2", "T3", "T4", "T5", "T6", "T7", "CN"];
    dayNames.forEach(name => {
      const el = document.createElement("div");
      el.classList.add("day-name");
      el.textContent = name;
      calendar.appendChild(el);
    });

    for (let i = 0; i < start; i++) {
      const el = document.createElement("div");
      el.classList.add("day", "day--disabled");
      el.textContent = prevDays - start + i + 1;
      calendar.appendChild(el);
    }

    for (let i = 1; i <= daysInMonth; i++) {
      const el = document.createElement("div");
      el.classList.add("day");
      el.textContent = i;
      calendar.appendChild(el);
    }
  }

  prevMonthBtn.addEventListener("click", () => {
    current.setMonth(current.getMonth() - 1);
    renderCalendar(current);
  });

  nextMonthBtn.addEventListener("click", () => {
    current.setMonth(current.getMonth() + 1);
    renderCalendar(current);
  });

  renderCalendar(current);