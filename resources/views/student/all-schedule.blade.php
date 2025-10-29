@extends('student.index')

@section('header-content')
Lịch học của tôi
@endsection

@section('content')
<div class="col-md-12 d-flex justify-content-center">
    <div class="w-90"
        style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-top:20px;">
        <div class="calendar-container">
            <div class="calendar-header d-flex justify-content-center align-items-center gap-2">
                <button id="prevMonth" class="btn btn-light btn-sm px-2 py-1">‹</button>
                <h1 id="monthYear" class="m-0 fs-5 fw-bold"></h1>
                <button id="nextMonth" class="btn btn-light btn-sm px-2 py-1">›</button>
            </div>
            <div class="calendar mt-3" id="calendar"></div>
        </div>
    </div>
</div>

<!-- Truyền dữ liệu cho js -->
<script>
    window.CLASS_SCHEDULES = {!! $schedules !!};
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const CLASS_SCHEDULES = window.CLASS_SCHEDULES || [];
        const CLASS_ID = window.CLASS_ID;
        const monthYear = document.getElementById("monthYear");
        const calendar = document.getElementById("calendar");
        const prevMonthBtn = document.getElementById("prevMonth");
        const nextMonthBtn = document.getElementById("nextMonth");

        const monthNames = [
            "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
            "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
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
            // ✅ Thêm dấu “-” giữa tháng và năm
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

            for (let i = 0; i < firstDay; i++) {
                const el = document.createElement("div");
                el.classList.add("day", "day--disabled");
                calendar.appendChild(el);
            }

            for (let i = 1; i <= daysInMonth; i++) {
                const el = document.createElement("div");
                el.classList.add("day");

                const dateEl = document.createElement("div");
                dateEl.classList.add("date-number");
                dateEl.textContent = i;
                el.appendChild(dateEl);

                const dayEvents = eventsByDay[i] || [];
                dayEvents.forEach(ev => {
                    const evEl = document.createElement("div");
                    evEl.classList.add("event");
                    evEl.innerHTML = `
                        <strong>${ev.class_name}</strong><br>
                        GV: ${ev.teacher_name}<br>
                        ${ev.time_start} - ${ev.time_end}
                    `;

                    // Khi click vào lịch => chuyển tới trang điểm danh
                    

                    el.appendChild(evEl);
                });

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
        gap: 5px;
    }

    .day,
    .day-name {
        min-height: 100px;
        border: 1px solid #ddd;
        padding: 5px;
        background: #fafafa;
        position: relative;
        border-radius: 6px;
    }

    .day-name {
        background: #f8f9fa;
        font-weight: bold;
        text-align: center;
        min-height: 40px;
        /* ✅ Thu ngắn chiều cao */
        line-height: 40px;
        border-radius: 6px;
    }

    .day--disabled {
        background: #f1f1f1;
        color: #aaa;
    }

    .event {
        background: #4e73df;
        color: white;
        padding: 3px 5px;
        border-radius: 4px;
        font-size: 12px;
        margin-top: 4px;
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
        /* hiệu ứng mượt khi hover */
    }

    .event:hover {
        background: #637ee4;
        /* sáng hơn */
        transform: translateY(-2px);
        /* hơi nổi lên một chút */
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        /* thêm bóng nhẹ */
    }


    .date-number {
        font-weight: bold;
    }
</style>
@endsection