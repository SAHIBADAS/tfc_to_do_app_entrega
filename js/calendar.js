import { DomElements } from "./domElements.js";
import { fillInputs } from "./serverRequest.js";

document.addEventListener("DOMContentLoaded", () => {
    let currentDate = new Date();

    // 🟡 Obtener tareas por día con color
    async function fetchTasksByDay() {
        try {
            const response = await fetch("../api/tasks.php");
            const tasks = await response.json();
            const tasksByDay = {};

            tasks.forEach(task => {
                if (task.estimacion && task.estimacion !== "0000-00-00") {
                    const taskDate = new Date(task.estimacion);
                    const taskDay = taskDate.getDate();

                    const isSameMonth = (
                        taskDate.getFullYear() === currentDate.getFullYear() &&
                        taskDate.getMonth() === currentDate.getMonth()
                    );

                    if (isSameMonth) {
                        if (!tasksByDay[taskDay]) {
                            tasksByDay[taskDay] = [];
                        }

                        tasksByDay[taskDay].push({
                            color: task.color_agenciado || "#999", // valor por defecto si falta
                            id: task.id
                        });
                    }
                }
            });

            return tasksByDay;
        } catch (error) {
            console.error("Error al obtener las tareas:", error);
            return {};
        }
    }

    // 🟡 Renderizar calendario
    async function renderCalendar() {
        DomElements.calendarGrid.textContent = "";
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const today = new Date();

        const localeMonthYear = currentDate.toLocaleDateString("es-ES", { month: "long", year: "numeric" });
        DomElements.monthYear.textContent = localeMonthYear.charAt(0).toUpperCase() + localeMonthYear.slice(1);

        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();
        const startDay = (firstDay === 0 ? 6 : firstDay - 1);

        const tasksByDay = await fetchTasksByDay();

        // 🔹 Días del mes anterior
        for (let i = startDay; i > 0; i--) {
            const day = daysInPrevMonth - i + 1;
            const dateToCheck = new Date(year, month - 1, day);

            const dayElement = document.createElement("div");
            dayElement.classList.add("calendar-day", "prev-month");
            dayElement.textContent = day;

            if (isSameDay(dateToCheck, today)) {
                dayElement.classList.add("today");
            }

            DomElements.calendarGrid.appendChild(dayElement);
        }

        // 🔹 Días del mes actual
        for (let i = 1; i <= lastDate; i++) {
            const dayElement = document.createElement("div");
            dayElement.classList.add("calendar-day");
            dayElement.textContent = i;

            const currentDayDate = new Date(year, month, i);
            if (isSameDay(currentDayDate, today)) {
                dayElement.classList.add("today");
            }

            if (tasksByDay[i]) {
                const container = document.createElement("div");
                container.classList.add("with-task-container");

                tasksByDay[i].slice(0, 9).forEach(task => {
                    const taskIndicator = document.createElement("div");
                    taskIndicator.classList.add("with-task");
                    taskIndicator.style.backgroundColor = task.color;
                    taskIndicator.dataset.taskId = task.id;

                    container.appendChild(taskIndicator);

                    taskIndicator.addEventListener("click", () => {
                        const chat = document.getElementById("chat");
                        const editTask = document.getElementById("edit-task");
                        const newTask = document.getElementById("newtask");

                        chat.style.display = "none";
                        newTask.style.display = "none";
                        editTask.style.display = "flex";

                        fillInputs(task.id);
                    });
                });


                dayElement.appendChild(container);
            }

            DomElements.calendarGrid.appendChild(dayElement);
        }

        // 🔹 Días del mes siguiente
        const totalCells = DomElements.calendarGrid.children.length;
        for (let i = totalCells; i < 42; i++) {
            const day = i - totalCells + 1;
            const dateToCheck = new Date(year, month + 1, day);

            const dayElement = document.createElement("div");
            dayElement.classList.add("calendar-day", "next-month");
            dayElement.textContent = day;

            if (isSameDay(dateToCheck, today)) {
                dayElement.classList.add("today");
            }

            DomElements.calendarGrid.appendChild(dayElement);
        }
    }

    function isSameDay(date1, date2) {
        return (
            date1.getFullYear() === date2.getFullYear() &&
            date1.getMonth() === date2.getMonth() &&
            date1.getDate() === date2.getDate()
        );
    }

    DomElements.prevMonth.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    DomElements.nextMonth.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    renderCalendar();
});
