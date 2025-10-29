@extends('teacher.index')

@section('header-content')
    Lịch dạy
@endsection

@section('content')
    <div class="col-md-12 d-flex justify-content-center">
        <div class="w-90"
            style="background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); margin-top:20px;">
            <div class="calendar-container">
                <div class="calendar-header d-flex justify-content-center align-items-center gap-3 mb-3">
                    <button id="prevMonth" class="btn btn-outline-primary btn-sm px-3 py-1">‹</button>
                    <h1 id="monthYear" class="m-0 fs-5 fw-bold text-primary"></h1>
                    <button id="nextMonth" class="btn btn-outline-primary btn-sm px-3 py-1">›</button>
                </div>
                <div class="calendar mt-3" id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Modal hiển thị danh sách lớp -->
    <div class="modal fade" id="dayModal" tabindex="-1" aria-labelledby="dayModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="dayModalLabel">Danh sách lớp</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Nội dung danh sách lớp sẽ được thêm ở đây -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Truyền dữ liệu PHP sang JS -->
    <script>
        window.CLASS_SCHEDULES = {!! $schedules !!};
        window.BASE_URL = "{{ url('') }}";
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const CLASS_SCHEDULES = window.CLASS_SCHEDULES || [];
            const monthYear = document.getElementById("monthYear");
            const calendar = document.getElementById("calendar");
            const prevMonthBtn = document.getElementById("prevMonth");
            const nextMonthBtn = document.getElementById("nextMonth");

            const monthNames = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7",
                "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
            ];
            let current = new Date();

            function groupByDay(data, date) {
                const month = date.getMonth() + 1;
                const year = date.getFullYear();
                const filtered = data.filter(item => {
                    const d = new Date(item.date);
                    return d.getMonth() + 1 === month && d.getFullYear() === year;
                });

                const map = {};
                filtered.forEach(item => {
                    const day = new Date(item.date).getDate();
                    if (!map[day]) map[day] = [];
                    map[day].push(item);
                });
                return map;
            }

            function renderCalendarWithEvents(date, eventsByDay) {
                calendar.innerHTML = "";
                const year = date.getFullYear();
                const month = date.getMonth();
                monthYear.textContent = `${monthNames[month]} - ${year}`;

                const firstDay = (new Date(year, month, 1).getDay() + 6) % 7;
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                const dayNames = ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"];
                dayNames.forEach(name => {
                    const el = document.createElement("div");
                    el.classList.add("day-name");
                    el.textContent = name;
                    calendar.appendChild(el);
                });

                // Ô trống đầu tháng
                for (let i = 0; i < firstDay; i++) {
                    const el = document.createElement("div");
                    el.classList.add("day", "day--disabled");
                    calendar.appendChild(el);
                }

                const today = new Date();

                for (let i = 1; i <= daysInMonth; i++) {
                    const el = document.createElement("div");
                    el.classList.add("day");

                    if (today.getDate() === i && today.getMonth() === month && today.getFullYear() === year) {
                        el.classList.add("today");
                    }

                    const dateEl = document.createElement("div");
                    dateEl.classList.add("date-number");
                    dateEl.textContent = i;
                    el.appendChild(dateEl);

                    const dayEvents = eventsByDay[i] || [];
                    dayEvents.slice(0, 2).forEach(ev => {
                        const evEl = document.createElement("div");
                        evEl.classList.add("event");
                        evEl.innerHTML =
                            `<strong>${ev.class_name}</strong><br><small>${ev.time_start} - ${ev.time_end}</small>`;

                        evEl.addEventListener("click", () => {
                            window.location.href =
                                `${window.BASE_URL}/teacher/class-details/${ev.class_id}?date=${ev.date}`;
                        });

                        el.appendChild(evEl); // ✅ append ngoài click event
                    });


                    if (dayEvents.length > 2) {
                        const moreEl = document.createElement("div");
                        moreEl.classList.add("event", "more");
                        moreEl.textContent = `+${dayEvents.length - 2} lớp khác`;
                        moreEl.addEventListener("click", () => {
                            const modalContent = document.getElementById("modalContent");
                            modalContent.innerHTML = "";
                            dayEvents.forEach(ev => {
                                const div = document.createElement("div");
                                div.classList.add("mb-2");
                                div.innerHTML =
                                    `<strong>${ev.class_name}</strong> (${ev.time_start} - ${ev.time_end})`;
                                div.addEventListener("click", () => {
                                    window.location.href =
                                        `${window.BASE_URL}/teacher/class-details/${ev.class_id}?date=${ev.date}`;
                                });
                                modalContent.appendChild(div);
                            });
                            const modal = new bootstrap.Modal(document.getElementById(
                                "dayModal"));
                            modal.show();
                        });
                        el.appendChild(moreEl);
                    }

                    calendar.appendChild(el);
                }
            }

            function renderCalendar(date) {
                const eventsByDay = groupByDay(CLASS_SCHEDULES, date);
                renderCalendarWithEvents(date, eventsByDay);
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
        });
    </script>

    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
        }

        .day,
        .day-name {
            min-height: 110px;
            border: 1px solid #e0e0e0;
            padding: 5px;
            background: #ffffff;
            border-radius: 10px;
            transition: background 0.2s ease;
        }

        .day:hover {
            background: #f1f6ff;
        }

        .day-name {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            color: #1a237e;
            font-weight: 600;
            text-align: center;
            min-height: 40px;
            line-height: 40px;
            border-radius: 6px;
            border: 1px solid #cfd8dc;
            box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.05);
        }

        .day--disabled {
            background: #f5f5f5;
            color: #aaa;
        }

        .today {
            border: 2px solid #007bff;
            background: #eaf2ff;
        }

        .event {
            background: #4e73df;
            color: white;
            padding: 4px 6px;
            border-radius: 5px;
            font-size: 12px;
            margin-top: 5px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .event:hover {
            background: #3756c3;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .event.more {
            background: #6c757d;
        }

        .date-number {
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
        }
    </style>
@endsection
